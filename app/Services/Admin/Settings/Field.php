<?php
/**
 * Created by PhpStorm.
 * User: leemason
 * Date: 25/02/16
 * Time: 17:49
 */

namespace App\Services\Admin\Settings;


use Illuminate\Contracts\Support\Arrayable;

class Field implements Arrayable
{

    protected $id;

    protected $label;

    protected $type = 'text';

    protected $description;

    protected $priority = 100;

    protected $validate = [];

    public function __construct(array $attributes){
        foreach($attributes as $key => $value){
            call_user_func([$this, 'set' . ucfirst(camel_case($key))], $value);
        }
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * @param mixed $label
     */
    public function setLabel($label)
    {
        $this->label = $label;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return config($this->id);
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return nl2br($this->description);
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return int
     */
    public function getPriority()
    {
        return $this->priority;
    }

    /**
     * @param int $priority
     */
    public function setPriority($priority)
    {
        $this->priority = $priority;
    }

    /**
     * @return mixed
     */
    public function getValidate()
    {
        return $this->validate;
    }

    /**
     * @param mixed $validate
     */
    public function setValidate($validate)
    {
        $this->validate = $validate;
    }


    public function toArray()
    {
        return [
            'id' => $this->getId(),
            'label' => $this->getLabel(),
            'type' => $this->getType(),
            'value' => $this->getValue(),
            'description' => $this->getDescription(),
            'priority' => $this->getPriority(),
            'validate' => $this->getValidate()
        ];
    }

}