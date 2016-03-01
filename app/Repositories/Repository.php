<?php
/**
 * Created by PhpStorm.
 * User: leemason
 * Date: 24/01/16
 * Time: 17:57
 */

namespace App\Repositories;


use Illuminate\Database\Eloquent\Model;

abstract class Repository
{

    protected $model;

    public function __construct(Model $model){
        $this->model = $model;
    }

    public function __call($method, $parameters)
    {
        return call_user_func_array([$this->model, $method], $parameters);
    }

}