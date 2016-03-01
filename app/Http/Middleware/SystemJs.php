<?php

namespace App\Http\Middleware;

use Closure;

class SystemJs
{

    protected $systemJs;

    public function __construct(\App\Services\SystemJs\SystemJs $systemJs){
        $this->systemJs = $systemJs;
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        if (!$request->ajax() && !$request->wantsJson()) {

            $response = $next($request);

            $content = $response->getContent();

            $pos = strripos($content, '</body>');

            if (false !== $pos) {

                $content = substr($content, 0, $pos) . $this->systemJs->start() . substr($content, $pos);

                $response->setContent($content);
            }

            return $response;

        }

        return $next($request);
    }
}
