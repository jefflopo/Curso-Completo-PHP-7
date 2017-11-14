<?php

use \Hcode\Page;
use \Hcode\Model\Product;

$app->get('/', function() {
    
//       $sql = new Sql();
//       $results = $sql->select("SELECT * FROM tb_users");
//        
//       echo json_encode($results);
    
    $products = Product::listAll();
    
    $page = new Page();
    
    $page->setTpl("index", [
        'products'=>Product::checklist($products)
    ]);

});

