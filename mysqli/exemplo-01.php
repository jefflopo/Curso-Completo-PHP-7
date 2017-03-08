<?php
    $conn = new mysqli("127.0.0.1", "root","", "db_php7");
    
    if( $conn->connect_error ) {
        echo "Error: " . $conn->connect_error;
    }
    
    $stmt = $conn->prepare( "INSERT INTO tb_usuarios(deslogin, dessenha) VALUES (?, ?)" );
    
    $stmt->bind_param("ss", $login , $pass);
    
    $login = "user";
    $pass = "123456";
    $stmt->execute();
    
    $login = "root";
    $pass = "54321";
    $stmt->execute();
?>