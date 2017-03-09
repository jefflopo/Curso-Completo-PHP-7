<?php
    $conn = new PDO("mysql:dbname=db_php7;host=localhost", "root", "");
    //dbname é o nome do banco de dados e nao da conexao!! CUIDADO!!!!!!
    
    $stmt = $conn->prepare("SELECT * FROM tb_usuarios ORDER BY deslogin");
    $stmt->execute();
    $results = $stmt->fetchAll( PDO::FETCH_ASSOC );
    
    foreach ( $results as $row ) {
        foreach ( $row as $key => $value ) {
            echo "<strong>" . $key . ":</strong>" . $value . "<br/>";
        }
        
        echo "====================================================<br/>";
    }
    
?>

