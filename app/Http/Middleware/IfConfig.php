<?php
/**
 * Created by PhpStorm.
 * User: leemason
 * Date: 28/02/16
 * Time: 13:02
 */

namespace App\Http\Middleware;

class IfConfig
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $permissions
     * @return mixed
     */
    public function handle($request, \Closure $next, $config = '')
    {

        $configs = explode(',', $config);

        foreach($configs as $key){
            if(!config($key)){
                abort(404);
            }
        }

        return $next($request);
    }
}