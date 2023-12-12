<?php
session_start();

if (!isset($_SESSION["netID"])) {
    header("Location: login.php");
}

$title = "Event Form";
include "header.php";
?>
<div class="styled-container">
    <div class='a-modules a' style='margin-right: 95%'><a href='modules.php'>← Dashboard</a></div>
    <img src="Whitewater Logos/UW-Whitewater_logo_blk_lead_hortizontal.png" style="width:25%">
    <h1>UWW Event Form</h1>
    <h3>Have an event you would like to share with your peers? Submit your event here and we will notify our fellow UDubDubHub users.</h3>
</div>
<form action="index.php?mode=submitEvent" method="post">
    <table class="table">
        <tr>
            <td>Event Name:</td>
        </tr>
        <tr>
            <td><input type='text' id="eventName" name="eventName" required/></td>
        </tr>
        <tr>
            <td>Start Time:</td>
        </tr>
        <tr>
            <td><input type='datetime-local' id="startTime" name="startTime" required/></td>
        </tr>
        <tr>
            <td>End Time:</td>
        </tr>
        <tr>
            <td><input type='datetime-local' id="endTime" name="endTime" required/></td>
        </tr>
        <tr>
            <td>Location of Event:</td>
        </tr>
        <tr>
            <td><input type='text' id="eventLocation" name="eventLocation" required /></td>
        </tr>
        <tr>
            <td>Description of Event:</td>
        </tr>
        <tr>
            <td><textarea id="description" name="description" rows="4" cols="100"></textarea></td>
        </tr>
    </table>
    <input type="submit" value="Submit">
</form>

<?php
    include "footer.html";
?>