<?php

use \Hcode\Page;
use \Hcode\Model\Product;
use \Hcode\Model\Category;
use Hcode\Model\Cart;
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
    
    $cart = Cart::getFromSession();
    
    $page = new Page();
    
    $page->setTpl("cart", [
        'cart'=>$cart->getValues(),
        'products'=>$cart->getProducts()
    ]);
    
});
$app->get("/cart/:idproduct/add", function($idproduct){
    
    $product = new Product();
    
    $product->get((int)$idproduct);
    
    $cart = Cart::getFromSession();
    
    $qtd = (isset($_GET['qtd'])) ? (int)$_GET['qtd'] : 1;
    
    for($i = 0; $i < $qtd; $i++){
        
        $cart->addProduct($product);
        
    }
    
    header("Location: /CursoCompletoPHP7/ecommerce/cart");
    exit;
    
});
//remover apenas um product
$app->get("/cart/:idproduct/minus", function($idproduct){
    
    $product = new Product();
    
    $product->get((int)$idproduct);
    
    $cart = Cart::getFromSession();
    
    $cart->removeProduct($product);
    
    header("Location: /CursoCompletoPHP7/ecommerce/cart");
    exit;
    
});
$app->get("/cart/:idproduct/remove", function($idproduct){
    
    $product = new Product();
    
    $product->get((int)$idproduct);
    
    $cart = Cart::getFromSession();
    
    $cart->removeProduct($product, true);
    
    header("Location: /CursoCompletoPHP7/ecommerce/cart");
    exit;
    
});

