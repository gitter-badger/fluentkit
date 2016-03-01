<?php
/**
 * Created by PhpStorm.
 * User: leemason
 * Date: 25/02/16
 * Time: 17:34
 */

namespace App\Services\Admin;


use App\Services\Admin\Settings\Collection;
use App\Services\Admin\Settings\Group;

class SettingsRegistrar extends Collection
{

    public function offsetSet($key, $value){
        if(!$value instanceof Group){
            throw new \InvalidArgumentException('$value must be an instance of ' . Group::class);
        }
        return parent::offsetSet($key, $value);
    }

}