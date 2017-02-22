<?php
    $json = '[{"nome":"Glaucio","idade":25},{"nome":"Jo\u00e3o","idade":54}]';
    
    $dados = json_decode($json, true);
    
    var_dump($dados);

