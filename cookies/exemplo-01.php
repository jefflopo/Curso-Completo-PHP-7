<?php
    $data = array(
        "empresa"=>"HCode Treinamentos"
    );

    setcookie("NOME_DO_COOKIE", json_encode($data), time() + 3600);

    echo "Cookie criado com sucesso!!";

