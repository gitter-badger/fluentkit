<?php
/**
 * Created by PhpStorm.
 * User: leemason
 * Date: 28/02/16
 * Time: 21:54
 */

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller as BaseController;
use Illuminate\Http\Request;

class Controller extends BaseController
{

    protected $allowedWheres = [];

    protected $allowedIncludes = [];

    public function __construct(){

    }

    /**
     * Convert comma seperated ?include query into an aray suitable for eloquent.
     *
     * @param Request $request
     * @return array
     */
    protected function getIncludes(Request $request){
        return collect(array_filter(explode(',', $request->get('include', ''))))->reject(function($include){
            return !in_array($include, $this->allowedIncludes);
        })->toArray();
    }

    /**
     * Return the ?per_page query if within max limit, default if not present, or max limit if exceeds.
     *
     * @param Request $request
     * @return int
     */
    protected function getPerPage(Request $request){
        return ($request->get('per_page', config('api.per_page')) <= config('api.max_per_page')) ? $request->get('per_page', config('api.per_page')) : config('api.max_per_page');
    }

    /**
     * Converts all ?q[]=field:operator:value queries into an array suitable for eloquent.
     *
     * @param Request $request
     * @return array
     */
    protected function getWhereQuery(Request $request){
        $where = [];
        foreach((array) $request->get('q', []) as $query){

            $q = array_filter(explode(':', $query));

            if(count($q) == 1){
                //worthless
                continue;
            }elseif(count($q) == 2){
                //for consistency
                $q = [$q[0], '=', $q[1]];
            }

            //are we allowed to filter by this field?
            if(!in_array($q[0], $this->allowedWheres)){
                continue;
            }

            //add like wildcards if not present
            if($q[1] == 'like' && !starts_with($q[2], '%') && !ends_with($q[2], '%')){
                $q[2] = '%' . $q[2] . '%';
            }
            $where[] = $q;
        }
        return $where;
    }

}