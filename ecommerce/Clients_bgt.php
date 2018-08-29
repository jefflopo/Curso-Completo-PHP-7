<?php
namespace BIG\Model;
use \BIG\DB\Sql;
use \BIG\Model_bgt;
use \BIG\Model\Users_bgt;

class Clients_bgt extends Model_bgt 
{
    
    const ERROR = "ClientsError";
    const SUCCESS = "ClientsSuccess";
    
    public static function getCNPJ($nrcnpj)
    {
        
        $nrcnpj = str_replace("-", "", $nrcnpj);
        $nrcnpj = str_replace(".", "", $nrcnpj);
        
        $ch = curl_init();
        
        curl_setopt($ch, CURLOPT_URL, "https://www.receitaws.com.br/v1/cnpj/$nrcnpj");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        
        $data = json_decode(curl_exec($ch), true);
        
        curl_close($ch);
        
        return $data;
        
    }
    
    public function loadFromCNPJ($nrcnpj)
    {
        $data = Clients_bgt::getCNPJ($nrcnpj);
        
        if(isset($data['logradouro']) && $data['logradouro'])
        {
            
            $this->setdes_address($data['logradouro']);
            $this->setdes_complement($data['complemento']);
            $this->setdes_number($data['numero']);
            $this->setdes_neighborhood($data['bairro']);
            $this->setdes_city($data['municipio']);
            $this->setdes_state($data['uf']);
            $this->setdes_country('Brasil');
            $this->setdes_cep($data['cep']);
            $this->setdesname($data['nome']);
            $this->setdes_fantasy_name($data['fantasia']);
            $this->setnrcpf_cnpj($nrcnpj);
            
        }
    }

    public static function listAll(){
        
        $sql = new Sql();
        
        return $sql->select("SELECT * FROM tb_clients c INNER JOIN tb_persons p USING(idperson) ORDER BY c.idclient");
        
    }
    
    public static function listAllSearch(){
        
        $sql = new Sql();
        
        return $sql->select("SELECT desname FROM tb_clients");
        
    }
    
