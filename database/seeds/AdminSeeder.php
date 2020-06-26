<?php

use App\User;
use Common\Auth\Permissions\Permission;
use Common\Database\MigrateAndSeed;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;


class AdminSeeder extends Seeder
{

    public function run()
    {
        app(MigrateAndSeed::class)->execute(function() {
            $this->createAdminAccount();
        });
    }

    public function createAdminAccount()
    {
        $email = 'admin@mail.com';
        $user = app(User::class)->firstOrNew(['email' => $email]);
        $user->username = 'admin';
        $user->email = $email;
        $user->password = Hash::make('admin');
        $user->api_token = Str::random(40);
        $user->save();
        $adminPermission = app(Permission::class)->firstOrCreate(
            ['name' => 'admin'],
            [
                'name' => 'admin',
                'group' => 'admin',
                'display_name' => 'Super Admin',
                'description' => 'Give all permissions to user.',
            ]
        );
        $user->permissions()->attach($adminPermission->id);
        Auth::login($user);
    }
}
