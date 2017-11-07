<?php

use \Hcode\PageAdmin;
use \Hcode\Model\User;
use \Hcode\Model\Product;

$app->get("/admin/products", function(){
    
    User::verifyLogin();
    
    $products = Product::listAll();
    
    $page = new PageAdmin();
    
    $page->setTpl("products", [
        "products"=>$products
    ]);
    
});

