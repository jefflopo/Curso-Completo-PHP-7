<?php
    try{
        
        throw new Exception("Houve um erro", 400);
        
    } catch (Exception $exc) {
        
        echo json_encode(array(
            "message"=>$exc->getMessage(),
            "line"=>$exc->getLine(),
            "file"=>$exc->getFile(),
            "code"=>$exc->getCode()
        ));
        
    }

