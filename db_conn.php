<?php

$user = 'root';
$pass = ''; 
$dsn='mysql:host=localhost; dbname=udubdubhub';
try {

    $db = new PDO($dsn, $user, $pass);

} catch (PDOException $e) {
    echo "Error!: " . $e->getMessage() . "<br>";
    die();
}

?>