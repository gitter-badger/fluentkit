<?php
/**
 * Created by PhpStorm.
 * User: leemason
 * Date: 21/02/16
 * Time: 19:48
 */

namespace App\Services\SystemJs;


use Illuminate\Contracts\Support\Arrayable;

class Item implements Arrayable
{
    public $id;

    protected $location;

    protected $priority = 100;

    protected $then = [];

    public function __construct($id = null){
        $this->id = $id;
    }

    public function to($location = null){
        $this->location = $location;
    }

    public function toPluginPath($location = null){
        $this->location = '../plugins/' . $location;
    }

    public function toThemePath($location = null){
        $this->location = '../themes/' . $location;
    }

    public function toArray()
    {
        return $this->location;
    }

    public function priority($priority){
        $this->priority = $priority;
        return $this;
    }

    /**
     * @return int
     */
    public function getPriority()
    {
        return $this->priority;
    }

    public function then($callback){
        if(is_string($callback)){
            $this->then[] = ['type' => 'import', 'id' => $callback];
            return $this;
        }
        $this->then[] = ['type' => 'callback', 'callback' => $callback];
        return $this;
    }

    public function import(){

        if(empty($this->then)){
           return "System.import('" . $this->id ."')";
        }

        $script = '';
        $script .= "System.import('" . $this->id ."')";
        foreach($this->then as $then){
            $script .= ".then(function(" . $this->id . "){\n";
                if($then['type'] == 'import'){
                    $script .= "System.import('".$then['id']."');\n";
                }else{
                    $script .= call_user_func($then['callback']) . "\n";
                    $script .= "return " . $this->id . "\n";
                }
            $script .= "})";
        }

        return $script;
    }

}