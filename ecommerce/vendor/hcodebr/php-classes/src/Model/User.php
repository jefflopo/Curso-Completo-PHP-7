<?php

namespace Hcode\Model;

use \Hcode\DB\Sql;
use \Hcode\Model;

class User extends Model {
    
    const SESSION = "User";
    const SECRET = "HcodePhp7_Secret";
    
    public static function login($login, $password){
        
        $sql = new Sql();
        
        $results = $sql->select("SELECT * FROM tb_users WHERE deslogin = :LOGIN", array(
            ":LOGIN"=>$login
        ));
        
        if(count($results) === 0){
            throw new \Exception("Usuário inexistente ou senha inválida!!");
        }
        
        $data = $results[0];
        
        if(password_verify($password, $data["despassword"]) === true){
            $user = new User();
            
            $user->setData( $data );
            
            $_SESSION[User::SESSION] = $user->getValues();
                    
            return $user;
        } else{
            throw new \Exception("Usuário inexistente ou senha inválida!!");
        }
        
    }
    
    public static function verifyLogin($inadmin = true){
        
        if( 
                !isset($_SESSION[User::SESSION]) || 
                !$_SESSION[User::SESSION] ||
                !(int)$_SESSION[User::SESSION]["iduser"] > 0 ||
                (bool)$_SESSION[User::SESSION]["inadmin"] !== $inadmin
        ){
            header("Location: ../ecommerce/admin/login");
            exit;
        }
        
    }
    
    public static function logout(){
        
        $_SESSION[User::SESSION] = NULL;
        
    }
    
    public static function listAll(){
        
        $sql = new Sql();
        
        return $sql->select("SELECT * FROM tb_users a INNER JOIN tb_persons b USING(idperson) ORDER BY b.desperson");
        
    }
    
    public function save(){
        
        $sql = new Sql();
        
        $results = $sql->select("CALL sp_users_save(:desperson, :deslogin, :despassword, :desemail, :nrphone, :inadmin)",array(
                            ":desperson"=>$this->getdesperson(),
                            ":deslogin"=>$this->getdeslogin(),
                            ":despassword"=>$this->getdespassword(),
                            ":desemail"=>$this->getdesemail(),
                            ":nrphone"=>$this->getnrphone(),
                            ":inadmin"=>$this->getinadmin()
        ));
        
        $this->setData($results[0]);
        
    }
    
    public function get($iduser) {
        
        $sql = new Sql();
        
        $results = $sql->select("SELECT * FROM tb_users a INNER JOIN tb_persons b USING(idperson) WHERE a.iduser = :iduser", array(
            ":iduser"=>$iduser
        ));
        
        $this->setData($results[0]);
        
    }
    
    public function update() {
        
        $sql = new Sql();
        
        $results = $sql->select("CALL sp_usersupdate_save(:iduser, :desperson, :deslogin, :despassword, :desemail, :nrphone, :inadmin)",array(
                            ":iduser"=> $this->getiduser(),
                            ":desperson"=>$this->getdesperson(),
                            ":deslogin"=>$this->getdeslogin(),
                            ":despassword"=>$this->getdespassword(),
                            ":desemail"=>$this->getdesemail(),
                            ":nrphone"=>$this->getnrphone(),
                            ":inadmin"=>$this->getinadmin()
        ));
        
        $this->setData($results[0]);
        
    }
    
    public function delete(){
        
        $sql = new Sql();
        
        $sql->query("CALL sp_users_delete(:iduser)", array(
            ":iduser"=> $this->getiduser()
        ));
        
    }
    
    public static function getForgot($email){
        
        $sql = new Sql();
        
        $results = $sql->select("
            SELECT * 
            FROM tb_persons a
            INNER JOIN tb_users b USING(idperson)
            WHERE desemail = :email;", 
            array(
                ":email"=>$email
            ));
        
        if(count($results) === 0 ){
            throw new \Exception("Não foi possível recuperar a senha.", 1);
        }else{
            
            $data = $results[0];
            
            $results2 = $sql->select("CALL sp_userspasswordsrecoveries_create(:iduser, :desip)", array(
                ":iduser"=>$data["iduser"],
                ":desip"=>$_SERVER["REMOTE_ADDR"]
            ));
            
            if(count($results2) === 0){
                throw new \Exception("Não foi possível recuperar senha.");
            }else{
                $dataRecovery = $results2[0];
                
                $code = base64_encode( mcrypt_encrypt(MCRYPT_RIJNDAEL_128, User::SECRET, $dataRecovery["idrecovery"], MCRYPT_MODE_ECB) );
                
                $link = "http://localhost:8080/CursoCompletoPHP7/ecommerce/admin/forgot/reset?code=$code";
                
                $mailer = new Mailer($data["desemail"], $data["desperson"], "Redefinir Senha do Curso Completo PHP7", "forgot", array(
                    "name"=>$data["desperson"],
                    "link"=>$link
                ));
                
                $mailer->send();
                
                return $data;
            }
        }
        
        
    }
    
}

