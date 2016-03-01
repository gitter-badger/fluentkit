<?php
/**
 * Created by PhpStorm.
 * User: leemason
 * Date: 25/02/16
 * Time: 17:49
 */

namespace App\Services\Admin\Settings;


class Fields extends Collection
{

    public function offsetSet($key, $value){
        if(!$value instanceof Field){
            throw new \InvalidArgumentException('$value must be an instance of ' . Field::class);
        }
        return parent::offsetSet($key, $value);
    }

}