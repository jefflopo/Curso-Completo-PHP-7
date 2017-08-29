<?php

namespace Hcode;

use Rain\Tpl;

class Page {
    
    private $tpl;
    private $options = [];
    private $defaults = [
        "data"=>[]
    ];


    public function __construct($opts = array()) {
        
        $this->options = array_merge( $this->defaults, $opts );
        
        $config = array(
                    "tpl_dir"       => $_SERVER["DOCUMENT_ROOT"]."/view/",
                    "cache_dir"     => $_SERVER["DOCUMENT_ROOT"]."/views-cache/",
                    "debug"         => false
                );

	Tpl::configure( $config );
        
        $this->tpl = new Tpl;
        
        foreach ($this->options["data"] as $key =>$value){
            $this->tpl->assign($key, $value);
        }
        
        $this->tpl->draw("header");
        
    }
    
    public function __destruct() {
        
        $this->tpl->draw("footer");
        
    }
    
}



