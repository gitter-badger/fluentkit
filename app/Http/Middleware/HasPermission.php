<?php
/**
 * Created by PhpStorm.
 * User: leemason
 * Date: 24/01/16
 * Time: 18:39
 */

namespace App\Http\Middleware;


use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Facades\Auth;

class HasPermission
{
    protected $auth;

    public function __construct(Guard $auth){
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $permissions
     * @return mixed
     */
    public function handle($request, \Closure $next, $permissions = '')
    {

        $permissions = explode(',', $permissions);
        $user = $this->auth->user();
        if(is_null($user)){
            $user = Auth::guard('api')->user();
        }

        foreach($permissions as $permission){
            if(!$user->can($permission) || is_null($user)){
                if ($request->ajax() || $request->wantsJson()) {
                    return response('Unauthorized.', 401);
                } else {
                    return redirect()->back();
                }
            }
        }

        return $next($request);
    }

}