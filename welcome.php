<?php
session_start();

if (!isset($_SESSION["netID"])) {
    header("Location: index.php");
    exit();
}

include "header.html";

echo "Welcome, " . $_SESSION["netID"] . "!";

echo "<br><a href='index.php?mode=logout'>Logout</a>";

include "footer.html";
?>