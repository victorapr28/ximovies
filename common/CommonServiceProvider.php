<?php

namespace Common;

use Common\Admin\Analytics\AnalyticsServiceProvider;
use Common\Admin\Appearance\Themes\CssTheme;
use Common\Admin\Appearance\Themes\CssThemePolicy;
use Common\Auth\BaseUser;
use Common\Auth\Permissions\Permission;
use Common\Auth\Permissions\Policies\PermissionPolicy;
use Common\Auth\Roles\Role;
use Common\Billing\BillingPlan;
use Common\Billing\Invoices\Invoice;
use Common\Billing\Invoices\InvoicePolicy;
use Common\Billing\Listeners\SyncPlansWhenBillingSettingsChange;
use Common\Billing\Subscription;
use Common\Billing\SyncBillingPlansCommand;
use Common\Comments\Comment;
use Common\Comments\CommentPolicy;
use Common\Core\Bootstrap\BaseBootstrapData;
use Common\Core\Bootstrap\BootstrapData;
use Common\Core\Commands\SeedCommand;
use Common\Core\Contracts\AppUrlGenerator;
use Common\Core\Middleware\IsAdmin;
use Common\Core\Middleware\JsonMiddleware;
use Common\Core\Middleware\PrerenderIfCrawler;
use Common\Core\Middleware\RestrictDemoSiteFunctionality;
use Common\Core\Policies\AppearancePolicy;
use Common\Core\Policies\BillingPlanPolicy;
use Common\Core\Policies\FileEntryPolicy;
use Common\Core\Policies\LocalizationPolicy;
use Common\Core\Policies\MailTemplatePolicy;
use Common\Core\Policies\PagePolicy;
use Common\Core\Policies\ReportPolicy;
use Common\Core\Policies\RolePolicy;
use Common\Core\Policies\SettingPolicy;
use Common\Core\Policies\SubscriptionPolicy;
use Common\Core\Policies\TagPolicy;
use Common\Core\Policies\UserPolicy;
use Common\Core\Prerender\BaseUrlGenerator;
use Common\Domains\CustomDomain;
use Common\Domains\CustomDomainPolicy;
use Common\Domains\CustomDomainsEnabled;
use Common\Files\Commands\DeleteUploadArtifacts;
use Common\Files\FileEntry;
use Common\Files\Providers\Backblaze\BackblazeServiceProvider;
use Common\Files\Providers\DigitalOceanServiceProvider;
use Common\Files\Providers\DropboxServiceProvider;
use Common\Files\Providers\DynamicStorageDiskProvider;
use Common\Localizations\Commands\ExportTranslations;
use Common\Localizations\Commands\GenerateFooTranslations;
use Common\Localizations\Listeners\UpdateAllUsersLanguageWhenDefaultLocaleChanges;
use Common\Localizations\Localization;
use Common\Mail\MailTemplate;
use Common\Notifications\NotificationSubscription;
use Common\Notifications\NotificationSubscriptionPolicy;
use Common\Pages\CustomPage;
use Common\SEttings\Events\SettingsSaved;
use Common\Settings\Setting;
use Common\Tags\Tag;
use Config;
use DB;
use Event;
use Gate;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\SocialiteServiceProvider;
use Validator;

require_once 'helpers.php';

class CommonServiceProvider extends ServiceProvider
{
    const CONFIG_FILES = [
        'permissions', 'default-settings', 'site',
        'demo', 'mail-templates', 'setting-validators', 'menus'
    ];

    /**
     * @param Application $app
     */
    public function __construct($app)
    {
        parent::__construct($app);
        $app->instance('path.common', base_path('common'));
    }

    /**
     * @return void
     */
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/routes.php');
        $this->loadMigrationsFrom(__DIR__.'/Database/migrations');
        $this->loadViewsFrom(app('path.common') . '/resources/views', 'common');

        $this->registerPolicies();
        $this->registerCustomValidators();
        $this->registerCommands();
        $this->registerMiddleware();
        $this->registerCollectionExtensions();
        $this->registerEventListeners();

        $configs = collect(self::CONFIG_FILES)->mapWithKeys(function($file) {
            return [app('path.common') . "/resources/config/$file.php" => config_path("common/$file.php")];
        })->toArray();

        $this->publishes($configs);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfig();

        $request = $this->app->make(Request::class);
        $this->dynamicallyUpdateAppUrl($request);
        $this->normalizeRequestUri($request);
        app('url')->forceRootUrl(config('app.url'));

        $this->registerHtmlBaseUri();

        $loader = AliasLoader::getInstance();

        // register socialite service provider and alias
        $this->app->register(SocialiteServiceProvider::class);
        $this->app->register(AnalyticsServiceProvider::class);
        $loader->alias('Socialite', Socialite::class);

        // url generator for SEO
        $this->app->bind(
            AppUrlGenerator::class,
            BaseUrlGenerator::class
        );

        // bootstrap data
        $this->app->bind(
            BootstrapData::class,
            BaseBootstrapData::class
        );

