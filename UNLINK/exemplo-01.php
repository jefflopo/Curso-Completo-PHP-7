<?php
    $file = fopen("teste.txt","w+");
    
    fclose($file);
    
    unlink("texte.txt");
    
    echo "Arquivo removido com sucesso!!!!";

