<?php
/**
 * Created by PhpStorm.
 * User: leemason
 * Date: 25/02/16
 * Time: 17:49
 */

namespace App\Services\Admin\Settings\Fields;


use App\Services\Admin\Settings\Field;

class Select extends Field
{

    protected $type = 'select';

    protected $options = [];

    /**
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * @param array $options
     */
    public function setOptions($options)
    {
        $this->options = $options;
    }


    public function toArray()
    {
        $original = parent::toArray();
        $original['options'] = $this->getOptions();
        return $original;
    }

}