    // Função para salvar os dados quando estes forem todos preenchidos para CPF
    public function saveRegisterCPF_Birthday($nomecliente, $cpf_cnpj)
    {
        $sql = new Sql();
        
        // Repassa a variável do upload 
        //$arquivo = isset($_FILES["des_archive_client"]) ? $_FILES["des_archive_client"] : FALSE; 
        $arquivo1 = isset($_FILES["des_archive1_client"]) ? $_FILES["des_archive1_client"] : FALSE; 
        $arquivo2 = isset($_FILES["des_archive2_client"]) ? $_FILES["des_archive2_client"] : FALSE; 
        $arquivo3 = isset($_FILES["des_archive3_client"]) ? $_FILES["des_archive3_client"] : FALSE; 
        
        if(!$arquivo1 || !$arquivo2 || !$arquivo3)
        {
            $des_archive_client = 1;
            //$extensao = $arquivo["name"]; //pathinfo($arquivo["name"])
            $extensao1 = $arquivo1["name"]; //pathinfo($arquivo["name"])
            //$extensao = pathinfo($extensao, PATHINFO_EXTENSION); //$extensao['extension']
            $extensao1 = pathinfo($extensao1, PATHINFO_EXTENSION); //$extensao['extension']
            $extensao2 = $arquivo2["name"];
            $extensao2 = pathinfo($extensao2, PATHINFO_EXTENSION);
            $extensao3 = $arquivo3["name"];
            $extensao3 = pathinfo($extensao3, PATHINFO_EXTENSION);
            
            // Código acima... com as demais verificaçoes... 
            // Diretório para onde o arquivo será movido 
                    //$diretorio = "." . DIRECTORY_SEPARATOR . "archives" . DIRECTORY_SEPARATOR . $nomecliente . "-" . $cpf_cnpj . DIRECTORY_SEPARATOR;
                    $diretorio = "./archives/" . $nomecliente . "-" . $cpf_cnpj . "/";
            // Substitui espaços por underscores no nome do arquivo 
            //        $nomeArquivo = str_replace(" ", "_", $arquivo["name"]); 
            // Monta o nome do arquivo a ser salvo com o nome completo e cpf_cnpj
                    $nomeArquivo = $nomecliente . "-" . $cpf_cnpj;
            // Todas as letras em maiúsculo 
                    $nomeArquivo1 = strtoupper("Arquivo 1");
                    $nomeArquivo1 = $nomeArquivo1 . "." . $extensao1;
                    $nomeArquivo2 = strtoupper("Arquivo 2");
                    $nomeArquivo2 = $nomeArquivo2 . "." . $extensao2;
                    $nomeArquivo3 = strtoupper("Arquivo 3");
                    $nomeArquivo3 = $nomeArquivo3 . "." . $extensao3;
//                    $nomeArquivo = strtoupper($nomeArquivo) . "." . $extensao1; 
//                    $nomeArquivo = $nomeArquivo. "." . $extensao;
            // Caminho completo do arquivo 
                    //$nomeArquivo = $diretorio . $nomeArquivo; 
                    $nomeArquivo1 = $diretorio . $nomeArquivo1;
                    $nomeArquivo2 = $diretorio . $nomeArquivo2;
                    $nomeArquivo3 = $diretorio . $nomeArquivo3;
            // Verifica se o arquivo existe no diretório dado 
            //        if(file_exists($nomeArquivo)) { 
            //            echo "Um arquivo com esse nome já foi enviado! Envie outro arquivo!"; 
            //            exit;
            //        } 
            // Tudo ok! Então, move o arquivo 
            //        if(move_uploaded_file($arquivo["tmp_name"], $nomeArquivo)) { 
            //            echo "Arquivo Enviado com sucesso!";
            //        } else { 
            //            echo "Erro ao enviar seu arquivo!";         
            //        }
                    
            //":des_archive_client"=>move_uploaded_file($arquivo["tmp_name"], $nomeArquivo), //$this->getdes_archive_client()
                 
            move_uploaded_file($arquivo1["tmp_name"], $nomeArquivo1);
            move_uploaded_file($arquivo2["tmp_name"], $nomeArquivo2);
            move_uploaded_file($arquivo3["tmp_name"], $nomeArquivo3);
            
        }else{
            $des_archive_client = 0;
        }
        
//        var_dump( $this->getdes_cadastral_situation());
//        exit;
        
        $results = $sql->select("CALL sp_registerCPF_Birthday_save(
            :des_situation, :des_plataform_name, :nrcpf_cnpj, :des_main_activity, :des_company_situation, 
            :des_fantasy_name, :desname, :des_rg_ie, :dessex, :des_marital_status, 
            :nr_cnh, :dt_of_birth, :des_email, :nr_telephone, :nr_cell_phone, 
            :des_cep, :des_address, :des_number, :des_neighborhood, :des_city, 
            :des_complement, :des_state, :des_country, :des_cod_ibge_uf, :des_cod_ibge_municipio, 
            :des_latitude, :des_longitude, :des_name_person1, :des_kinship_person1, :des_phone_kinship_person1, 
            :des_cellphone_kinship_person1, :des_name_person2, :des_kinship_person2, :des_phone_kinship_person2, 
            :des_cellphone_kinship_person2, :des_payment, :des_grouped, :des_plan, :des_archive_client, :des_obs_client
        )",    
            array(
                ":des_situation"=>$this->getdes_situation(),
                ":des_plataform_name"=>utf8_encode($this->getdes_plataform_name()),
                ":nrcpf_cnpj"=>removeMaskCPF($this->getnrcpf_cnpj()),
                ":des_main_activity"=> utf8_encode($this->getdes_main_activity()),
                ":des_company_situation"=> utf8_encode($this->getdes_company_situation()),
                ":des_fantasy_name"=>utf8_encode($this->getdes_fantasy_name()),
                ":desname"=>utf8_encode($this->getdesname()),
                ":des_rg_ie"=>$this->getdes_rg_ie(),
                ":dessex"=>$this->getdessex(),
                ":des_marital_status"=>$this->getdes_marital_status(),
                ":nr_cnh"=>$this->getnr_cnh(),
                ":dt_of_birth"=>$this->getdt_of_birth(),
                ":des_email"=>$this->getdes_email(),
                ":nr_telephone"=>removeMaskTel($this->getnr_telephone()),
                ":nr_cell_phone"=>removeMaskCel($this->getnr_cell_phone()),
                ":des_cep"=>removeMaskCEP($this->getdes_cep()),
                ":des_address"=>$this->getdes_address(),
                ":des_number"=>$this->getdes_number(),
                ":des_neighborhood"=>$this->getdes_neighborhood(),
                ":des_city"=>$this->getdes_city(),
                ":des_complement"=>$this->getdes_complement(),
                ":des_state"=>$this->getdes_state(),
                ":des_country"=>$this->getdes_country(),
                ":des_cod_ibge_uf"=>$this->getdes_cod_ibge_uf(),
                ":des_cod_ibge_municipio"=>$this->getdes_cod_ibge_municipio(),
                ":des_latitude"=>$this->getdes_latitude(),
                ":des_longitude"=>$this->getdes_longitude(),
                ":des_name_person1"=>$this->getdes_name_person1(),
                ":des_kinship_person1"=>$this->getdes_kinship_person1(),
                ":des_phone_kinship_person1"=>removeMaskTel($this->getdes_phone_kinship_person1()),
                ":des_cellphone_kinship_person1"=>removeMaskCel($this->getdes_cellphone_kinship_person1()),
                ":des_name_person2"=>$this->getdes_name_person2(),
                ":des_kinship_person2"=>$this->getdes_kinship_person2(),
                ":des_phone_kinship_person2"=>removeMaskTel($this->getdes_phone_kinship_person2()),
                ":des_cellphone_kinship_person2"=>removeMaskCel($this->getdes_cellphone_kinship_person2()),
                ":des_payment"=>convertArrayString($this->getdes_payment()), // convertArrayString($this->getdes_payment())
                ":des_grouped"=>$this->getdes_grouped(),
                ":des_plan"=>$this->getdes_plan(),
                ":des_archive_client"=>$des_archive_client,
                ":des_obs_client"=>$this->getdes_obs_client()
            )
        );
        
