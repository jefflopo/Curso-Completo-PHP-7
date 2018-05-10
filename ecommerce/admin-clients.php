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
    \BIG\Model\Users_bgt::verifyLogin();
    
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
        'errorRegister'=>Address::getErrorRegister()
    ]);
});
$app->post('/bgt/admin/clients/cep', function(){
    
    $_SESSION['registerValues'] = $_POST;
    
    if(isset($_POST['des_cep']) || $_POST['des_cep'] == '')
    {
        Address::setErrorRegister("Preencha o CEP para realizar a pesquisa.");
        Header("Location: /bgt/admin/clients/cep");
        exit;
    }
    
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
    
    if(!$clients->getdes_situation()){
        if(isset($_GET['des_situation'])){
            $clients->setdes_situation($_GET['des_situation']);
        }else{
            $clients->setdes_situation('');
        }
    }
    if(!$clients->getdes_plataform_name()){
        if(isset($_GET['des_plataform_name'])){
            $clients->setdes_plataform_name($_GET['des_plataform_name']);
        }else{
            $clients->setdes_plataform_name('');
        }
    }
    if(!$clients->getdesname()){
        if(isset($_GET['desname'])){
            $clients->setdesname($_GET['desname']);
        }else{
            $clients->setdesname('');
        }
    }
    if(!$clients->getdes_fantasy_name()){
        if(isset($_GET['des_fantasy_name'])){
            $clients->setdes_fantasy_name($_GET['des_fantasy_name']);
        }else{
            $clients->setdes_fantasy_name('');
        }
        
    }
    if(!$clients->getnrcpf_cnpj()){
        if(isset($_GET['nrcpf_cnpj'])){
            $clients->setnrcpf_cnpj($_GET['nrcpf_cnpj']);
        }else{
            $clients->setnrcpf_cnpj('');
        }
        
    }
    if(!$clients->getdes_rg_ie()){
        if(isset($_GET['des_rg_ie'])){
            $clients->setdes_rg_ie($_GET['des_rg_ie']);
        }else{
            $clients->setdes_rg_ie('');
        }
        
    }
    if(!$clients->getdessex()){
        if(isset($_GET['dessex'])){
            $clients->setdessex($_GET['dessex']);
        }else{
           $clients->setdessex(''); 
        }
        
    }
    if(!$clients->getdes_marital_status()){
        if(isset($_GET['des_marital_status'])){
            $clients->setdes_marital_status($_GET['des_marital_status']);
        }else{
            $clients->setdes_marital_status('');
        }
        
    }
    if(!$clients->getnr_cnh()){
        if(isset($_GET['nr_cnh'])){
            $clients->setnr_cnh($_GET['nr_cnh']);
        }else{
           $clients->setnr_cnh(''); 
        }
        
    }
    if(!$clients->getdt_of_birth()){
        if(isset($_GET['dt_of_birth'])){
            $clients->setdt_of_birth($_GET['dt_of_birth']);
        }else{
            $clients->setdt_of_birth('');  
        }
        
    }
    if(!$clients->getdes_email()){
        if(isset($_GET['des_email'])){
            $clients->setdes_email($_GET['des_email']);
        }else{
           $clients->setdes_email(''); 
        }
        
    }
    if(!$clients->getnr_telephone()){
        if(isset($_GET['nr_telephone'])){
            $clients->setnr_telephone($_GET['nr_telephone']);
        }else{
            $clients->setnr_telephone('');
        }
        
    }
    if(!$clients->getnr_cell_phone()){
        if(isset($_GET['nr_cell_phone'])){
            $clients->setnr_cell_phone($_GET['nr_cell_phone']);
        }else{
            $clients->setnr_cell_phone('');
        }
        
    }
//    if(!$clients->getdes_cep()){
//        if(isset()){
//            
//        }else{
//            
//        }
//        $clients->setdes_cep('');
//    }
    if(!$clients->getdes_address()){
        if(isset($_GET['des_address'])){
            $clients->setdes_address($_GET['des_address']);
        }else{
          $clients->setdes_address('');  
        }
        
    }
    if(!$clients->getdes_number()){
        if(isset($_GET['des_number'])){
            $clients->setdes_number($_GET['des_number']);
        }else{
           $clients->setdes_number(''); 
        }
        
    }
    if(!$clients->getdes_neighborhood()){
        if(isset($_GET['des_neighborhood'])){
            $clients->setdes_neighborhood($_GET['des_neighborhood']);
        }else{
            $clients->setdes_neighborhood('');
        }
        
    }
    if(!$clients->getdes_city()){
        if(isset($_GET['des_city'])){
            $clients->setdes_city($_GET['des_city']);
        }else{
           $clients->setdes_city(''); 
        }
        
    }
    if(!$clients->getdes_complement()){
        if(isset($_GET['des_complement'])){
            $clients->setdes_complement($_GET['des_complement']);
        }else{
           $clients->setdes_complement(''); 
        }
        
    }
    if(!$clients->getdes_state()){
        if(isset($_GET['des_state'])){
            $clients->setdes_state($_GET['des_state']);
        }else{
           $clients->setdes_state(''); 
        }
        
    }
    if(!$clients->getdes_name_person1()){
        if(isset($_GET['des_name_person1'])){
            $clients->setdes_name_person1($_GET['des_name_person1']);
        }else{
           $clients->setdes_name_person1(''); 
        }
        
    }
    if(!$clients->getdes_kinship_person1()){
        if(isset($_GET['des_kinship_person1'])){
            $clients->setdes_kinship_person1($_GET['des_kinship_person1']);
        }else{
            $clients->setdes_kinship_person1('');
        }
        
    }
    if(!$clients->getdes_phone_kinship_person1()){
        if(isset($_GET['des_phone_kinship_person1'])){
            $clients->setdes_phone_kinship_person1($_GET['des_phone_kinship_person1']);
        }else{
           $clients->setdes_phone_kinship_person1(''); 
        }
        
    }
    if(!$clients->getdes_cellphone_kinship_person1()){
        if(isset($_GET['des_cellphone_kinship_person1'])){
            $clients->setdes_cellphone_kinship_person1($_GET['des_cellphone_kinship_person1']);
        }else{
            $clients->setdes_cellphone_kinship_person1('');
        }
        
    }
    if(!$clients->getdes_name_person2()){
        if(isset($_GET['des_name_person2'])){
            $clients->setdes_name_person2($_GET['des_name_person2']);
        }else{
           $clients->setdes_name_person2(''); 
        }
        
    }
    if(!$clients->getdes_kinship_person2()){
        if(isset($_GET['des_kinship_person2'])){
           $clients->setdes_kinship_person2($_GET['des_kinship_person2']); 
        }else{
           $clients->setdes_kinship_person2('');  
        }
        
    }
    if(!$clients->getdes_phone_kinship_person2()){
        if(isset($_GET['des_phone_kinship_person2'])){
            $clients->setdes_phone_kinship_person2($_GET['des_phone_kinship_person2']);
        }else{
            $clients->setdes_phone_kinship_person2('');
        }
        
    }
    if(!$clients->getdes_cellphone_kinship_person2()){
        if(isset($_GET['des_cellphone_kinship_person2'])){
           $clients->setdes_cellphone_kinship_person2($_GET['des_cellphone_kinship_person2']); 
        }else{
           $clients->setdes_cellphone_kinship_person2(''); 
        }
        
    }
    if(!$clients->getdes_payment()){
        if(isset($_GET['des_payment'])){
            $clients->setdes_payment($_GET['des_payment']);
        }else{
            $clients->setdes_payment(''); 
        }
        
    }
    if(!$clients->getdes_archive_client()){
        if(isset($_GET['des_archive_client'])){
            $clients->setdes_archive_client($_GET['des_archive_client']);
        }else{
            $clients->setdes_archive_client('');
        }
        
    }
    if(!$clients->getdes_obs_client()){
        if(isset($_GET['des_obs_client'])){
            $clients->setdes_obs_client($_GET['des_obs_client']);
        }else{
            $clients->setdes_obs_client('');
        }
        
    }
    
    $page = new PageAdmin();
    $page->setTpl("clients-create", [
        'error'=>Clients_bgt::getError(),
        'address'=>$address->getValues(),
        'errorAddress'=>Address::getMsgError(),
        'clients'=>$clients->getValues(),
        'error'=>Address::getMsgError(),
        'registerValues'=>(isset($_SESSION['registerValues'])) ? $_SESSION['registerValues'] : ['des_plataform_name'=>'', 
            'desname'=>'', 'des_fantasy_name'=>'', 'nrcpf_cnpj'=>'', 'des_rg_ie'=>'', 'dessex'=>'', 
            'des_marital_status'=>'', 'nr_cnh'=>'', 'dt_of_birth'=>'', 'des_email'=>'', 'nr_telephone'=>'', 
            'nr_cell_phone'=>'', 'des_name_person1'=>'', 'des_kinship_person1'=>'', 'des_phone_kinship_person1'=>'', 
            'des_cellphone_kinship_person1'=>'', 'des_name_person2'=>'', 'des_kinship_person2'=>'', 
            'des_phone_kinship_person2'=>'', 'des_cellphone_kinship_person2'=>'']
    ]);
    
});
$app->post('/bgt/admin/clients/create', function(){
    
    \BIG\Model\Users_bgt::verifyLogin();
    
    $_SESSION['registerValues'] = $_POST;
        
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
    if(isset($_POST['des_plataform_name']) && $_POST['des_plataform_name'] == '')
    {
        Clients_bgt::setError("Preencha a Plataforma corretamente.");
        Header("Location: /bgt/admin/clients/create");
        exit;
    }
    if(isset($_POST['desname']) && $_POST['desname'] == '')
    {
        Clients_bgt::setError("Preencha o nome do cliente.");
        Header("Location: /bgt/admin/clients/create");
        exit;
    }
    if(isset($_POST['nrcpf_cnpj']) && $_POST['nrcpf_cnpj'] == '')
    {
        Clients_bgt::setError("Preencha o CPF / CNPJ corretamente.");
        Header("Location: /bgt/admin/clients/create");
        exit;
    }
    if(isset($_POST['des_rg_ie']) && $_POST['des_rg_ie'] == '')
    {
        Clients_bgt::setError("Preencha o RG / IE corretamente.");
        Header("Location: /bgt/admin/clients/create");
        exit;
    }
    if(isset($_POST['dessex']) && $_POST['dessex'] == '')
    {
        Clients_bgt::setError("Preencha sexo do cliente. Opções disponíveis: Masculino, Feminino ou Outro.");
        Header("Location: /bgt/admin/clients/create");
        exit;
    }
    if(isset($_POST['des_marital_status']) && $_POST['des_marital_status'] == '')
    {
        Clients_bgt::setError("Preencha o estado civil do cliente. Opções disponíveis: Solteiro(a), Casado(a), Viúvo(a) ou Divorciado(a)");
        Header("Location: /bgt/admin/clients/create");
        exit;
    }
    if(isset($_POST['dt_of_birth']) && $_POST['dt_of_birth'] == '')
    {
        Clients_bgt::setError("Preencha a data de nascimento corretamente.");
        Header("Location: /bgt/admin/clients/create");
        exit;
    }
    if(isset($_POST['des_email']) && $_POST['des_email'] == '')
    {
        Clients_bgt::setError("Preencha o e-mail corretamente.");
        Header("Location: /bgt/admin/clients/create");
        exit;
    }
    if(isset($_POST['nr_telephone']) && $_POST['nr_telephone'] == '')
    {
        Clients_bgt::setError("Preencha o telefone corretamente.");
        Header("Location: /bgt/admin/clients/create");
        exit;
    }
    if(isset($_POST['nr_cell_phone']) && $_POST['nr_cell_phone'] == '')
    {
        Clients_bgt::setError("Preencha o celular corretamente.");
        Header("Location: /bgt/admin/clients/create");
        exit;
    }
    if(isset($_POST['des_payment']) && $_POST['des_payment'] == '')
    {
        Clients_bgt::setError("Preencha a forma de pagamento corretamente. Opções disponíveis: Cartão de Crédito, Boleto, Carnê ou Anual.");
        Header("Location: /bgt/admin/clients/create");
        exit;
    }
    
    $client = new Clients_bgt();
    $client->setData($_POST);
    $client->save($_POST['desname'], verifyCNPJ($_POST['nrcpf_cnpj']));
    
    header("Location: /bgt/admin/clients");
    exit;
    
});
$app->get('/bgt/admin/clients/create-update', function(){
    
    \BIG\Model\Users_bgt::verifyLogin(); 
    $address = new Address();
    $clients = new Clients_bgt();
    $clients->setData($_POST);
    
    if(isset($_GET['des_cep']))
    {
        $address->loadFromCEP($_GET['des_cep']);
    }
    
    if(!$clients->getdes_situation()){
        if(isset($_GET['des_situation'])){
            $clients->setdes_situation($_GET['des_situation']);
        }else{
            $clients->setdes_situation('');
        }
    }
    if(!$clients->getdes_plataform_name()){
        if(isset($_GET['des_plataform_name'])){
            $clients->setdes_plataform_name($_GET['des_plataform_name']);
        }else{
            $clients->setdes_plataform_name('');
        }
    }
    if(!$clients->getdesname()){
        if(isset($_GET['desname'])){
            $clients->setdesname($_GET['desname']);
        }else{
            $clients->setdesname('');
        }
    }
    if(!$clients->getdes_fantasy_name()){
        if(isset($_GET['des_fantasy_name'])){
            $clients->setdes_fantasy_name($_GET['des_fantasy_name']);
        }else{
            $clients->setdes_fantasy_name('');
        }
        
    }
    if(!$clients->getnrcpf_cnpj()){
        if(isset($_GET['nrcpf_cnpj'])){
            $clients->setnrcpf_cnpj($_GET['nrcpf_cnpj']);
        }else{
            $clients->setnrcpf_cnpj('');
        }
        
    }
    if(!$clients->getdes_rg_ie()){
        if(isset($_GET['des_rg_ie'])){
            $clients->setdes_rg_ie($_GET['des_rg_ie']);
        }else{
            $clients->setdes_rg_ie('');
        }
        
    }
    if(!$clients->getdessex()){
        if(isset($_GET['dessex'])){
            $clients->setdessex($_GET['dessex']);
        }else{
           $clients->setdessex(''); 
        }
        
    }
    if(!$clients->getdes_marital_status()){
        if(isset($_GET['des_marital_status'])){
            $clients->setdes_marital_status($_GET['des_marital_status']);
        }else{
            $clients->setdes_marital_status('');
        }
        
    }
    if(!$clients->getnr_cnh()){
        if(isset($_GET['nr_cnh'])){
            $clients->setnr_cnh($_GET['nr_cnh']);
        }else{
           $clients->setnr_cnh(''); 
        }
        
    }
    if(!$clients->getdt_of_birth()){
        if(isset($_GET['dt_of_birth'])){
            $clients->setdt_of_birth($_GET['dt_of_birth']);
        }else{
            $clients->setdt_of_birth('');  
        }
        
    }
    if(!$clients->getdes_email()){
        if(isset($_GET['des_email'])){
            $clients->setdes_email($_GET['des_email']);
        }else{
           $clients->setdes_email(''); 
        }
        
    }
    if(!$clients->getnr_telephone()){
        if(isset($_GET['nr_telephone'])){
            $clients->setnr_telephone($_GET['nr_telephone']);
        }else{
            $clients->setnr_telephone('');
        }
        
    }
    if(!$clients->getnr_cell_phone()){
        if(isset($_GET['nr_cell_phone'])){
            $clients->setnr_cell_phone($_GET['nr_cell_phone']);
        }else{
            $clients->setnr_cell_phone('');
        }
        
    }
//    if(!$clients->getdes_cep()){
//        if(isset()){
//            
//        }else{
//            
//        }
//        $clients->setdes_cep('');
//    }
    if(!$clients->getdes_address()){
        if(isset($_GET['des_address'])){
            $clients->setdes_address($_GET['des_address']);
        }else{
          $clients->setdes_address('');  
        }
        
    }
    if(!$clients->getdes_number()){
        if(isset($_GET['des_number'])){
            $clients->setdes_number($_GET['des_number']);
        }else{
           $clients->setdes_number(''); 
        }
        
    }
    if(!$clients->getdes_neighborhood()){
        if(isset($_GET['des_neighborhood'])){
            $clients->setdes_neighborhood($_GET['des_neighborhood']);
        }else{
            $clients->setdes_neighborhood('');
        }
        
    }
    if(!$clients->getdes_city()){
        if(isset($_GET['des_city'])){
            $clients->setdes_city($_GET['des_city']);
        }else{
           $clients->setdes_city(''); 
        }
        
    }
    if(!$clients->getdes_complement()){
        if(isset($_GET['des_complement'])){
            $clients->setdes_complement($_GET['des_complement']);
        }else{
           $clients->setdes_complement(''); 
        }
        
    }
    if(!$clients->getdes_state()){
        if(isset($_GET['des_state'])){
            $clients->setdes_state($_GET['des_state']);
        }else{
           $clients->setdes_state(''); 
        }
        
    }
    if(!$clients->getdes_name_person1()){
        if(isset($_GET['des_name_person1'])){
            $clients->setdes_name_person1($_GET['des_name_person1']);
        }else{
           $clients->setdes_name_person1(''); 
        }
        
    }
    if(!$clients->getdes_kinship_person1()){
        if(isset($_GET['des_kinship_person1'])){
            $clients->setdes_kinship_person1($_GET['des_kinship_person1']);
        }else{
            $clients->setdes_kinship_person1('');
        }
        
    }
    if(!$clients->getdes_phone_kinship_person1()){
        if(isset($_GET['des_phone_kinship_person1'])){
            $clients->setdes_phone_kinship_person1($_GET['des_phone_kinship_person1']);
        }else{
           $clients->setdes_phone_kinship_person1(''); 
        }
        
    }
    if(!$clients->getdes_cellphone_kinship_person1()){
        if(isset($_GET['des_cellphone_kinship_person1'])){
            $clients->setdes_cellphone_kinship_person1($_GET['des_cellphone_kinship_person1']);
        }else{
            $clients->setdes_cellphone_kinship_person1('');
        }
        
    }
    if(!$clients->getdes_name_person2()){
        if(isset($_GET['des_name_person2'])){
            $clients->setdes_name_person2($_GET['des_name_person2']);
        }else{
           $clients->setdes_name_person2(''); 
        }
        
    }
    if(!$clients->getdes_kinship_person2()){
        if(isset($_GET['des_kinship_person2'])){
           $clients->setdes_kinship_person2($_GET['des_kinship_person2']); 
        }else{
           $clients->setdes_kinship_person2('');  
        }
        
    }
    if(!$clients->getdes_phone_kinship_person2()){
        if(isset($_GET['des_phone_kinship_person2'])){
            $clients->setdes_phone_kinship_person2($_GET['des_phone_kinship_person2']);
        }else{
            $clients->setdes_phone_kinship_person2('');
        }
        
    }
    if(!$clients->getdes_cellphone_kinship_person2()){
        if(isset($_GET['des_cellphone_kinship_person2'])){
           $clients->setdes_cellphone_kinship_person2($_GET['des_cellphone_kinship_person2']); 
        }else{
           $clients->setdes_cellphone_kinship_person2(''); 
        }
        
    }
    if(!$clients->getdes_payment()){
        if(isset($_GET['des_payment'])){
            $clients->setdes_payment($_GET['des_payment']);
        }else{
            $clients->setdes_payment(''); 
        }
        
    }
    if(!$clients->getdes_archive_client()){
        if(isset($_GET['des_archive_client'])){
            $clients->setdes_archive_client($_GET['des_archive_client']);
        }else{
            $clients->setdes_archive_client('');
        }
        
    }
    if(!$clients->getdes_obs_client()){
        if(isset($_GET['des_obs_client'])){
            $clients->setdes_obs_client($_GET['des_obs_client']);
        }else{
            $clients->setdes_obs_client('');
        }
        
    }
    
    $page = new PageAdmin();
    $page->setTpl("clients-create", [
        'address'=>$address->getValues(),
        'clients'=>$clients->getValues(),
        'error'=>Address::getMsgError()
    ]);
    
});
$app->post('/bgt/admin/clients/create-update', function(){
    
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
    $client->save($_POST['desname'], verifyCNPJ($_POST['nrcpf_cnpj']));
    
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
    $client->update($_POST['desname'], $_POST['nrcpf_cnpj']);
    
    header("Location: /bgt/admin/clients");
    exit;
    
});
$app->get('/bgt/admin/clients/update', function(){
    
    \BIG\Model\Users_bgt::verifyLogin();
    $page = new PageAdmin();
    $page->setTpl("clients-update");
});

