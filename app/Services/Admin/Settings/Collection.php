<?php
/**
 * Created by PhpStorm.
 * User: leemason
 * Date: 25/02/16
 * Time: 17:55
 */

namespace App\Services\Admin\Settings;

use Illuminate\Support\Collection as BaseCollection;

class Collection extends BaseCollection
{

    public function sortByPriority(){
        $collection = $this->sortBy(function($item, $key){
            return $item->getPriority();
        });

        return $collection;
    }

}