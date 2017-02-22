<?php
    session_id('rk67ds3s7rh36puj2qjjc0m5kk');

    require_once ("config.php");
    
    session_regenerate_id();
    
    echo session_id();
    
    var_dump($_SESSION);
