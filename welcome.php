<?php

if (!isset($_SESSION["netID"])) {
    header("Location: index.php");
}

echo "Welcome, " . $_SESSION["netID"] . "!";

echo "<br><a href='index.php?mode=logout'>Logout</a>";
?>