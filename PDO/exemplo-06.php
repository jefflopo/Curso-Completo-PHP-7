<?php
    $conn = new PDO("mysql:host=localhost; dbname=db_php7", "root", "");
    $conn->beginTransaction();
    
    $stmt = $conn->prepare( "DELETE FROM tb_usuarios WHERE idusuario = ?" );
    // deletando dados no Banco de Dados
    
    $id = 2;
    
    $stmt->execute( array($id) );
    
    //$conn->rollBack(); //volta atrás ao estado anterior a um comando realizado
    $conn->commit();
    
    echo "Deleção com Sucesso!!!";
?>

