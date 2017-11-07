<?php

use \Hcode\Page;

$app->get('/', function() {
    
//       $sql = new Sql();
//       $results = $sql->select("SELECT * FROM tb_users");
//        
//       echo json_encode($results);
    
    $page = new Page();
    $page->setTpl("index");

});

