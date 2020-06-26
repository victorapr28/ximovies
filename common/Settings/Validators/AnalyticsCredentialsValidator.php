<?php

namespace Common\Settings\Validators;

use Config;
use Exception;
use Illuminate\Support\Arr;
use Google_Service_Exception;
use Common\Admin\Analytics\Actions\GetGoogleAnalyticsData;

class AnalyticsCredentialsValidator
{
    const KEYS = ['analytics_view_id', 'certificate'];

    public function fails($settings)
    {
        $this->setConfigDynamically($settings);

        try {
            app(GetGoogleAnalyticsData::class)->execute(null);
        } catch (Exception $e) {
            return $this->getErrorMessage($e);
        }
    }

    private function setConfigDynamically($settings)
    {
        if ($viewId = Arr::get($settings, 'analytics_view_id')) {
            Config::set('laravel-analytics.view_id', "$viewId");
        }
    }

    /**
     * @param Exception $e
     * @return array
     */
    private function getErrorMessage($e)
    {
        if ($e instanceof Google_Service_Exception) {
            $message = Arr::get($e->getErrors(), '0.message');
        } else {
            $message = $e->getMessage();
        }

        return ['analytics_group' => 'Invalid credentials: ' . $message];
    }
}
