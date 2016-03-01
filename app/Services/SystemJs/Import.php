<?php
/**
 * Created by PhpStorm.
 * User: leemason
 * Date: 21/02/16
 * Time: 19:44
 */

namespace App\Services\SystemJs;


use Illuminate\Support\Collection;

class Import
{
    public $items;

    public function __construct(){
        $this->items = new Collection();
    }

    public function item($id){
        if(!$this->items->has($id)){
            $this->items->put($id, new Item($id));
        }
        return $this->items->get($id);
    }

    public function all(){
        return $this->items->sortBy(function($item){
            return $item->getPriority();
        });
    }

}