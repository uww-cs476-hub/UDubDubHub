<?php

$user = 'root';
$pass = ''; 
$dsn='mysql:host=localhost;dbname=uwwdb';
try {
    $db = new PDO($dsn, $user, $pass);

} catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
}



?>