        var_dump($results);
        exit;
        
        if (!$results > 0) {
            Clients_bgt::setError("Erro ao Cadastrar Cliente.");
        }else{
            Clients_bgt::setSuccess("Cliente Cadastrado com Sucesso.");
            $this->setData($results);
        }
        
//        ,
//            :des_cadastral_situation, :des_voucher_issued, :des_dt_voucher_issued
        
//        ,
//                ":des_cadastral_situation"=> utf8_encode($this->getdes_cadastral_situation()),
//                ":des_voucher_issued"=> utf8_encode($this->getdes_voucher_issued()),
//                ":des_dt_voucher_issued"=> utf8_encode($this->getdes_dt_voucher_issued())
    }
    
    public function save($nomecliente, $cpf_cnpj){
        
        $sql = new Sql();
        
        // Repassa a variável do upload 
        //$arquivo = isset($_FILES["des_archive_client"]) ? $_FILES["des_archive_client"] : FALSE; 
        $arquivo1 = isset($_FILES["des_archive1_client"]) ? $_FILES["des_archive1_client"] : FALSE; 
        $arquivo2 = isset($_FILES["des_archive2_client"]) ? $_FILES["des_archive2_client"] : FALSE; 
        $arquivo3 = isset($_FILES["des_archive3_client"]) ? $_FILES["des_archive3_client"] : FALSE; 
        
        if(!$arquivo1 || !$arquivo2 || !$arquivo3)
        {
            $des_archive_client = 1;
            //$extensao = $arquivo["name"]; //pathinfo($arquivo["name"])
            $extensao1 = $arquivo1["name"]; //pathinfo($arquivo["name"])
            //$extensao = pathinfo($extensao, PATHINFO_EXTENSION); //$extensao['extension']
            $extensao1 = pathinfo($extensao1, PATHINFO_EXTENSION); //$extensao['extension']
            $extensao2 = $arquivo2["name"];
            $extensao2 = pathinfo($extensao2, PATHINFO_EXTENSION);
            $extensao3 = $arquivo3["name"];
            $extensao3 = pathinfo($extensao3, PATHINFO_EXTENSION);
            
            // Código acima... com as demais verificaçoes... 
            // Diretório para onde o arquivo será movido 
                    //$diretorio = "." . DIRECTORY_SEPARATOR . "archives" . DIRECTORY_SEPARATOR . $nomecliente . "-" . $cpf_cnpj . DIRECTORY_SEPARATOR;
                    $diretorio = "./archives/" . $nomecliente . "-" . $cpf_cnpj . "/";
            // Substitui espaços por underscores no nome do arquivo 
            //        $nomeArquivo = str_replace(" ", "_", $arquivo["name"]); 
            // Monta o nome do arquivo a ser salvo com o nome completo e cpf_cnpj
                    $nomeArquivo = $nomecliente . "-" . $cpf_cnpj;
            // Todas as letras em maiúsculo 
                    $nomeArquivo1 = strtoupper("Arquivo 1");
                    $nomeArquivo1 = $nomeArquivo1 . "." . $extensao1;
                    $nomeArquivo2 = strtoupper("Arquivo 2");
                    $nomeArquivo2 = $nomeArquivo2 . "." . $extensao2;
                    $nomeArquivo3 = strtoupper("Arquivo 3");
                    $nomeArquivo3 = $nomeArquivo3 . "." . $extensao3;
//                    $nomeArquivo = strtoupper($nomeArquivo) . "." . $extensao1; 
//                    $nomeArquivo = $nomeArquivo. "." . $extensao;
            // Caminho completo do arquivo 
                    //$nomeArquivo = $diretorio . $nomeArquivo; 
                    $nomeArquivo1 = $diretorio . $nomeArquivo1;
                    $nomeArquivo2 = $diretorio . $nomeArquivo2;
                    $nomeArquivo3 = $diretorio . $nomeArquivo3;
            // Verifica se o arquivo existe no diretório dado 
            //        if(file_exists($nomeArquivo)) { 
            //            echo "Um arquivo com esse nome já foi enviado! Envie outro arquivo!"; 
            //            exit;
            //        } 
            // Tudo ok! Então, move o arquivo 
            //        if(move_uploaded_file($arquivo["tmp_name"], $nomeArquivo)) { 
            //            echo "Arquivo Enviado com sucesso!";
            //        } else { 
            //            echo "Erro ao enviar seu arquivo!";         
            //        }
                    
            //":des_archive_client"=>move_uploaded_file($arquivo["tmp_name"], $nomeArquivo), //$this->getdes_archive_client()
                 
            move_uploaded_file($arquivo1["tmp_name"], $nomeArquivo1);
            move_uploaded_file($arquivo2["tmp_name"], $nomeArquivo2);
            move_uploaded_file($arquivo3["tmp_name"], $nomeArquivo3);
            
        }else{
            $des_archive_client = 0;
        }

        $results = $sql->select("
            CALL sp_clients_save(
                :des_situation, :des_plataform_name, :desname, :des_fantasy_name, 
                :nrcpf_cnpj, :des_rg_ie, :dessex, :des_marital_status, :nr_cnh, :dt_of_birth,
                :des_email, :nr_telephone, :nr_cell_phone, :des_cep, :des_address, :des_number, :des_neighborhood, 
                :des_city, :des_complement, :des_state, :des_name_person1, :des_kinship_person1, :des_phone_kinship_person1, 
                :des_cellphone_kinship_person1, :des_name_person2, :des_kinship_person2, :des_phone_kinship_person2, 
                :des_cellphone_kinship_person2, :des_payment, :des_grouped, :des_plan, :des_archive_client, :des_obs_client
            )"
        ,    
            array(
                ":des_situation"=>$this->getdes_situation(),
                ":des_plataform_name"=>utf8_encode($this->getdes_plataform_name()),
                ":desname"=>utf8_encode($this->getdesname()),
                ":des_fantasy_name"=>utf8_encode($this->getdes_fantasy_name()),
                ":nrcpf_cnpj"=>removeMaskCPF($this->getnrcpf_cnpj()),
                ":des_rg_ie"=>$this->getdes_rg_ie(),
                ":dessex"=>$this->getdessex(),
                ":des_marital_status"=>$this->getdes_marital_status(),
                ":nr_cnh"=>$this->getnr_cnh(),
                ":dt_of_birth"=>$this->getdt_of_birth(),
                ":des_email"=>$this->getdes_email(),
                ":nr_telephone"=>removeMaskTel($this->getnr_telephone()),
                ":nr_cell_phone"=>removeMaskCel($this->getnr_cell_phone()),
                ":des_cep"=>removeMaskCEP($this->getdes_cep()),
                ":des_address"=>$this->getdes_address(),
                ":des_number"=>$this->getdes_number(),
                ":des_neighborhood"=>$this->getdes_neighborhood(),
                ":des_city"=>$this->getdes_city(),
                ":des_complement"=>$this->getdes_complement(),
                ":des_state"=>$this->getdes_state(),
                ":des_name_person1"=>$this->getdes_name_person1(),
                ":des_kinship_person1"=>$this->getdes_kinship_person1(),
                ":des_phone_kinship_person1"=>removeMaskTel($this->getdes_phone_kinship_person1()),
                ":des_cellphone_kinship_person1"=>removeMaskCel($this->getdes_cellphone_kinship_person1()),
                ":des_name_person2"=>$this->getdes_name_person2(),
                ":des_kinship_person2"=>$this->getdes_kinship_person2(),
                ":des_phone_kinship_person2"=>removeMaskTel($this->getdes_phone_kinship_person2()),
                ":des_cellphone_kinship_person2"=>removeMaskCel($this->getdes_cellphone_kinship_person2()),
                ":des_payment"=>$this->getdes_payment(), // convertArrayString($this->getdes_payment())
                ":des_grouped"=>$this->getdes_grouped(),
                ":des_plan"=>$this->getdes_plan(),
                ":des_archive_client"=>$des_archive_client,
                ":des_obs_client"=>$this->getdes_obs_client()
            )
        );
        
        if (!$results > 0) {
            Clients_bgt::setError("Erro ao Cadastrar Cliente.");
        }else{
            Clients_bgt::setSuccess("Cliente Cadastrado com Sucesso.");
            $this->setData($results);
        }
        
    }
    
    public function get($idclient){
        
        $sql = new Sql();
        
        $results = $sql->select("SELECT * FROM tb_clients c INNER JOIN tb_persons p USING(idperson) WHERE c.idclient = :idclient", array(
            ":idclient"=>$idclient
        ));

        $this->setData($results);
    }
    
    public function registerCPF_Birthday_update($nomeCliente, $cpf_cnpj, $idclient){
        
        $sql = new Sql();
        
        // Repassa a variável do upload 
        //$arquivo = isset($_FILES["des_archive_client"]) ? $_FILES["des_archive_client"] : FALSE; 
        $arquivo1 = isset($_FILES["des_archive1_client"]) ? $_FILES["des_archive1_client"] : FALSE; 
        $arquivo2 = isset($_FILES["des_archive2_client"]) ? $_FILES["des_archive2_client"] : FALSE; 
        $arquivo3 = isset($_FILES["des_archive3_client"]) ? $_FILES["des_archive3_client"] : FALSE;
        
        if(!$arquivo1 || !$arquivo2 || !$arquivo3)
        {
            $des_archive_client = 1;
            $extensao1 = $arquivo1["name"]; //pathinfo($arquivo["name"])
            $extensao1 = pathinfo($extensao1, PATHINFO_EXTENSION); //$extensao['extension']
            $extensao2 = $arquivo2["name"];
            $extensao2 = pathinfo($extensao2, PATHINFO_EXTENSION);
            $extensao3 = $arquivo3["name"];
            $extensao3 = pathinfo($extensao3, PATHINFO_EXTENSION);
    // Diretório para onde o arquivo será movido 
            //$diretorio = "." . DIRECTORY_SEPARATOR . "archives" . DIRECTORY_SEPARATOR; 
            $diretorio = "." . DIRECTORY_SEPARATOR . "archives" . DIRECTORY_SEPARATOR . $nomeCliente . "-" . $cpf_cnpj . DIRECTORY_SEPARATOR; 
    // Monta o nome do arquivo a ser salvo com o nome completo e cpf_cnpj
            //$nomeArquivo = $nomeCliente . "-" . $cpf_cnpj;
        //$nomeArquivo = str_replace(" ", "_", $nomeArquivo);
            //$nomeArquivo = $nomeArquivo . "." . $extensao;
            $nomeArquivo1 = strtoupper("Arquivo 1");
            $nomeArquivo1 = $nomeArquivo1 . "." . $extensao1;
            $nomeArquivo2 = strtoupper("Arquivo 2");
            $nomeArquivo2 = $nomeArquivo2 . "." . $extensao2;
            $nomeArquivo3 = strtoupper("Arquivo 3");
            $nomeArquivo3 = $nomeArquivo3 . "." . $extensao3;
        // Todas as letras em maiúsculo
            //$nomeArquivo = strtoupper($nomeArquivo); 
        // Caminho completo do arquivo 
            //$nomeArquivo = $diretorio . $nomeArquivo; 
            $nomeArquivo1 = $diretorio . $nomeArquivo1;
            $nomeArquivo2 = $diretorio . $nomeArquivo2;
            $nomeArquivo3 = $diretorio . $nomeArquivo3;
        // Verifica se o arquivo existe no diretório dado 
    //        if(file_exists($nomeArquivo)) { 
    //            echo "Um arquivo com esse nome já foi enviado! Envie outro arquivo!"; 
    //            exit;
    //        } 
            //":des_archive_client"=>$this->getdes_archive_client(),//move_uploaded_file($arquivo["tmp_name"], $nomeArquivo)
//            if(file_exists($nomeArquivo)) { 
//                //move_uploaded_file($arquivo["tmp_name"], $nomeArquivo);
//                chargeArchive($arquivo["tmp_name"], $nomeArquivo);
//            }else{
//                move_uploaded_file($arquivo["tmp_name"], $nomeArquivo);
//            }
            move_uploaded_file($arquivo1["tmp_name"], $nomeArquivo1);
            move_uploaded_file($arquivo2["tmp_name"], $nomeArquivo2);
            move_uploaded_file($arquivo3["tmp_name"], $nomeArquivo3);
            
        }else{
            $des_archive_client = 0;
        }  
        
            $results = $sql->select("
                    CALL sp_registerCPF_Birthday_update(
                        :idclient, :des_situation, :des_plataform_name, :nrcpf_cnpj, 
                        :desname, :des_rg_ie, :dessex, :des_marital_status, :nr_cnh, :dt_of_birth,
                        :des_email, :nr_telephone, :nr_cell_phone, :des_cep, :des_address, :des_number, :des_neighborhood, 
                        :des_city, :des_complement, :des_state,  :des_country, :des_cod_ibge_uf, :des_cod_ibge_municipio,
                        :des_latitude, :des_longitude, :des_name_person1, :des_kinship_person1, :des_phone_kinship_person1,
                        :des_cellphone_kinship_person1, :des_name_person2, :des_kinship_person2, :des_phone_kinship_person2,
                        :des_cellphone_kinship_person2, :des_payment, :des_grouped, :des_plan, :des_archive_client, :des_obs_client
                )", array(
                    ":idclient"=>$idclient,
                    ":des_situation"=>$this->getdes_situation(),
                    ":des_plataform_name"=>$this->getdes_plataform_name(),
                    ":nrcpf_cnpj"=>removeMaskCPF($this->getnrcpf_cnpj()),
                    ":desname"=>$this->getdesname(),                
                    ":des_rg_ie"=>$this->getdes_rg_ie(),
                    ":dessex"=>$this->getdessex(),
                    ":des_marital_status"=>$this->getdes_marital_status(),
                    ":nr_cnh"=>$this->getnr_cnh(),
                    ":dt_of_birth"=>$this->getdt_of_birth(),
                    ":des_email"=>$this->getdes_email(),
                    ":nr_telephone"=>removeMaskTel($this->getnr_telephone()),
                    ":nr_cell_phone"=>removeMaskCel($this->getnr_cell_phone()),
                    ":des_cep"=>removeMaskCEP($this->getdes_cep()),
                    ":des_address"=>$this->getdes_address(),
                    ":des_number"=>$this->getdes_number(),
                    ":des_neighborhood"=>$this->getdes_neighborhood(),
                    ":des_city"=>$this->getdes_city(),
                    ":des_complement"=>$this->getdes_complement(),
                    ":des_state"=>$this->getdes_state(),
                    ":des_country"=>$this->getdes_country(),
                    ":des_cod_ibge_uf"=>$this->getdes_cod_ibge_uf(),
                    ":des_cod_ibge_municipio"=>$this->getdes_cod_ibge_municipio(),
                    ":des_latitude"=>$this->getdes_latitude(),
                    ":des_longitude"=>$this->getdes_longitude(),
                    ":des_name_person1"=>$this->getdes_name_person1(),
                    ":des_kinship_person1"=>$this->getdes_kinship_person1(),
                    ":des_phone_kinship_person1"=>removeMaskTel($this->getdes_phone_kinship_person1()),
                    ":des_cellphone_kinship_person1"=>removeMaskCel($this->getdes_cellphone_kinship_person1()),
                    ":des_name_person2"=>$this->getdes_name_person2(),
                    ":des_kinship_person2"=>$this->getdes_kinship_person2(),
                    ":des_phone_kinship_person2"=>removeMaskTel($this->getdes_phone_kinship_person2()),
                    ":des_cellphone_kinship_person2"=>removeMaskCel($this->getdes_cellphone_kinship_person2()),
                    ":des_payment"=>convertArrayString($this->getdes_payment()),//explode("," , $this->getdes_payment())
                    ":des_grouped"=>$this->getdes_grouped(),
                    ":des_plan"=>$this->getdes_plan(),
                    ":des_archive_client"=>$des_archive_client,
                    ":des_obs_client"=>$this->getdes_obs_client()
                )
                    //:idclient,
                    //":idclient"=>$this->getidclient(),
            );

