<?php
    $conn = new PDO("mysql:host=localhost; dbname=db_php7", "root", "");
    
    $stmt = $conn->prepare( "UPDATE tb_usuarios SET deslogin = :LOGIN, dessenha = :PASSWORD WHERE idusuario = :ID" );
    // inserindo dados no Banco de Dados
    $login = "Joaozinho";
    $password = "qwerty";
    $id = 3;
    
    $stmt->bindParam(":LOGIN", $login);
    $stmt->bindParam(":PASSWORD", $password);
    $stmt->bindParam(":ID", $id);
    
    $stmt->execute();
    
    echo "Atualizado com Sucesso!!!";
?>

