<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //load settings into config
        $file = storage_path('app/settings.php');
        if(file_exists($file)){
            $settings = require $file;
            foreach($settings as $key => $value){
                config()->set($key, $value);
            }
        }

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
    }
}