//            var_dump($results);
//            exit;

            if(!$results > 0){
                Clients_bgt::setError("Erro ao Atualizar os dados.");
            }else{
                Clients_bgt::setSuccess("Cliente Atualizado com Sucesso.");
                $this->setData($results);
            }
    }
    
    public function registerCNPJ_update($nomeCliente, $cpf_cnpj, $idclient){
        
        $sql = new Sql();
        
        // Repassa a variável do upload 
        //$arquivo = isset($_FILES["des_archive_client"]) ? $_FILES["des_archive_client"] : FALSE; 
        $arquivo1 = isset($_FILES["des_archive1_client"]) ? $_FILES["des_archive1_client"] : FALSE; 
        $arquivo2 = isset($_FILES["des_archive2_client"]) ? $_FILES["des_archive2_client"] : FALSE; 
        $arquivo3 = isset($_FILES["des_archive3_client"]) ? $_FILES["des_archive3_client"] : FALSE;
        
        if(!$arquivo1 || !$arquivo2 || !$arquivo3)
        {
            $des_archive_client = 1;
            $extensao1 = $arquivo1["name"]; //pathinfo($arquivo["name"])
            $extensao1 = pathinfo($extensao1, PATHINFO_EXTENSION); //$extensao['extension']
            $extensao2 = $arquivo2["name"];
            $extensao2 = pathinfo($extensao2, PATHINFO_EXTENSION);
            $extensao3 = $arquivo3["name"];
            $extensao3 = pathinfo($extensao3, PATHINFO_EXTENSION);
    // Diretório para onde o arquivo será movido 
            //$diretorio = "." . DIRECTORY_SEPARATOR . "archives" . DIRECTORY_SEPARATOR; 
            $diretorio = "." . DIRECTORY_SEPARATOR . "archives" . DIRECTORY_SEPARATOR . $nomeCliente . "-" . $cpf_cnpj . DIRECTORY_SEPARATOR; 
    // Monta o nome do arquivo a ser salvo com o nome completo e cpf_cnpj
            //$nomeArquivo = $nomeCliente . "-" . $cpf_cnpj;
        //$nomeArquivo = str_replace(" ", "_", $nomeArquivo);
            //$nomeArquivo = $nomeArquivo . "." . $extensao;
            $nomeArquivo1 = strtoupper("Arquivo 1");
            $nomeArquivo1 = $nomeArquivo1 . "." . $extensao1;
            $nomeArquivo2 = strtoupper("Arquivo 2");
            $nomeArquivo2 = $nomeArquivo2 . "." . $extensao2;
            $nomeArquivo3 = strtoupper("Arquivo 3");
            $nomeArquivo3 = $nomeArquivo3 . "." . $extensao3;
        // Todas as letras em maiúsculo
            //$nomeArquivo = strtoupper($nomeArquivo); 
        // Caminho completo do arquivo 
            //$nomeArquivo = $diretorio . $nomeArquivo; 
            $nomeArquivo1 = $diretorio . $nomeArquivo1;
            $nomeArquivo2 = $diretorio . $nomeArquivo2;
            $nomeArquivo3 = $diretorio . $nomeArquivo3;
        // Verifica se o arquivo existe no diretório dado 
    //        if(file_exists($nomeArquivo)) { 
    //            echo "Um arquivo com esse nome já foi enviado! Envie outro arquivo!"; 
    //            exit;
    //        } 
            //":des_archive_client"=>$this->getdes_archive_client(),//move_uploaded_file($arquivo["tmp_name"], $nomeArquivo)
//            if(file_exists($nomeArquivo)) { 
//                //move_uploaded_file($arquivo["tmp_name"], $nomeArquivo);
//                chargeArchive($arquivo["tmp_name"], $nomeArquivo);
//            }else{
//                move_uploaded_file($arquivo["tmp_name"], $nomeArquivo);
//            }
            move_uploaded_file($arquivo1["tmp_name"], $nomeArquivo1);
            move_uploaded_file($arquivo2["tmp_name"], $nomeArquivo2);
            move_uploaded_file($arquivo3["tmp_name"], $nomeArquivo3);
            
        }else{
            $des_archive_client = 0;
        }  
        
        
        $results = $sql->select("
                CALL sp_registerCNPJ_update(
                    :idclient, :des_situation, :des_plataform_name, :nrcpf_cnpj, :des_main_activity, :des_company_situation, 
                    :des_fantasy_name, :desname, :des_rg_ie, :dessex, :des_marital_status, :nr_cnh, :dt_of_birth,
                    :des_email, :nr_telephone, :nr_cell_phone, :des_cep, :des_address, :des_number, :des_neighborhood, 
                    :des_city, :des_complement, :des_state,  :des_country, :des_cod_ibge_uf, :des_cod_ibge_municipio,
                    :des_latitude, :des_longitude, :des_name_person1, :des_kinship_person1, :des_phone_kinship_person1,
                    :des_cellphone_kinship_person1, :des_name_person2, :des_kinship_person2, :des_phone_kinship_person2,
                    :des_cellphone_kinship_person2, :des_payment, :des_grouped, :des_plan, :des_archive_client, :des_obs_client
            )", array(
                ":idclient"=>$idclient,
                ":des_situation"=>$this->getdes_situation(),
                ":des_plataform_name"=>$this->getdes_plataform_name(),
                ":nrcpf_cnpj"=>removeMaskCPF($this->getnrcpf_cnpj()),
                ":des_main_activity"=>$this->getdes_main_activity(),
                ":des_company_situation"=>$this->getdes_company_situation(),
                ":des_fantasy_name"=>$this->getdes_fantasy_name(),
                ":desname"=>$this->getdesname(),                
                ":des_rg_ie"=>$this->getdes_rg_ie(),
                ":dessex"=>$this->getdessex(),
                ":des_marital_status"=>$this->getdes_marital_status(),
                ":nr_cnh"=>$this->getnr_cnh(),
                ":dt_of_birth"=>$this->getdt_of_birth(),
                ":des_email"=>$this->getdes_email(),
                ":nr_telephone"=>removeMaskTel($this->getnr_telephone()),
                ":nr_cell_phone"=>removeMaskCel($this->getnr_cell_phone()),
                ":des_cep"=>removeMaskCEP($this->getdes_cep()),
                ":des_address"=>$this->getdes_address(),
                ":des_number"=>$this->getdes_number(),
                ":des_neighborhood"=>$this->getdes_neighborhood(),
                ":des_city"=>$this->getdes_city(),
                ":des_complement"=>$this->getdes_complement(),
                ":des_state"=>$this->getdes_state(),
                ":des_country"=>$this->getdes_country(),
                ":des_cod_ibge_uf"=>$this->getdes_cod_ibge_uf(),
                ":des_cod_ibge_municipio"=>$this->getdes_cod_ibge_municipio(),
                ":des_latitude"=>$this->getdes_latitude(),
                ":des_longitude"=>$this->getdes_longitude(),
                ":des_name_person1"=>$this->getdes_name_person1(),
                ":des_kinship_person1"=>$this->getdes_kinship_person1(),
                ":des_phone_kinship_person1"=>removeMaskTel($this->getdes_phone_kinship_person1()),
                ":des_cellphone_kinship_person1"=>removeMaskCel($this->getdes_cellphone_kinship_person1()),
                ":des_name_person2"=>$this->getdes_name_person2(),
                ":des_kinship_person2"=>$this->getdes_kinship_person2(),
                ":des_phone_kinship_person2"=>removeMaskTel($this->getdes_phone_kinship_person2()),
                ":des_cellphone_kinship_person2"=>removeMaskCel($this->getdes_cellphone_kinship_person2()),
                ":des_payment"=>convertArrayString($this->getdes_payment()),//explode("," , $this->getdes_payment())
                ":des_grouped"=>$this->getdes_grouped(),
                ":des_plan"=>$this->getdes_plan(),
                ":des_archive_client"=>$des_archive_client,
                ":des_obs_client"=>$this->getdes_obs_client()
            )
                //:idclient,
                //":idclient"=>$this->getidclient(),
        );
