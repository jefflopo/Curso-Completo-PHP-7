<?php

use \Hcode\Page;
use \Hcode\Model\Product;
use \Hcode\Model\Category;
use \Hcode\PageCategories;

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
$app->get("/categories/:idcategory", function($idcategory){
    
    $category = new Category();
    
    $category->get((int)$idcategory);
    
    $page = new PageCategories();
    
    $page->setTpl("category", [
        'category'=>$category->getValues(),
        'products'=>[]
    ]);
    
});

