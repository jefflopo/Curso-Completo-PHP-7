<?php 

require_once("vendor/autoload.php");
use \Slim\Slim;
//use Hcode\DB\Sql;
use \Hcode\Page;
use \Hcode\PageAdmin;

$app = new Slim();

$app->config('debug', true);

$app->get('/', function() {
    
//       $sql = new Sql();
//       $results = $sql->select("SELECT * FROM tb_users");
//        
//       echo json_encode($results);
    
    $page = new Page();
    $page->setTpl("index");

});

$app->get('/admin', function() {
    
    $page = new PageAdmin();
    $page->setTpl("index");

});

$app->run();

 ?>