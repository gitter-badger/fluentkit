<?php

namespace App\Services\SystemJs;


class SystemJs
{

    protected $config;

    protected $import;

    public function __construct(Config $config, Import $import){
        $this->config = $config;
        $this->import = $import;
    }

    /**
     * @return Config
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * @return Import
     */
    public function getImport()
    {
        return $this->import;
    }

    public function config(){
        return $this->getConfig();
    }

    public function import(){
        return $this->getImport();
    }

    /**
     * Injects the script tags to start up the SystemJs Loader
     *
     * @return string
     */
    public function start(){

        //add the init file as the first item
        $this->import()->item('init')->priority(1);

        //get production status
        $production = (config('app.env') == 'production') ? true : false;

        //use script tag injection during production
        $url = ($production === true) ? 'js/jspm_packages/system-csp-production.js' : 'js/jspm_packages/system.js';
        $script = "<script src=\"". url($url) . "\"></script>\n";

        //load config
        $script .= "<script src=\"" . url('js/config.js') . "\"></script>";

        $script .= "<script>\n";

            //dont load bundles, we want raw transpiling!
            if($production !== true){
                $script .= "System.bundles = {};\n";
            }

            //add any config items added via plugins
            if($this->config()->hasItems()) {
                $script .= "System.config(\n";
                    $script .= $this->config()->toJson() . "\n";
                $script .= ");\n";
            }

            //import any requested modules
            $script .= "Promise.all([\n";
            foreach($this->import()->all() as $item){
                $script .= $item->import() . ",\n";
            }
            $script .= "]).then(function(imports){
                System.import('fluentkit').then(function(fluentkit){
                    fluentkit.app.start();
                    return fluentkit;
                });
            });";

        $script .= "</script>\n";

        return $script;

    }
}