//        var_dump($results);
//        exit;
        if(!$results > 0){
            Clients_bgt::setError("Erro ao Atualizar os dados.");
        }else{
            Clients_bgt::setSuccess("Cliente Atualizado com Sucesso.");
            $this->setData($results);
        }
        
    }
    
    public static function search($search) {
        $sql = new Sql();

        return $sql->select("SELECT * FROM tb_clients c INNER JOIN tb_persons p ON c.idperson = p.idperson WHERE p.desname LIKE :SEARCH or 
                            p.nrcpf_cnpj LIKE :SEARCH ORDER BY c.idclient"
        , array(
            ':SEARCH'=>"%" . $search . "%"
        ));
    }
    
    public function delete($idclient){
        
        $sql = new Sql();
        
        $sql->query("CALL sp_clients_delete(:idclient)", array(
            ":idclient"=>$idclient
        ));
        
    }
    
    public static function getQtdClients()
    {
        
        $sql = new Sql();
        
        $results = $sql->select("
                    SELECT SQL_CALC_FOUND_ROWS *
                    FROM tb_clients c 
                    INNER JOIN tb_persons p USING(idperson) 
        ");
        
        $resultsTotal = $sql->select("SELECT FOUND_ROWS() AS regtotal;");
        
        return [
            'data'=>$results,
            'total'=>(int)$resultsTotal[0]["regtotal"]
        ];
        
    }
    
    public static function getPage($page = 1, $itemsPerPage = 15){
        
        $start = ($page - 1) * $itemsPerPage;
        
        $sql = new Sql();
        
        $results = $sql->select("
                    SELECT SQL_CALC_FOUND_ROWS *
                    FROM tb_clients c 
                    INNER JOIN tb_persons p USING(idperson) 
                    ORDER BY c.idclient DESC
                    LIMIT $start, $itemsPerPage;
        ");
        
        $resultsTotal = $sql->select("SELECT FOUND_ROWS() AS regtotal;");
        
        return [
            'data'=>$results,
            'total'=>(int)$resultsTotal[0]["regtotal"],
            'pages'=>ceil( $resultsTotal[0]["regtotal"] / $itemsPerPage )
        ];
    }
    
    public static function getPageSearch($search, $page = 1, $itemsPerPage = 10){
        
        $start = ($page - 1) * $itemsPerPage;
        
        $sql = new Sql();
        
        $results = $sql->select("
                    SELECT SQL_CALC_FOUND_ROWS *
                    FROM tb_clients c 
                    INNER JOIN tb_persons p USING(idperson) 
                    WHERE p.desname LIKE :search OR p.nrcpf_cnpj LIKE :search
                    ORDER BY c.idclient DESC
                    LIMIT $start, $itemsPerPage;
        ", [
            ':search'=>'%'.$search.'%'
        ]);
        
        $resultsTotal = $sql->select("SELECT FOUND_ROWS() AS regtotal;");
        
        return [
            'data'=>$results,
            'total'=>(int)$resultsTotal[0]["regtotal"],
            'pages'=>ceil( $resultsTotal[0]["regtotal"] / $itemsPerPage )
        ];
    }
    // verifica no BD se o CPF OU CNPJ já foi inserido anteriormente
    public static function verifyCPF_CNPJinDB($cpf_cnpj)
    {
        $sql = new Sql();
        
        $results = $sql->select("
            SELECT count(1) FROM tb_persons p inner join tb_clients c 
            on c.idperson = p.idperson 
            WHERE p.nrcpf_cnpj = $cpf_cnpj;
        ");
        
//        select c.idclient, p.nrcpf_cnpj from tb_persons p inner join tb_clients c 
//            on c.idperson = p.idperson 
//            WHERE p.nrcpf_cnpj = $cpf_cnpj;
        
        return $results;
    }
    public static function setError($msg){
        
        $_SESSION[Clients_bgt::ERROR] = $msg;
        
    }
    
    public static function getError(){
        
        $msg = (isset($_SESSION[Clients_bgt::ERROR]) && $_SESSION[Clients_bgt::ERROR]) ? $_SESSION[Clients_bgt::ERROR] : '';
        
        Clients_bgt::clearError();
        
        return $msg;
        
    }
    
    public static function clearError(){
        
        $_SESSION[Clients_bgt::ERROR] = NULL;
        
    }
    
    public static function setSuccess($msg){
        
        $_SESSION[Clients_bgt::SUCCESS] = $msg;
        
    }
    
    public static function getSuccess(){
        
        $msg = (isset($_SESSION[Clients_bgt::SUCCESS]) && $_SESSION[Clients_bgt::SUCCESS]) ? $_SESSION[Clients_bgt::SUCCESS] : '';
        
        Clients_bgt::clearSuccess();
        
        return $msg;
        
    }
    
    public static function clearSuccess(){
        
        $_SESSION[Clients_bgt::SUCCESS] = NULL;
        
    }
    
}

