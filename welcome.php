<?php
session_start();

if (!isset($_SESSION["netID"])) {
    header("Location: index.php");
    exit();
}

$title = "Home";
include "header.php";

echo "Welcome, " . $_SESSION["netID"] . "!";

?>

<div><a href="submitAnEvent.php">Submit Event</a></div>

<div><a href="planner.php">View Planner</a></div>

<?php

echo "<br><a href='index.php?mode=logout'>Logout</a>";

include "footer.html";
?>