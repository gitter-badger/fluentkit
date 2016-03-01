<?php
namespace App\Providers;

use App\Services\Admin\Settings\Field;
use App\Services\Admin\Settings\Fields\Email;
use App\Services\Admin\Settings\Fields\Select;
use App\Services\Admin\Settings\Fields\Toggle;
use App\Services\Admin\Settings\Group;
use App\Services\Admin\Settings\Section;
use App\Services\Admin\SettingsRegistrar;
use App\Services\SystemJs\SystemJs;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Routing\Events\RouteMatched;
use Illuminate\Support\ServiceProvider;

class AdminServiceProvider extends ServiceProvider
{

    public function register(){

        $this->app->singleton(SettingsRegistrar::class, function(){
            return new SettingsRegistrar();
        });

    }

    public function boot(SystemJs $js, Dispatcher $events, SettingsRegistrar $registrar){

        $timezones = [];
        $zones = \DateTimeZone::listIdentifiers();
        foreach($zones as $zone){
            $timezones[] = [
                'text' => $zone,
                'value' => $zone
            ];
        }

        $registrar->put('general', new Group([
            'id' => 'general-settings',
            'priority' => 1,
            'name' => trans('admin.settings_general_name'),
            'description' => trans('admin.settings_general_description'),
            'icon' => 'settings',
            'link_text' => trans('admin.settings_general_link_text'),
            'sections' => [
                'email' => new Section([
                    'id' => 'email',
                    'name' => trans('admin.settings_general_email_title'),
                    'description' => trans('admin.settings_general_email_description'),
                    'fields' => [
                        'mail.from.address' => new Email([
                            'id' => 'mail.from.address',
                            'label' => trans('admin.settings_general_email_fields_address_label'),
                            'description' => trans('admin.settings_general_email_fields_address_description'),
                            'validate' => [
                                'required' => true,
                                'email' => true
                            ],
                        ]),
                        'mail.from.name' => new Field([
                            'id' => 'mail.from.name',
                            'label' => trans('admin.settings_general_email_fields_name_label'),
                            'description' => trans('admin.settings_general_email_fields_name_description'),
                            'validate' => [
                                'required' => true
                            ],
                        ])
                    ]
                ]),
                'time' => new Section([
                    'id' => 'time',
                    'name' => trans('admin.settings_general_time_title'),
                    'description' => trans('admin.settings_general_time_description'),
                    'fields' => [
                        'app.timezone' => new Select([
                            'id' => 'app.timezone',
                            'label' => trans('admin.settings_general_time_fields_timezone_label'),
                            'description' => trans('admin.settings_general_time_fields_timezone_description'),
                            'options' => $timezones
                        ]),
                        'app.date_format' => new Select([
                            'id' => 'app.date_format',
                            'label' => trans('admin.settings_general_time_fields_date_format_label'),
                            'description' => trans('admin.settings_general_time_fields_date_format_description'),
                            'options' => [
                                [
                                    'text' => date('d/m/y'),
                                    'value' => 'd/m/Y'
                                ],
                                [
                                    'text' => date('d-m-y'),
                                    'value' => 'd-m-Y'
                                ],
                                [
                                    'text' => date('F j, Y'),
                                    'value' => 'F j, Y'
                                ],
                                [
                                    'text' => date('m.d.y'),
                                    'value' => 'm.d.y'
                                ],
                                [
                                    'text' => date('j, n, Y'),
                                    'value' => 'j, n, Y'
                                ],
                                [
                                    'text' => date('j-m-y'),
                                    'value' => 'j-m-y'
                                ],
                                [
                                    'text' => date('D M j Y'),
                                    'value' => 'D M j Y'
                                ],
                                [
                                    'text' => date('Y-m-d'),
                                    'value' => 'Y-m-d'
                                ]
                            ]
                        ]),
                        'app.time_format' => new Select([
                            'id' => 'app.time_format',
                            'label' => trans('admin.settings_general_time_fields_time_format_label'),
                            'description' => trans('admin.settings_general_time_fields_time_format_description'),
                            'options' => [
                                [
                                    'text' => date('H:i a'),
                                    'value' => 'H:i a'
                                ],
                                [
                                    'text' => date('H:i:s'),
                                    'value' => 'H:i:s'
                                ],
                                [
                                    'text' => date('h:i a'),
                                    'value' => 'h:i a'
                                ],
                                [
                                    'text' => date('h:i:s'),
                                    'value' => 'h:i:s'
                                ],
                                [
                                    'text' => date('G:i a'),
                                    'value' => 'G:i a'
                                ],
                                [
                                    'text' => date('G:i:s'),
                                    'value' => 'G:i:s'
                                ],
                                [
                                    'text' => date('g:i a'),
                                    'value' => 'g:i a'
                                ],
                                [
                                    'text' => date('g:i:s'),
                                    'value' => 'g:i:s'
                                ],
                            ]
                        ])
                    ]
                ]),
                'environment' => new Section([
                    'id' => 'environment',
                    'name' => trans('admin.settings_general_environment_title'),
                    'description' => trans('admin.settings_general_environment_description'),
                    'fields' => [
                        'app.debug' => new Toggle([
                            'id' => 'app.debug',
                            'label' => trans('admin.settings_general_environment_fields_debug_label'),
                            'description' => trans('admin.settings_general_environment_fields_debug_description'),
                        ]),
                        'debugbar.enabled' => new Toggle([
                            'id' => 'debugbar.enabled',
                            'label' => trans('admin.settings_general_environment_fields_debugbar_label'),
                            'description' => trans('admin.settings_general_environment_fields_debugbar_description'),
                        ])
                    ]
                ]),
            ]
        ]));

        $events->listen(RouteMatched::class, function($event) use ($js){

            if($event->request->is('admin*')){

                $js->import()->item('admin/mdl-nav-dropdown');

                view()->composer('*', function ($view) use ($event) {
                    $view->with('user', $event->request->user());
                });
            }

        });
    }

}