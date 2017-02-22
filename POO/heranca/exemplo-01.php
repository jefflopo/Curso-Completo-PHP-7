<?php
    class Documento {
        private $numero;
        
        public function getNumero() {
            return $this->numero;
        }
        
        public function setNumero( $num ) {
            $this->numero = $num;
        }
    }
    
    class CPF extends Documento {
        
        public function validar() : bool {
            // aqui vem a validacao do CPF
            $numeroCPF = $this->getNumero();
            
            return true;
        }
        
    }
    
    $doc = new CPF();
    
    $doc->setNumero("11123356-44");
    var_dump( $doc->validar() );
    echo "<br>";
    echo $doc->getNumero();

