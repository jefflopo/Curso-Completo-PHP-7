<?php
    class Endereco {
        
        private $logradouro;
        private $numero;
        private $cidade;
        
        public function __construct( $log, $num, $cid ) {
            
            $this->setLogradouro( $log );
            $this->setNumero( $num );
            $this->setCidade( $cid );
            
        }
        
        public function __destruct() {
            // destruir os métodos da classe
        }

        public function getLogradouro() {
            
            return $this->logradouro;
            
        }
        public function setLogradouro( $logr ){
            if( $logr != "" ){
                $this->logradouro = $logr;
            }
        }
        
        public function setNumero( $n ){
            $this->numero = $n;
        }
        
        public function getNumero() {
            
            return $this->numero;
            
        }
        
        public function setCidade( $cid ){
            $this->cidade = $cid;
        }
        
        public function getCidade() {
            
            return $this->cidade;
            
        }
        
        public function __toString() {
            return "Logradouro: " . $this->getLogradouro() . " Número: " . 
                    $this->getNumero() . " Cidade: " . $this->getCidade();
        }
        
    }
    
    $meuEndereco = new Endereco( "QNF 09 Casa ", "08", "Taguatinga Norte" );
    
    print_r($meuEndereco);

