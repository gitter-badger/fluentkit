<?php
/**
 * Created by PhpStorm.
 * User: leemason
 * Date: 21/02/16
 * Time: 19:43
 */

namespace App\Services\SystemJs;


use Illuminate\Support\Collection;

class Config
{
    public $map;

    public function __construct(){
        $this->map = new Collection();
    }

    public function map($id){
        if(!$this->map->has($id)){
            $this->map->put($id, new Item($id));
        }
        return $this->map->get($id);
    }

    public function hasItems(){
        return !$this->map->isEmpty();
    }

    public function toJson(){
        $obj = new \stdClass();
        $obj->map = $this->map->toArray();
        return json_encode($obj);
    }
}