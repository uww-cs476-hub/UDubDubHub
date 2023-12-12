<?php
session_start();

$title = "Campus Maps";
include "header.php";
?>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<link rel="stylesheet" href="styles.css">
<div class="styled-container">
    <div class="a-modules a" style="margin-right: 95%;"><a href="modules.php">← Dashboard</a></div>
    <img src="Whitewater Logos/UW-Whitewater_logo_blk_lead_hortizontal.png" style="width: 25%;">
    <h1>University Center Map</h1>
    <h3>Navigate around the heart of the campus</h3>
</div>
<div class="gallery">
    <div class="image-container">
        <h3>Lower Level</h3>
            <img class="maps-img" src="Campus Maps/lowerLevel.jpg">
    </div>
      <hr>
    <div class="image-container">
        <h3>Main Level</h3>
            <img class="maps-img" src="Campus Maps/mainLevel.jpg">
    </div>
        <hr>
    <div class="image-container">
        <h3>Upper Level</h3>
            <img class="maps-img" src="Campus Maps/upperLevel.jpg">
    </div>
</div>


