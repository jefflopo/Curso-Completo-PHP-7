<?php
    function soma(float ...$valores):float {
        
        return array_sum($valores);
        
    }
    
    echo var_dump(soma(2,2));
    echo "<br/>";
    echo soma(25,37);
    echo "<br/>";
    echo soma(2.4,1.5);
    echo "<br/>";