<?php
   require_once ("config.php");
   
   echo session_save_path();
   echo "<br/>";
   var_dump(session_status());

