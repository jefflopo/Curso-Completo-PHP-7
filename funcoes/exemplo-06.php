<?php

    $pessoa = array(
        'nome' => 'João',
        'idade' => 26
    );
    
    foreach ( $pessoa as $value ){
        
        if(gettype($value) === 'integer' ){
            
            $value += 10;
            
        }
        
        echo $value . '<br/>';
        
    }
    
    print_r($pessoa);

