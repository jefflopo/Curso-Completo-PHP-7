<?php
    require_once ("config.php");
    
//    $sql = new Sql();
//    $usuarios = $sql->select("SELECT * FROM tb_usuarios");
//    
//    echo json_encode($usuarios);
    
    // apenas carrega um usuário específico
//    $root = new Usuario();    
//    $root->loadById( 3 );    
//    echo $root;
    
    // Carrega uma lista de usuarios
    //$lista = Usuario::getList();
    //echo json_encode($lista);
    
    // Carrega uma lista de usuarios buscando pelo login
    //$search = Usuario::search("jo");
    //echo json_encode( $search );

    // Carrega um usuario usando o login e a senha
    //$usuario = new Usuario();
    //$usuario->login("root", "54321");
    //echo $usuario;
    
    $aluno = new Usuario("aluno","@lun0");
    
    $aluno->insert();
    
    echo $aluno;
