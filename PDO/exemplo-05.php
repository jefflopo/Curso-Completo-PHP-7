<?php
    $conn = new PDO("mysql:host=localhost; dbname=db_php7", "root", "");
    
    $stmt = $conn->prepare( "DELETE FROM tb_usuarios WHERE idusuario = :ID" );
    // deletando dados no Banco de Dados
    
    $id = 12;
    
    $stmt->bindParam(":ID", $id);
    
    $stmt->execute();
    
    echo "Deleção com Sucesso!!!";
?>

