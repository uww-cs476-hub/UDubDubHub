<?php
session_start();
$title = "Dining Hall Notification";
include "header.php";
?>
<div class="styled-container">
    <div class="a-modules a" style="margin-right: 95%;"><a href="modules.php">← Dashboard</a></div>
    <img src="Whitewater Logos/UW-Whitewater_logo_blk_lead_hortizontal.png" style="width: 25%">
    <h3>Dining Hall Alert</h3>
    <h2>If there is a change to a dining locations hours, menus, etc. let your fellow students know here.</h2>
</div>

<form id="diningHallNotificationForm">
    <label for="diningHallNotificationText">Enter Notification:</label>
    <br>
    <input type="text" id="diningHallNotificationText" name="diningHallNotificationText" required>
    <br>
    <label for="notificationHours">Enter the duration the notification should be in effect for (in hours):</label>
    <br>
    <input type="number" id="notificationHours" name="notificationHours" required>
    <br>
    <input type="submit" style="margin: 0% 0%" value="Submit" >
</form>

<?php
include "footer.html";
?>