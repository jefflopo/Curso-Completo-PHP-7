<?php

namespace Hcode;

use Rain\Tpl;

class Page {
    
    public function __construct() {
        
        $config = array(
                    "tpl_dir"       => "templates/simple/",
                    "cache_dir"     => "cache/",
                    "debug"         => true // set to false to improve the speed
                );

	Tpl::configure( $config );
        
    }
    
    public function __destruct() {
        
    }
    
}



