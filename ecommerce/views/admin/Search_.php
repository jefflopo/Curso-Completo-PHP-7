<?php

define('DB_SERVER', '127.0.0.1');
define('DB_USER', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'db_biggestao');

if (isset($_GET['clients-input'])) 
{
    $desnames = array();

    try {

        $conn = new PDO("mysql:host=" . DB_SERVER . ";port=3306;dbname=" . DB_NAME, DB_USER, DB_PASSWORD);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare('SELECT desname FROM tb_clients c INNER JOIN tb_persons p WHERE desname LIKE :term');
        $stmt->execute(array('term' => '%' . $_GET['clients-input'] . '%'));

        while ($row = $stmt->fetch()) {
            $desnames[] = $row['desname'];
        }
    } catch (PDOException $ex) {
        echo 'Error: ' . $ex->getMessage();
    }

    echo json_encode($desnames);

//    $sql = new Sql();
//    $query = "SELECT desname FROM tb_clients c INNER JOIN tb_persons p WHERE desname LIKE " . $_GET['clients-input'];
//
//    $desnames = $sql->searchAutocompleteNames($query);
    //    $desnames = $sql->select($query, array(
    //        ':clients-input'=>$_GET['clients-input']
    //    ));
}

