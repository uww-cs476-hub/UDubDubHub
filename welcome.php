<?php
session_start();

if (!isset($_SESSION["username"])) {
    header("Location: index.php");
}

echo "Welcome, " . $_SESSION["username"] . "!";

echo "<br><a href='logout.php'>Logout</a>";
?>