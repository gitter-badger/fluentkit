<?php
/**
 * Created by PhpStorm.
 * User: leemason
 * Date: 25/02/16
 * Time: 17:46
 */

namespace App\Services\Admin\Settings;


use Illuminate\Contracts\Support\Arrayable;

class Section implements Arrayable
{

    protected $id;

    protected $name;

    protected $description;

    protected $fields;

    protected $priority = 100;

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
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $title
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getFields()
    {
        $this->fields = ($this->fields instanceof Fields) ? $this->fields : new Fields();
        return $this->fields;
    }

    /**
     * @param mixed $fields
     */
    public function setFields($fields)
    {
        $this->fields = (is_array($fields)) ? new Fields($fields) : $fields;
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

    public function toArray()
    {
        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'description' => $this->getDescription(),
            'priority' => $this->getPriority(),
            'fields' => $this->getFields()->sortByPriority()->values()->toArray()
        ];
    }

}