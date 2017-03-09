<?php
    $conn = new PDO("mysql:host=localhost; dbname=db_php7", "root", "");
    
    $stmt = $conn->prepare( "DELETE FROM tb_usuarios WHERE idusuario = :ID" );
    // deletando dados no Banco de Dados
    
    $id = 3;
    
    $stmt->bindParam(":LOGIN", $login);
    $stmt->bindParam(":PASSWORD", $password);
    $stmt->bindParam(":ID", $id);
    
    $stmt->execute();
    
    echo "Atualizado com Sucesso!!!";
?>

