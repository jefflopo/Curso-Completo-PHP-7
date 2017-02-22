<?php
    class Pessoa {
        
        public $nome;
        
        public function falar(){
            
            return "O meu nome é " . $this->nome ;
            
        }
        
    }
    
    $jeff = new Pessoa();
    $jeff->nome = "Jefferson Moreira";
    echo $jeff->falar();

