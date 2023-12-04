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

<div><a href="Planner.php">View Planner</a></div>

<div><a href="tutor.php">View Tutor Page</a></div>

<div><a href="dining_info_page.html">Dining Hall Information</a></div>

<div><a href="diningHallNotifications.html">Submit a Dining Hall Alert</a></div>

<?php

echo "<br><a href='index.php?mode=logout'>Logout</a>";

include "footer.html";
?>