<?php
/**
 * Created by PhpStorm.
 * User: leemason
 * Date: 25/02/16
 * Time: 21:52
 */

namespace App\Services\Admin\Settings\Fields;


use App\Services\Admin\Settings\Field;

class Toggle extends Field
{

    protected $type = 'toggle';

    protected $toggle_label = '';

    /**
     * @return string
     */
    public function getToggleLabel()
    {
        return $this->toggle_label;
    }

    /**
     * @param string $toggle_label
     */
    public function setToggleLabel($toggle_label)
    {
        $this->toggle_label = $toggle_label;
    }

    public function toArray()
    {
        $original = parent::toArray();
        $original['toggle_label'] = $this->getToggleLabel();
        return $original;
    }

}