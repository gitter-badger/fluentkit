<?php
/**
 * Created by PhpStorm.
 * User: leemason
 * Date: 25/02/16
 * Time: 17:39
 */

namespace App\Services\Admin\Settings;


use Illuminate\Contracts\Support\Arrayable;

class Group implements Arrayable
{
    protected $id;

    protected $name;

    protected $description;

    protected $icon;

    protected $link_text;

    protected $priority = 100;

    protected $sections;

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
     * @param mixed $name
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
    public function getIcon()
    {
        return $this->icon;
    }

    /**
     * @param mixed $icon
     */
    public function setIcon($icon)
    {
        $this->icon = $icon;
    }

    /**
     * @return mixed
     */
    public function getLinkText()
    {
        return $this->link_text;
    }

    /**
     * @param mixed $link_text
     */
    public function setLinkText($link_text)
    {
        $this->link_text = $link_text;
    }

    /**
     * @return mixed
     */
    public function getSections()
    {
        $this->sections = ($this->sections instanceof Sections) ? $this->sections : new Sections();
        return $this->sections;
    }

    /**
     * @param mixed $sections
     */
    public function setSections($sections)
    {
        $this->sections = (is_array($sections)) ? new Sections($sections) : $sections;
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
            'icon' => $this->getIcon(),
            'link_text' => $this->getLinkText(),
            'priority' => $this->getPriority(),
            'sections' => $this->getSections()->sortByPriority()->values()->toArray()
        ];
    }

}