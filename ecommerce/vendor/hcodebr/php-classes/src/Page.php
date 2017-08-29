<?php

namespace Hcode;

use Rain\Tpl;

class Page {
    
    public function __construct() {
        
        $config = array(
                    "tpl_dir"       => $_SERVER["DOCUMENT_ROOT"]."/view/",
                    "cache_dir"     => $_SERVER["DOCUMENT_ROOT"]."/views-cache/",
                    "debug"         => false
                );

	Tpl::configure( $config );
        
    }
    
    public function __destruct() {
        
    }
    
}



