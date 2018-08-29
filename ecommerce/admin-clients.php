<?php

use \BIG\PageAdmin;
use \BIG\Model\Clients_bgt;
use \BIG\Model\Address;
use \BIG\Model\QueriesWebService;
use \Bissolli\ValidadorCpfCnpj\Documento;
use \BIG\DB\Sql;

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
    
//    if(isset($_GET['search']) && $_GET['search'] === ''){
//        
//        Clients_bgt::setError("Preencha o campo de busca.");
//        
//    }
    if( $pagination['data'] == NULL && $search != '' || $search === ' ' )
    {
        Clients_bgt::setError("Dados não encontrados.");
    }else{
        
        if(isset($_GET['search']) && $_GET['search'] !== '' ){
            Clients_bgt::setSuccess("Dados encontrados com sucesso.");
        }
        
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
        'msgError'=>Clients_bgt::getError(),
        'msgSuccess'=>Clients_bgt::getSuccess(),
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
$app->get('/bgt/admin/clients/registerCNPJ', function(){
    
    \BIG\Model\Users_bgt::verifyLogin();
    
    $queryWebService = new QueriesWebService();
    $queryCEP = new QueriesWebService();
    
    if(isset($_GET['nrcnpj']))
    {
        $queryWebService->loadFromCNPJ($_GET['nrcnpj']);
        $numCEP = $queryWebService->getValues()['des_cep'];
        $queryCEP->loadFromCEP( $numCEP ); // busca de dados no loadFRomCEP
    }
    
    if(!$queryWebService->getnrcpf_cnpj()){
        $queryWebService->setnrcpf_cnpj('');
    }
    if(!$queryWebService->getdt_of_birth_create()){
        $queryWebService->setdt_of_birth_create('');
    }
    if(!$queryWebService->getdes_cadastral_situation()){
        $queryWebService->setdes_cadastral_situation('');
    }
    if(!$queryWebService->getdes_voucher_issued()){
        $queryWebService->setdes_voucher_issued('');
    }
    if(!$queryWebService->getdes_dt_voucher_issued()){
        $queryWebService->setdes_dt_voucher_issued('');
    }
    if(!$queryWebService->getdesname_cnpj()){
        $queryWebService->setdesname_cnpj('');
    }
    if(!$queryWebService->getdes_fantasy_name()){
        $queryWebService->setdes_fantasy_name('');
    }
    if(!$queryWebService->getdes_main_activity()){
        $queryWebService->setdes_main_activity('');
    }
    if(!$queryWebService->getdes_company_situation()){
        $queryWebService->setdes_company_situation('');
    }
    if(!$queryWebService->getnr_telephone()){
        $queryWebService->setnr_telephone('');
    }
    if(!$queryWebService->getdes_cep()){
        $queryWebService->setdes_cep('');
    }
    if(!$queryWebService->getdes_address()){
        $queryWebService->setdes_address('');
    }
    if(!$queryWebService->getdes_neighborhood()){
        $queryWebService->setdes_neighborhood('');
    }
    if(!$queryWebService->getdes_city()){
        $queryWebService->setdes_city('');
    }
    if(!$queryWebService->getdes_number()){
        $queryWebService->setdes_number('');
    }
    if(!$queryWebService->getdes_complement()){
        $queryWebService->setdes_complement('');
    }
    if(!$queryWebService->getdes_state()){
        $queryWebService->setdes_state('');
    }
    if(!$queryWebService->getdes_country()){
        $queryWebService->setdes_country('');
    }
    if(!$queryWebService->getdes_cod_ibge_uf()){
        $queryWebService->setdes_cod_ibge_uf('');
    }
    if(!$queryWebService->getdes_cod_ibge_municipio()){
        $queryWebService->setdes_cod_ibge_municipio('');
    }
    if(!$queryWebService->getdes_country()){
        $queryWebService->setdes_country('');
    }
    if(!$queryWebService->getdes_latitude()){
        $queryWebService->setdes_latitude('');
    }
    if(!$queryWebService->getdes_longitude()){
        $queryWebService->setdes_longitude('');
    }
    
    $page = new PageAdmin();
    $page->setTpl("clients-create_cnpj", [
        'queriesWebService'=>$queryWebService->getValues(),
        'queryCEP'=>$queryCEP->getValues(),
        'registerValues'=>(isset($_SESSION['registerValues']) ? $_SESSION['registerValues'] : ['des_situation'=>'', 'desname'=>'', 
            'des_fantasy_name'=>'', 'des_plataform_name'=>'', 'nrcpf_cnpj'=>'', 'des_rg_ie'=>'', 'dessex'=>'',
            'des_marital_status'=>'', 'nr_cnh'=>'', 'dt_of_birth'=>'', 'des_email'=>'', 'nr_telephone'=>'', 
            'nr_cell_phone'=>'', 'des_cep'=>'', 'des_address'=>'', 'des_number'=>'', 'des_neighborhood'=>'', 
            'des_city'=>'', 'des_complement'=>'' , 'des_state'=>'' , 'des_name_person1'=>'', 'des_kinship_person1'=>'', 
            'des_phone_kinship_person1'=>'', 'des_cellphone_kinship_person1'=>'', 'des_name_person2'=>'', 'des_kinship_person2'=>'', 
            'des_phone_kinship_person2'=>'', 'des_cellphone_kinship_person2'=>'', 'des_payment'=>'', 'des_grouped'=>'', 
            'des_plan'=>'', 'des_archive1_client'=>'', 'des_archive2_client'=>'', 'des_archive3_client'=>'', 
            'des_obs_client'=>''])
    ]);
    
});
$app->post('/bgt/admin/clients/registerCNPJ', function(){
    
    \BIG\Model\Users_bgt::verifyLogin();
        
    if(!isset($_POST['nrcpf_cnpj']) || $_POST['nrcpf_cnpj'] === '')
    {
        QueriesWebService::setMsgError("Informe o Número do CNPJ.");
        header("Location: /bgt/admin/clients/create");
        exit;
    }
    
    $query = new QueriesWebService();
    $query->setData( $_POST );
    $query->saveRegisterCNPJ($_POST['desname'], verifyCNPJ($_POST['nrcpf_cnpj']));
    
    header("Location: /bgt/admin/clients");
    exit;
    
});
$app->get('/bgt/admin/clients/registerCPF', function(){
    
    \BIG\Model\Users_bgt::verifyLogin();
    
    $queryWebService = new QueriesWebService();
    $queryCEP = new QueriesWebService();
    
    if(isset($_GET['nrcpf']) && $_GET['nrcpf'] && isset($_GET['dt_of_birth_create']) && $_GET['dt_of_birth_create']
            && $_GET['des_cep_create'])
    {
        $queryWebService->loadFromBirthdayCPF($_GET['nrcpf'], $_GET['dt_of_birth_create'], $_GET['des_cep_create']);
        //$queryCEP->loadFromCEP( $_GET['des_cep'] ); // busca de dados no loadFromCEP
        $queryCEP->loadFromCEP( $_GET['des_cep_create'] ); // busca de dados no loadFRomCEP
    }
    
//    var_dump($queryCEP->getValues());
//    exit;
    
    if(!$queryWebService->getnrcpf_cnpj()){
        $queryWebService->setnrcpf_cnpj('');
    }
    if(!$queryWebService->getdt_of_birth_create()){
        $queryWebService->setdt_of_birth_create('');
    }
    if(!$queryWebService->getdes_cadastral_situation()){
        $queryWebService->setdes_cadastral_situation('');
    }
    if(!$queryWebService->getdes_voucher_issued()){
        $queryWebService->setdes_voucher_issued('');
    }
    if(!$queryWebService->getdes_dt_voucher_issued()){
        $queryWebService->setdes_dt_voucher_issued('');
    }
    if(!$queryWebService->getdesname_cnpj()){
        $queryWebService->setdesname_cnpj('');
    }
    if(!$queryWebService->getdes_fantasy_name()){
        $queryWebService->setdes_fantasy_name('');
    }
    if(!$queryWebService->getdes_main_activity()){
        $queryWebService->setdes_main_activity('');
    }
    if(!$queryWebService->getdes_company_situation()){
        $queryWebService->setdes_company_situation('');
    }
    if(!$queryWebService->getnr_telephone()){
        $queryWebService->setnr_telephone('');
    }
    if(!$queryCEP->getdes_cep()){
        $queryCEP->setdes_cep('');
    }
    if(!$queryCEP->getdes_address()){
        $queryCEP->setdes_address('');
    }
    if(!$queryCEP->getdes_neighborhood()){
        $queryCEP->setdes_neighborhood('');
    }
    if(!$queryCEP->getdes_city()){
        $queryCEP->setdes_city('');
    }
    if(!$queryCEP->getdes_number()){
        $queryCEP->setdes_number('');
    }
    if(!$queryCEP->getdes_complement()){
        $queryCEP->setdes_complement('');
    }
    if(!$queryCEP->getdes_state()){
        $queryCEP->setdes_state('');
    }
    if(!$queryCEP->getdes_country()){
        $queryCEP->setdes_country('');
    }
    if(!$queryCEP->getdes_cod_ibge_uf()){
        $queryCEP->setdes_cod_ibge_uf('');
    }
    if(!$queryCEP->getdes_cod_ibge_municipio()){
        $queryCEP->setdes_cod_ibge_municipio('');
    }
    if(!$queryCEP->getdes_country()){
        $queryCEP->setdes_country('');
    }
    if(!$queryCEP->getdes_latitude()){
        $queryCEP->setdes_latitude('');
    }
    if(!$queryCEP->getdes_longitude()){
        $queryCEP->setdes_longitude('');
    }
    
//    var_dump($queryWebService->getValues());
//    exit;
    
    $page = new PageAdmin();
    $page->setTpl("clients-create_cpf-birthday", [
        'queriesWebService'=>$queryWebService->getValues(),
        'queryCEP'=>$queryCEP->getValues()
    ]);
    
});
$app->post('/bgt/admin/clients/registerCPF', function(){
    
    \BIG\Model\Users_bgt::verifyLogin();
    
//    if(!isset($_POST['nrcpf']) || $_POST['nrcpf'] === '')
//    {
//        Clients_bgt::setError("Informe o Número do CPF e / ou a Data de Nascimento.");
//        header("Location: /bgt/admin/clients/create");
//        exit;
//    }
    
    $client = new Clients_bgt();
    $client->setData( $_POST );
    $client->saveRegisterCPF_Birthday($_POST['desname'], verifyCNPJ($_POST['nrcpf_cnpj']));
    
    header("Location: /bgt/admin/clients");
    exit;  
    
});
//$app->get('/bgt/admin/clients/registerCEP', function(){
//    
//    \BIG\Model\Users_bgt::verifyLogin();
//    
//    $queryCEP = new QueriesWebService(); // busca de dados no loadFRomCEP
//    
//    if(isset($_GET['des_cep']))
//    {
//        $queryCEP->loadFromCEP($_GET['des_cep']);
//    }
//    
//    if(!$queryCEP->getdes_cep()){
//        $queryCEP->setdes_cep('');
//    }
//    if(!$queryCEP->getdes_address()){
//        $queryCEP->setdes_address('');
//    }
//    if(!$queryCEP->getdes_neighborhood()){
//        $queryCEP->setdes_neighborhood('');
//    }
//    if(!$queryCEP->getdes_city()){
//        $queryCEP->setdes_city('');
//    }
//    if(!$queryCEP->getdes_number()){
//        $queryCEP->setdes_number('');
//    }
//    if(!$queryCEP->getdes_state()){
//        $queryCEP->setdes_state('');
//    }
//    if(!$queryCEP->getdes_country()){
//        $queryCEP->setdes_country('');
//    }
//    if(!$queryCEP->getdes_cod_ibge_uf()){
//        $queryCEP->setdes_cod_ibge_uf('');
//    }
//    if(!$queryCEP->getdes_cod_ibge_municipio()){
//        $queryCEP->setdes_cod_ibge_municipio('');
//    }
//    if(!$queryCEP->getdes_latitude()){
//        $queryCEP->setdes_latitude('');
//    }
//    if(!$queryCEP->getdes_longitude()){
//        $queryCEP->setdes_longitude('');
//    }
//    
//    $page = new PageAdmin();
//    $page->setTpl("clients-create_cpf-birthday", [
//        'queryCEP'=>$queryCEP->getValues(),
//        'registerValues'=>(isset($_SESSION['registerValues']) ? $_SESSION['registerValues'] : ['des_situation'=>'', 'desname'=>'', 
//            'des_fantasy_name'=>'', 'des_plataform_name'=>'', 'nrcpf_cnpj'=>'', 'des_rg_ie'=>'', 'dessex'=>'',
//            'des_marital_status'=>'', 'nr_cnh'=>'', 'dt_of_birth'=>'', 'des_email'=>'', 'nr_telephone'=>'', 
//            'nr_cell_phone'=>'', 'des_cep'=>'', 'des_address'=>'', 'des_number'=>'', 'des_neighborhood'=>'', 
//            'des_city'=>'', 'des_complement'=>'' , 'des_state'=>'' , 'des_name_person1'=>'', 'des_kinship_person1'=>'', 
//            'des_phone_kinship_person1'=>'', 'des_cellphone_kinship_person1'=>'', 'des_name_person2'=>'', 'des_kinship_person2'=>'', 
//            'des_phone_kinship_person2'=>'', 'des_cellphone_kinship_person2'=>'', 'des_payment'=>'', 'des_grouped'=>'', 
//            'des_plan'=>'', 'des_archive1_client'=>'', 'des_archive2_client'=>'', 'des_archive3_client'=>'', 
//            'des_obs_client'=>''])
//    ]);
//    
//});
//$app->post('/bgt/admin/clients/registerCEP', function(){
//    
//    \BIG\Model\Users_bgt::verifyLogin();
//    
//    $_SESSION['registerValues'] = $_POST;
//    
//    $client = new Clients_bgt();
//    $client->setData( $_POST );
//    $client->save( $_POST['desname'], verifyCNPJ($_POST['nrcpf_cnpj']) );  
//    
//});

$app->get('/bgt/admin/clients/create', function(){
    
    \BIG\Model\Users_bgt::verifyLogin();
    
    $queryWebService = new QueriesWebService();
    $queryCEP = new QueriesWebService();
    
    if(isset($_GET['nrcnpj']))
    {
        $queryWebService->loadFromCNPJ($_GET['nrcnpj']);
        $numCEP = $queryWebService->getValues()['des_cep'];
        $queryCEP->loadFromCEP( $numCEP ); // busca de dados no loadFRomCEP
    }
    
    if(isset($_GET['nrcpf']) && $_GET['dt_of_birth_create'])
    {
        $queryWebService->loadFromBirthdayCPF($_GET['nrcpf'], $_GET['dt_of_birth_create']);
    }
    
    
    $page = new PageAdmin();
    $page->setTpl("clients-create", [
        'queriesWebService'=>$queryWebService->getValues(),
        'queryCEP'=>$queryCEP->getValues(),
        'registerValues'=>(isset($_SESSION['registerValues']) ? $_SESSION['registerValues'] : ['des_situation'=>'', 'desname'=>'', 
            'des_fantasy_name'=>'', 'des_plataform_name'=>'', 'nrcpf_cnpj'=>'', 'des_main_activity'=>'', 
            'des_company_situation'=>'', 'des_rg_ie'=>'', 'dessex'=>'',
            'des_marital_status'=>'', 'nr_cnh'=>'', 'dt_of_birth'=>'', 'des_email'=>'', 'nr_telephone'=>'', 
            'nr_cell_phone'=>'', 'des_cep'=>'', 'des_address'=>'', 'des_number'=>'', 'des_neighborhood'=>'', 
            'des_city'=>'', 'des_complement'=>'' , 'des_state'=>'' , 'des_name_person1'=>'', 'des_kinship_person1'=>'', 
            'des_phone_kinship_person1'=>'', 'des_cellphone_kinship_person1'=>'', 'des_name_person2'=>'', 'des_kinship_person2'=>'', 
            'des_phone_kinship_person2'=>'', 'des_cellphone_kinship_person2'=>'', 'des_payment'=>'', 'des_grouped'=>'', 
            'des_plan'=>'', 'des_archive1_client'=>'', 'des_archive2_client'=>'', 'des_archive3_client'=>'', 
            'des_obs_client'=>''])
    ]);
    
});
//$app->post('/bgt/admin/clients/create', function(){
//    
//    \BIG\Model\Users_bgt::verifyLogin();
//    
//    $_SESSION['registerValues'] = $_POST;
//    
//    $verify_cpf_cnpj = new Documento($_POST['nrcpf_cnpj']);
//    $verifyCPF_CNPJ = Clients_bgt::verifyCPF_CNPJinDB($_POST['nrcpf_cnpj']);
//    
//    // Retorna se é CPF ou CNPJ 
//    // Retorna se for um número inválido retorna false
////    $verify_cpf_cnpj->getType();
//    // Verifica se é um número válido de CNPJ ou CPF
//    // Retorna true/false
////    $verify_cpf_cnpj->isValid();
//    // Retorna o número de formatado de acordo com tipo de documento informado
//    // ou false caso não seja um número válido
////    $verify_cpf_cnpj->format();
//    // Retorna o número de sem formatação alguma
//    // ou false caso não seja um número válido
////    $verify_cpf_cnpj->getValue();
//    
//    $client = new Clients_bgt();
//    $client->setData( $_POST );
//    $client->save( $_POST['desname'], verifyCNPJ($_POST['nrcpf_cnpj']) );
////    unset($_POST, $_GET);
////    session_unset($_SESSION);
////    $_SESSION['registerValues'] = NULL;
//    unset($_SESSION['registerValues']);// limpa a variavel registerValues
//    
//    header("Location: /bgt/admin/clients");
//    exit;
//    
//});
$app->get('/bgt/admin/clients/cnpj', function(){
    
    \BIG\Model\Users_bgt::verifyLogin(); 
    
    $address = new Address();
    $clients = new Clients_bgt();
    $clients->getValues();
    
    //$payments = $clients->getValues()['getdes_payment()'];
    
    if(isset($_GET['nrcpf_cnpj']))
    {
        $address->loadCNPJ($_GET['nrcpf_cnpj']);
    }
    
    $page = new PageAdmin();
    $page->setTpl("clients-create", [
        'error'=> Clients_bgt::getError(),
        'address'=>$address->getValues(),
        'errorAddress'=> Address::getMsgError(),
        'clients'=>$clients->getValues()
    ]);

    
});
$app->get('/bgt/admin/clients/create-update', function(){
    
    \BIG\Model\Users_bgt::verifyLogin(); 
    
    $address = new Address();
    $clients = new Clients_bgt();
    $clients->setData($_POST);
    
    // verificamos se o campo des_cep existe e carregamos os dados atraves da funcao loadFromCEP
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
    $page->setTpl("clients-update", [
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
    $client->delete((int)$idclient);
    
    header("Location: /bgt/admin/clients");
    exit;
    
    
});
$app->get('/bgt/admin/clients/:idclient', function($idclient){
    
    \BIG\Model\Users_bgt::verifyLogin();
    
    $address = new Address();
    $clients = new Clients_bgt();
    $clients->get((int)$idclient);
    $clients->getValues();
    $pages = (isset($_GET['page'])) ? (int)$_GET['page']:1;
    $pagination = Clients_bgt::getPage($pages);
    
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
    if(!$clients->getdes_country()){
        if(isset($_GET['des_country'])){
            $clients->setdes_country($_GET['des_country']);
        }else{
           $clients->setdes_country(''); 
        }
        
    }
    if(!$clients->getdes_cod_ibge_uf()){
        if(isset($_GET['des_cod_ibge_uf'])){
            $clients->setdes_cod_ibge_uf($_GET['des_cod_ibge_uf']);
        }else{
           $clients->setdes_cod_ibge_uf(''); 
        }
    }
    if(!$clients->getdes_cod_ibge_municipio()){
        if(isset($_GET['des_cod_ibge_municipio'])){
            $clients->setdes_cod_ibge_municipio($_GET['des_cod_ibge_municipio']);
        }else{
           $clients->setdes_cod_ibge_municipio(''); 
        }
    }
    if(!$clients->getdes_latitude()){
        if(isset($_GET['des_latitude'])){
            $clients->setdes_latitude($_GET['des_latitude']);
        }else{
           $clients->setdes_latitude(''); 
        }
    }
    if(!$clients->getdes_longitude()){
        if(isset($_GET['des_longitude'])){
            $clients->setdes_longitude($_GET['des_longitude']);
        }else{
           $clients->setdes_longitude(''); 
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
    if(!$clients->getdes_grouped()){
        if(isset($_GET['des_grouped'])){
            $clients->setdes_grouped($_GET['des_grouped']);
        }else{
            $clients->setdes_grouped('');
        }
    }
    if(!$clients->getdes_plan()){
        if(isset($_GET['des_plan'])){
            $clients->setdes_plan($_GET['des_plan']);
        }else{
            $clients->setdes_plan('');
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
    
    
    $payments = $clients->getValues()[0]['des_payment']; // $_GET['des_payment']
    $array = convertStringArray($payments);
    
    $page = new PageAdmin();
    $page->setTpl("clients-update", array(
        'pagination'=>$pagination['data'],
        'payments'=>convertStringArray($payments),
        'clients'=>$clients->getValues()[0]
    ));
    
});
$app->post('/bgt/admin/clients/:idclient', function($idclient){
    
    \BIG\Model\Users_bgt::verifyLogin();
    
    $client = new Clients_bgt();
    $client->get((int)$idclient);
    $client->setData($_POST);
    $client->registerCPF_Birthday_update($_POST['desname'], $_POST['nrcpf_cnpj'], $idclient);
    
    header("Location: /bgt/admin/clients");
    exit;
    
});
$app->get('/bgt/admin/clients_cnpj/:idclient', function($idclient){
    
    \BIG\Model\Users_bgt::verifyLogin();
    
    $address = new Address();
    $clients = new Clients_bgt();
    $clients->get((int)$idclient);
    $clients->getValues();
    $pages = (isset($_GET['page'])) ? (int)$_GET['page']:1;
    $pagination = Clients_bgt::getPage($pages);

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
    if(!$clients->getdes_main_activity()){
        if(isset($_GET['des_main_activity'])){
            $clients->setddes_main_activity($_GET['des_main_activity']);
        }else{
            $clients->setdes_main_activity('');
        }
        
    }
    if(!$clients->getdes_company_situation()){
        if(isset($_GET['des_company_situation'])){
            $clients->setdes_company_situation($_GET['des_company_situation']);
        }else{
            $clients->setdes_company_situation('');
        }
        
    }
    if(!$clients->getnrcpf_cnpj()){
        if(isset($_GET['nrcpf_cnpj'])){
            $clients->setnrcpf_cnpj($_GET['nrcpf_cnpj']);
        }else{
            $clients->setnrcpf_cnpj('');
        }
        
    }
    if(!$clients->getdes_cadastral_situation()){
        if(isset($_GET['des_cadastral_situation'])){
            $clients->setdes_cadastral_situation($_GET['des_cadastral_situation']);
        }else{
            $clients->setdes_cadastral_situation('');
        }
        
    }
    if(!$clients->getdes_voucher_issued()){
        if(isset($_GET['des_voucher_issued'])){
            $clients->setdes_voucher_issued($_GET['des_voucher_issued']);
        }else{
            $clients->setdes_voucher_issued('');
        }
        
    }
    if(!$clients->getdes_dt_voucher_issued()){
        if(isset($_GET['des_dt_voucher_issued'])){
            $clients->setdes_dt_voucher_issued($_GET['des_dt_voucher_issued']);
        }else{
            $clients->setdes_dt_voucher_issued('');
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
    if(!$clients->getdes_country()){
        if(isset($_GET['des_country'])){
            $clients->setdes_country($_GET['des_country']);
        }else{
           $clients->setdes_country(''); 
        }
        
    }
    if(!$clients->getdes_cod_ibge_uf()){
        if(isset($_GET['des_cod_ibge_uf'])){
            $clients->setdes_cod_ibge_uf($_GET['des_cod_ibge_uf']);
        }else{
           $clients->setdes_cod_ibge_uf(''); 
        }
    }
    if(!$clients->getdes_cod_ibge_municipio()){
        if(isset($_GET['des_cod_ibge_municipio'])){
            $clients->setdes_cod_ibge_municipio($_GET['des_cod_ibge_municipio']);
        }else{
           $clients->setdes_cod_ibge_municipio(''); 
        }
    }
    if(!$clients->getdes_latitude()){
        if(isset($_GET['des_latitude'])){
            $clients->setdes_latitude($_GET['des_latitude']);
        }else{
           $clients->setdes_latitude(''); 
        }
    }
    if(!$clients->getdes_longitude()){
        if(isset($_GET['des_longitude'])){
            $clients->setdes_longitude($_GET['des_longitude']);
        }else{
           $clients->setdes_longitude(''); 
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
    if(!$clients->getdes_grouped()){
        if(isset($_GET['des_grouped'])){
            $clients->setdes_grouped($_GET['des_grouped']);
        }else{
            $clients->setdes_grouped('');
        }
    }
    if(!$clients->getdes_plan()){
        if(isset($_GET['des_plan'])){
            $clients->setdes_plan($_GET['des_plan']);
        }else{
            $clients->setdes_plan('');
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
//    var_dump($_GET['des_obs_client']);
//    exit;
    $payments = $clients->getValues()[0]['des_payment']; // $_GET['des_payment']
    $array = convertStringArray($payments);
    
//    var_dump($clients->getValues()[0]);
//    exit;
    
    $page = new PageAdmin();
    $page->setTpl("clients-update_cnpj", array(
        'pagination'=>$pagination['data'],
        'payments'=>convertStringArray($payments),
        'clients'=>$clients->getValues()[0]
    ));
    
});
$app->post('/bgt/admin/clients_cnpj/:idclient', function($idclient){
    
    \BIG\Model\Users_bgt::verifyLogin();
    
    $client = new Clients_bgt();
    $client->get((int)$idclient);
    $client->setData($_POST);
//    var_dump($_POST);
//    exit;
    $client->registerCNPJ_update($_POST['desname'], $_POST['nrcpf_cnpj'], $idclient);
    
    header("Location: /bgt/admin/clients");
    exit;
    
});
$app->get('/bgt/admin/clients/view/:idclient', function($idclient){
    
    \BIG\Model\Users_bgt::verifyLogin();
    
    $clients = new Clients_bgt();
    $clients->get((int)$idclient);
    
    $payments = $clients->getValues()[0]['des_payment']; // $_GET['des_payment']
    $array = convertStringArray($payments);
    
    
    $page = new PageAdmin([
        "header"=>false,
        "footer"=>false
    ]);
    $page->setTpl("clients-view", array(
        'clients'=>$clients->getValues()[0],
        'payments'=>convertStringArray($payments)
    ));
    
});
$app->get('/bgt/admin/clients/view-pdf-1/:idclient', function($idclient){
    
    \BIG\Model\Users_bgt::verifyLogin();
    
    $clients = new Clients_bgt();
    $clients->get((int)$idclient);
    
    $page = new PageAdmin([
        "header"=>false,
        "footer"=>false
    ]);
    
    $desname = convertNames($clients->getValues()[0]['desname']);
    
    $page->setTpl("clients-pdf-1", array(
        'clients'=>$clients->getValues()[0],
        'desname'=>$desname
    ));    
    
});
$app->get('/bgt/admin/clients/view-pdf-2/:idclient', function($idclient){
    
    \BIG\Model\Users_bgt::verifyLogin();
    
    $clients = new Clients_bgt();
    $clients->get((int)$idclient);
    
    $page = new PageAdmin([
        "header"=>false,
        "footer"=>false
    ]);
    
    $desname = convertNames($clients->getValues()[0]['desname']);
    
    $page->setTpl("clients-pdf-2", array(
        'clients'=>$clients->getValues()[0],
        'desname'=>$desname
    ));    
    
});
$app->get('/bgt/admin/clients/view-pdf-3/:idclient', function($idclient){
    
    \BIG\Model\Users_bgt::verifyLogin();
    
    $clients = new Clients_bgt();
    $clients->get((int)$idclient);
    
    $page = new PageAdmin([
        "header"=>false,
        "footer"=>false
    ]);
    
    $desname = convertNames($clients->getValues()[0]['desname']);
    
    $page->setTpl("clients-pdf-3", array(
        'clients'=>$clients->getValues()[0],
        'desname'=>$desname
    ));    
    
});
$app->get('/bgt/admin/clients-search/create-search', function(){
    
    \BIG\Model\Users_bgt::verifyLogin();
    
    $plan = $_GET['term'] . "%";
    
    $sql = new Sql();
    
    $query = "select p.idplan, p.des_name_plan
              from tb_plans p
              WHERE p.des_name_plan LIKE '" . $plan ."'";
    
    $plans = $sql->searchAutocompleteNames($query);
    
    echo json_encode($plans);
    
});
