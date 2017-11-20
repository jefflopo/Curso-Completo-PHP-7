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
    
    $page = (isset($_GET['page'])) ? (int)$_GET['page'] : 1;
    
    $category = new Category();
    
    $category->get((int)$idcategory);
    
    $pagination = $category->getProductsPage($page);
    
    $pages = [];
    
    for($i=1; $i <= $pagination['pages']; $i++){
        
        array_push($pages, [
            'link'=>'/categories/' . $category->getidcategory() . '?page=' .$i,
            'page'=>$i
        ]);
        
    }
    
    $pageTPL = new PageCategories();
    
    $pageTPL->setTpl("category", [
        'category'=>$category->getValues(),
        'products'=>$pagination["data"],
        'pages'=>$pages
    ]);
    
});

$app->get("/products/:desurl", function($desurl){
    
    $product = new Product();
    
    $product->getFromURL($desurl);
    
    $page = new PageCategories();
    
    $page->setTpl("product-detail",[
        'product'=>$product->getValues(),
        'categories'=>$product->getCategories()
    ]);
    
});
$app->get('/cart', function(){
    
    $page = new Page();
    
    $page->setTpl("cart");
    
});

