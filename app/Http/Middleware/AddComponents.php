<?php
namespace App\Http\Middleware;

use App\Services\SystemJs\SystemJs as Js;
use Closure;

class AddComponents
{

    protected $systemJs;

    public function __construct(Js $systemJs){
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

                $components = config('components');
                $newMatches = true;
                $matchedComponents = [];

                while($newMatches == true){

                    $renderedContent = '';
                    $newEls = 0;

                    //loop registered components and add templates as needed.
                    foreach($components as $id => $component){
                        if(str_contains($content, '<' . $id ) && !in_array($id, $matchedComponents)){
                            $newEls++;
                            $matchedComponents[] = $id;
                            $componentView = view($component['view']);
                            $renderedContent .= $componentView;
                            $this->systemJs->import()->item($component['js']);
                        }
                    }

                    $content = substr($content, 0, $pos) . $renderedContent . substr($content, $pos);

                    if($newEls === 0){
                        $newMatches = false;
                    }

                }


                $response->setContent($content);
            }

            return $response;

        }

        return $next($request);
    }
}
