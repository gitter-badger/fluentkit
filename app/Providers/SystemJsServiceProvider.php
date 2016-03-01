<?php
/**
 * Created by PhpStorm.
 * User: leemason
 * Date: 21/02/16
 * Time: 20:26
 */

namespace App\Providers;


use App\Services\SystemJs\Config;
use App\Services\SystemJs\Import;
use App\Services\SystemJs\SystemJs;
use Illuminate\Support\ServiceProvider;

class SystemJsServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(SystemJs::class, function(){
           return new SystemJs(new Config(), new Import());
        });
    }

    public function boot(SystemJs $systemJs){
        view()->share('systemJs', $systemJs);
    }
}