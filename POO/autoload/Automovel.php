<?php
    interface Veiculo {
        
        public function acelerar( $velocMaxima );
        public function frenar( $velocidade );
        public function trocarMarcha( $marcha );
        
    }
    
    abstract class Automovel implements Veiculo {
        
        public function acelerar( $velocMaxima ) {
            echo "O veiculo acelerou até " . $velocMaxima . " km/h";
        }
        
        public function frenar( $velocidade ) {
            echo "O veiculo frenou até " . $velocidade . " km/h";
        }
        
        public function trocarMarcha( $marcha ) {
            echo "O veiculo engatou a marcha " . $marcha;
        }
        
    }

