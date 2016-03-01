<?php
/**
 * Created by PhpStorm.
 * User: leemason
 * Date: 25/02/16
 * Time: 17:46
 */

namespace App\Services\Admin\Settings;


class Sections extends Collection
{

    public function offsetSet($key, $value){
        if(!$value instanceof Section){
            throw new \InvalidArgumentException('$value must be an instance of ' . Section::class);
        }
        return parent::offsetSet($key, $value);
    }

}