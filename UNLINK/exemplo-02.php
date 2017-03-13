<?php
    if(!is_dir("images")) {
        mkdir("images");
    }
    
    foreach (scandir("images") as $item) {
        if(!in_array($item, array(".", ".."))){
            unlink("images/" .$item);
        }
    }
    
    echo "Imagens removidas com sucesso!!";
        

