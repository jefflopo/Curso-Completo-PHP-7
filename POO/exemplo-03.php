<?php
    class Documento {
        
        private $numero;
        
        public function getNumero() {
            return $this->numero;
        }
        
        public function setNumero( $numero ) {
            
            $resultado = Documento::validarCPF( $numero );
            
            if( $resultado === false ){
                throw new Exception("CPF informado não é válido!", 1);
            }
            
            $this->numero = $numero;
            
        }
        
        public static function validarCPF( $cpf ):bool {
            
            // verifica se o cpf foi informado
            if( empty( $cpf ) ) return false;
            
            // elimina possivel mascara
            $cpf = preg_replace('[^0-9]', '', $cpf);
            $cpf = str_pad($cpf, 11, '0', STR_PAD_LEFT);
            
            // verifica se o numero de digitos informados é igual a 11
            if(strlen($cpf) != 11 ) {
                return false;
            }
            
            // verifica se nenhuma das sequencias invalidas abaixo
            // foi digitada. Caso afirmativo, retorna falso
            else if ( $cpf == '00000000000' ||  
                    $cpf == '11111111111' || 
                    $cpf == '22222222222' || 
                    $cpf == '33333333333' || 
                    $cpf == '44444444444' ||
                    $cpf == '55555555555' ||
                    $cpf == '66666666666' ||
                    $cpf == '77777777777' ||
                    $cpf == '88888888888' || 
                    $cpf == '99999999999') {
                return false;
                
         // Calcula os digitos verificadores para verificar se o CPF é valido!
            
        } else {
            
            for( $t = 9; $t < 11; $t++ ) {
                
                for( $d = 0, $c = 0; $c < $t; $c++) {
                    $d += $cpf{$c} *( ($t + 1) - $c );
                }
                
                $d = ( (10 * $d) %11 ) % 10;
                
                if( $cpf{$c} != $d ){
                    return false;
                }
                
            }
            
            return true;
            
        }
            
        }
        
    }
    
//    $cpf = new Documento();
//    
//    $cpf->setNumero("11555447889");
//    
//    var_dump($cpf->getNumero());
    
var_dump( Documento::validarCPF("02088574190") );