        $this->registerDevProviders();

        // register flysystem providers
        $this->app->register(DynamicStorageDiskProvider::class);
        if ($this->storageDriverSelected('dropbox')) {
            $this->app->register(DropboxServiceProvider::class);
        }
        if ($this->storageDriverSelected('digitalocean')) {
            $this->app->register(DigitalOceanServiceProvider::class);
        }
        if ($this->storageDriverSelected('backblaze')) {
            $this->app->register(BackblazeServiceProvider::class);
        }
    }


    private function mergeConfig()
    {
        $this->deepMergeDefaultSettings(app('path.common') . "/resources/config/default-settings.php", "common.default-settings");
        $this->deepMergeConfigFrom(app('path.common') . "/resources/config/demo-blocked-routes.php", "common.demo-blocked-routes");
        $this->deepMergeConfigFrom(app('path.common') . "/resources/config/mail-templates.php", "common.mail-templates");
        $this->mergeConfigFrom(app('path.common') . "/resources/config/site.php", "common.site");
        $this->mergeConfigFrom(app('path.common') . "/resources/config/setting-validators.php", "common.setting-validators");
        $this->mergeConfigFrom(app('path.common') . "/resources/config/menus.php", "common.menus");
        $this->mergeConfigFrom(app('path.common') . "/resources/config/appearance.php", "common.appearance");
        $this->mergeConfigFrom(app('path.common') . "/resources/config/services.php", "services");

        $this->mergeConfigFrom(app('path.common') . "/resources/config/seo/custom-page/show.php", "seo.custom-page.show");
        $this->mergeConfigFrom(app('path.common') . "/resources/config/seo/common.php", "seo.common");
    }

    /**
     * @param Request $request
     */
    private function dynamicallyUpdateAppUrl(Request $request)
    {
        $appHost = parse_url(config('app.url'))['host'];
        $requestHost = $request->getHost();

        // TODO: if only protocol or "www" changed as use dynamic update, if hosts don't match use custom domains

        if ($requestHost !== $appHost) {
            $protocol = $request->isSecure() ? 'https://' : 'http://';
            $newUrlWithProtocol = "{$protocol}{$requestHost}";

            if (config('common.site.enable_custom_domains')) {
                $domain = DB::table('custom_domains')
                    ->where('host', $requestHost)
                    ->orWhere('host', $newUrlWithProtocol)
                    ->first();
            }

            // if request is coming from different host, update
            // app.url, if that host is attached as custom domain
            if (isset($domain)) {
                $this->app->instance('matchedCustomDomain', $domain);
                config(['app.url' => $domain->host]);

            // otherwise just set current request url and app url
            }  else if (config('common.site.dynamic_app_url')) {
                config(['app.url' => $newUrlWithProtocol]);

                // update social auth urls as well
                foreach (config('services') as $serviceName => $serviceConfig) {
                    if (isset($serviceConfig['redirect'])) {
                        Config::set("services.$serviceName.redirect", "$newUrlWithProtocol/secure/auth/social/$serviceName/callback");
                    }
                }
            }
        }
    }

    /**
     * Remove sub-directory from request uri, so as far as laravel/symfony
     * is concerned request came from public directory, even if request
     * was redirected from root laravel folder to public via .htaccess
     *
     * This will solve issues where requests redirected from laravel root
     * folder to public via .htaccess (or other) redirects are not working
     * if laravel is inside a subdirectory. Mostly useful for shared hosting
     * or local dev where virtual hosts can't be set up properly.
     *
     * @param Request $request
     */
    private function normalizeRequestUri(Request $request)
    {
        $parsedUrl = parse_url(config('app.url'));

        //if there's no subdirectory we can bail
        if ( ! isset($parsedUrl['path'])) return;

        $originalUri = $request->server->get('REQUEST_URI');
        $subdirectory = preg_quote($parsedUrl['path'], '/');
        $normalizedUri = preg_replace("/^$subdirectory/", '', $originalUri);

        //if uri starts with "/public" after normalizing,
        //we can bail as laravel will handle this uri properly
        if (preg_match('/^public/', ltrim($normalizedUri, '/'))) return;

        $request->server->set('REQUEST_URI', $normalizedUri);
    }

    private function registerHtmlBaseUri()
    {
        $htmlBaseUri = '/';

        //get uri for html "base" tag
        if (substr_count(config('app.url'), '/') > 2) {
            $htmlBaseUri = parse_url(config('app.url'))['path'] . '/';
        }

        $this->app->instance('htmlBaseUri', $htmlBaseUri);
    }

    /**
     * Register package middleware.
     */
    private function registerMiddleware()
    {
        // web
        $this->app['router']->aliasMiddleware('isAdmin', IsAdmin::class);
        $this->app['router']->aliasMiddleware('customDomainsEnabled', CustomDomainsEnabled::class);
        $this->app['router']->aliasMiddleware('prerenderIfCrawler', PrerenderIfCrawler::class);

        // api
        $this->app['router']->pushMiddlewareToGroup('api', JsonMiddleware::class);

        // demo site
        if ($this->app['config']->get('common.site.demo')) {
            $this->app['router']->pushMiddlewareToGroup('web', RestrictDemoSiteFunctionality::class);
        }
    }

    /**
     * Register custom validation rules with laravel.
     */
    private function registerCustomValidators()
    {
        Validator::extend('hash', 'Common\Auth\Validators\HashValidator@validate');
        Validator::extend('email_confirmed', 'Common\Auth\Validators\EmailConfirmedValidator@validate');
        Validator::extend('multi_date_format', 'Common\Validation\Validators\MultiDateFormatValidator@validate');
    }

    /**
     * Deep merge the given configuration with the existing configuration.
     *
     * @param  string  $path
     * @param  string  $key
     * @return void
     */
    private function deepMergeConfigFrom($path, $key)
    {
        $config = $this->app['config']->get($key, []);
        $this->app['config']->set($key, array_merge_recursive(require $path, $config));
    }

    private function registerPolicies()
    {
        Gate::policy('App\Model', 'App\Policies\ModelPolicy');
        Gate::policy(FileEntry::class, FileEntryPolicy::class);
        Gate::policy(BaseUser::class, UserPolicy::class);
        Gate::policy(Role::class, RolePolicy::class);
        Gate::policy(CustomPage::class, PagePolicy::class);
        Gate::policy(Setting::class, SettingPolicy::class);
        Gate::policy(Localization::class, LocalizationPolicy::class);
        Gate::policy('AppearancePolicy', AppearancePolicy::class);
        Gate::policy('ReportPolicy', ReportPolicy::class);
        Gate::policy(MailTemplate::class, MailTemplatePolicy::class);
        Gate::policy(BillingPlan::class, BillingPlanPolicy::class);
        Gate::policy(Subscription::class, SubscriptionPolicy::class);
        Gate::policy(CustomDomain::class, CustomDomainPolicy::class);
        Gate::policy(Permission::class, PermissionPolicy::class);
        Gate::policy(Invoice::class, InvoicePolicy::class);
        Gate::policy(CssTheme::class, CssThemePolicy::class);
        Gate::policy(Tag::class, TagPolicy::class);
        Gate::policy(Comment::class, CommentPolicy::class);
        Gate::policy(NotificationSubscription::class, NotificationSubscriptionPolicy::class);

        Gate::define('admin.access', function (BaseUser $user) {
            return $user->hasPermission('admin.access');
        });
    }

    private function registerCommands()
    {
        // register commands
        $commands = [
            SyncBillingPlansCommand::class,
            DeleteUploadArtifacts::class,
            SeedCommand::class,
        ];

        if ($this->app->environment() !== 'production') {
            $commands = array_merge($commands, [
                ExportTranslations::class,
                GenerateFooTranslations::class,
            ]);
        }

        $this->commands($commands);

        // schedule commands
        $this->app->booted(function () {
            $schedule = $this->app->make(Schedule::class);
            $schedule->command('uploads:clean')->daily();
        });
    }

    /**
     * Deep merge "default-settings" config values.
     *
     * @param string $path
     * @param $configKey
     * @return void
     */
    private function deepMergeDefaultSettings($path, $configKey)
    {
        $defaultSettings = require $path;
        $userSettings = $this->app['config']->get($configKey, []);

        foreach ($userSettings as $userSetting) {
            //remove default setting, if it's overwritten by user setting
            foreach ($defaultSettings as $key => $defaultSetting) {
                if ($defaultSetting['name'] === $userSetting['name']) {
                    unset($defaultSettings[$key]);
                }
            }

            //push user setting into default settings array
            $defaultSettings[] = $userSetting;
        }

        $this->app['config']->set($configKey, $defaultSettings);
    }

    private function registerDevProviders()
    {
        if ($this->app->environment() === 'production') return;

        if ($this->ideHelperExists()) {
            $this->app->register(IdeHelperServiceProvider::class);
        }
    }

    private function ideHelperExists() {
        return class_exists(IdeHelperServiceProvider::class);
    }

    private function registerCollectionExtensions()
    {
        // convert all array items to lowercase
        Collection::macro('toLower', function ($key = null) {
            return $this->map(function ($value) use($key) {
                // remove all whitespace and lowercase
                if (is_string($value)) {
                    return slugify($value, ' ');
                } else {
                    $value[$key] = slugify($value[$key], ' ');
                    return $value;
                }
            });
        });
    }

    /**
     * @param string $name
     * @return bool
     */
    protected function storageDriverSelected($name)
    {
        return config('common.site.uploads_disk_driver') === $name || config('common.site.public_disk_driver') === $name;
    }

    private function registerEventListeners()
    {
        Event::listen(SettingsSaved::class, SyncPlansWhenBillingSettingsChange::class);
        Event::listen(SettingsSaved::class, UpdateAllUsersLanguageWhenDefaultLocaleChanges::class);
    }
}
