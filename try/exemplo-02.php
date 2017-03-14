<?php
    function trataNome( $name ) {
        
        if( !$name ) {
            
            throw new Exception("Nenhum nome foi informado.", 1);
        
        }
        
        echo ucfirst($name) ."<br>";
        
    }
    
    try {
        
        trataNome("JeffersonLopo");
        trataNome("");
        
    } catch (Exception $ex) {
        
        echo $ex->getMessage();

    } finally {
        
        echo "<br>Executou o Try!!!!";
        
    }

