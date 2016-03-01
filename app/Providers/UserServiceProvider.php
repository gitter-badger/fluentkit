<?php

namespace App\Providers;

use App\Models\User;
use App\Repositories\Provider\EloquentProviderRepository;
use App\Repositories\Provider\ProviderRepositoryInterface;
use App\Repositories\User\EloquentUserRepository;
use App\Repositories\User\UserRepositoryInterface;
use App\Services\Admin\Settings\Fields\Toggle;
use App\Services\Admin\Settings\Group;
use App\Services\Admin\Settings\Section;
use App\Services\Admin\SettingsRegistrar;
use Illuminate\Support\ServiceProvider;

class UserServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot(SettingsRegistrar $registrar)
    {
        User::creating(function($user){
           $user->api_token = bcrypt(str_random(10));
        });


        $registrar->put('user', new Group([
            'id' => 'user-settings',
            'name' => trans('admin.settings_user_name'),
            'description' => trans('admin.settings_user_description'),
            'icon' => 'person',
            'link_text' => trans('admin.settings_user_link_text'),
            'sections' => [
                'registration' => new Section([
                    'id' => 'registration',
                    'name' => trans('admin.settings_user_registration_title'),
                    'description' => trans('admin.settings_user_registration_description'),
                    'fields' => [
                        'user.allow_registration' => new Toggle([
                            'id' => 'user.allow_registration',
                            'label' => trans('admin.settings_user_registration_fields_enabled_label'),
                            'description' => trans('admin.settings_user_registration_fields_enabled_description'),
                        ])
                    ]
                ])
            ]
        ]));

    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(UserRepositoryInterface::class, EloquentUserRepository::class);
        $this->app->bind(ProviderRepositoryInterface::class, EloquentProviderRepository::class);
    }
}
