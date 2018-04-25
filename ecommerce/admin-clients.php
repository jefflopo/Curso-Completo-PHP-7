<?php

use \BIG\PageAdmin;
use \BIG\Model\Clients_bgt;
use \BIG\Model\Address;

$app->get('/bgt/admin/clients', function(){
    
    BIG\Model\Users_bgt::verifyLogin();
    
    $search = (isset($_GET['search'])) ? $_GET['search'] : "";
    $page = (isset($_GET['page'])) ? (int)$_GET['page']:1;
    
    if($search != '')
    {
        $pagination = Clients_bgt::getPageSearch($search, $page);
    } else {
        $pagination = Clients_bgt::getPage($page);
    }
    
    $pages = [];
    
    for($x = 0; $x < $pagination['pages']; $x++)
    {
        
        array_push($pages, [
            'href'=>'/bgt/admin/clients?' . http_build_query([
                'page'=>$x+1,
                'search'=>$search
            ]),
            'text'=>$x+1
        ]);
        
    }
    
    $page = new PageAdmin();
    $page->setTpl("clients", array(
        'clients'=>$pagination['data'],
        'search'=>$search,
        'pages'=>$pages
    ));
    
});
$app->get('/bgt/admin/clients/cep', function(){
    $address = new Address();
    
    if(isset($_GET['des_cep']))
    {
        $address->loadFromCEP($_GET['des_cep']);
    } 
    
    if(!$address->getdes_address()) $address->setdes_address('');
    if(!$address->getdes_complement()) $address->setdes_complement('');
    if(!$address->getdes_neighborhood()) $address->setdes_neighborhood('');
    if(!$address->getdes_city()) $address->setdes_city('');
    if(!$address->getdes_state()) $address->setdes_state('');
    if(!$address->getdes_country()) $address->setdes_country('');
    if(!$address->getdes_cep()) $address->setdes_cep('');
    
    $page = new PageAdmin();
    $page->setTpl("clients-cep", [
        'address'=>$address->getValues(),
        'error'=> Address::getMsgError()
    ]);
});
$app->get('/bgt/admin/clients/create', function(){
    
    \BIG\Model\Users_bgt::verifyLogin(); 
    $address = new Address();
    $clients = new Clients_bgt();
    $clients->setData($_POST);
    
    if(isset($_GET['des_cep']))
    {
        $address->loadFromCEP($_GET['des_cep']);
    }
    
    if(!$clients->getdes_situation()) $clients->setdes_situation('');
    if(!$clients->getdes_plataform_name()) $clients->setdes_plataform_name('');
    if(!$clients->getdesname()) $clients->setdesname('');
    if(!$clients->getdes_fantasy_name()) $clients->setdes_fantasy_name('');
    if(!$clients->getnrcpf_cnpj()) $clients->setnrcpf_cnpj('');
    if(!$clients->getdes_rg_ie()) $clients->setdes_rg_ie('');
    if(!$clients->getdessex()) $clients->setdessex('');
    if(!$clients->getdes_marital_status()) $clients->setdes_marital_status('');
    if(!$clients->getnr_cnh()) $clients->setnr_cnh('');
    if(!$clients->getdt_of_birth()) $clients->setdt_of_birth('');
    if(!$clients->getdes_email()) $clients->setdes_email('');
    if(!$clients->getnr_telephone()) $clients->setnr_telephone('');
    if(!$clients->getnr_cell_phone()) $clients->setnr_cell_phone('');
    if(!$clients->getdes_cep()) $clients->setdes_cep('');
    if(!$clients->getdes_address()) $clients->setdes_address('');
    if(!$clients->getdes_number()) $clients->setdes_number('');
    if(!$clients->getdes_neighborhood()) $clients->setdes_neighborhood('');
    if(!$clients->getdes_city()) $clients->setdes_city('');
    if(!$clients->getdes_complement()) $clients->setdes_complement('');
    if(!$clients->getdes_state()) $clients->setdes_state('');
    if(!$clients->getdes_name_person1()) $clients->setdes_name_person1('');
    if(!$clients->getdes_kinship_person1()) $clients->setdes_kinship_person1('');
    if(!$clients->getdes_phone_kinship_person1()) $clients->setdes_phone_kinship_person1('');
    if(!$clients->getdes_cellphone_kinship_person1()) $clients->setdes_cellphone_kinship_person1('');
    if(!$clients->getdes_name_person2()) $clients->setdes_name_person2('');
    if(!$clients->getdes_kinship_person2()) $clients->setdes_kinship_person2('');
    if(!$clients->getdes_phone_kinship_person2()) $clients->setdes_phone_kinship_person2('');
    if(!$clients->getdes_cellphone_kinship_person2()) $clients->setdes_cellphone_kinship_person2('');
    if(!$clients->getdes_payment()) $clients->setdes_payment('');
    if(!$clients->getdes_archive_client()) $clients->setdes_archive_client('');
    if(!$clients->getdes_obs_client()) $clients->setdes_obs_client('');
    
    $page = new PageAdmin();
    $page->setTpl("clients-create", [
        'address'=>$address->getValues(),
        'clients'=>$clients->getValues(),
        'error'=>Address::getMsgError()
    ]);
    
});
$app->post('/bgt/admin/clients/create', function(){
    
    \BIG\Model\Users_bgt::verifyLogin();
        
    if(!isset($_POST['des_cep']) || $_POST['des_cep'] === ''){
        
        Address::setMsgErro("Informe o CEP.");
        header("Location: /bgt/admin/clients");
        exit;
        
    }
    if(!isset($_POST['des_address']) || $_POST['des_address'] === ''){
        
        Address::setMsgErro("Informe o Endereço.");
        header("Location: /bgt/admin/clients");
        exit;
        
    }
    if(!isset($_POST['des_neighborhood']) || $_POST['des_neighborhood'] === ''){
        
        Address::setMsgErro("Informe o bairro.");
        header("Location: /bgt/admin/clients");
        exit;
        
    }
    if(!isset($_POST['des_city']) || $_POST['des_city'] === ''){
        
        Address::setMsgErro("Informe a cidade.");
        header("Location: /bgt/admin/clients");
        exit;
        
    }
    if(!isset($_POST['des_state']) || $_POST['des_state'] === ''){
        
        Address::setMsgErro("Informe o estado.");
        header("Location: /bgt/admin/clients");
        exit;
        
    }
    
    $client = new Clients_bgt();
    $client->setData($_POST);
    $client->save();
    
    header("Location: /bgt/admin/clients");
    exit;
    
});
$app->get('/bgt/admin/clients/:idclient/delete', function($idclient){
    
    \BIG\Model\Users_bgt::verifyLogin();
    $client = new Clients_bgt;
    $client->get((int)$idclient);
    $client->delete();
    
    header("Location: /bgt/admin/clients");
    exit;
    
    
});
$app->get('/bgt/admin/clients/:idclient', function($idclient){
    
    \BIG\Model\Users_bgt::verifyLogin();
    $clients = new Clients_bgt();
    $clients->get((int)$idclient);
    $payments = $clients->getValues()['des_payment'];
    $array = convertStringArray($payments);
//    var_dump(convertStringArray($payments));
//    exit;
    $page = new PageAdmin();
    $page->setTpl("clients-update", array(
        'clients'=>$clients->getValues(),
        'payments'=>$array
    ));
    
});
$app->post('/bgt/admin/clients/:idclient', function($idclient){
    
    \BIG\Model\Users_bgt::verifyLogin();
    $client = new Clients_bgt();
    $client->get((int)$idclient);
    $client->setData($_POST);
    $client->update();
    
    header("Location: /bgt/admin/clients");
    exit;
    
});
$app->get('/bgt/admin/clients/update', function(){
    
    \BIG\Model\Users_bgt::verifyLogin();
    $page = new PageAdmin();
    $page->setTpl("clients-update");
});

