<?php
session_start();
include "db_conn.php";

$title = "Dashboard";
include 'header.php';

$sql = "SELECT `moduleName` FROM `save` WHERE `netID` = :netID;";
$parameters = [
    ":netID" => $_SESSION["netID"]
];
$stm = $db->prepare($sql);
$stm->execute($parameters);
$checked = $stm->fetchAll();
?>

<body>
<header>
    <div class="styled-container">
        <?php
        echo "<div class='a-modules a' style='float:left'><a href='index.php?mode=logout'>Logout</a></div>";
        ?>
        <br>
        <img src="Whitewater Logos/UW-Whitewater_logo_blk_lead_hortizontal.png" style="width:25%">
        <h1><?php echo "Welcome, " . $_SESSION["firstName"] . "!";?></h1>
        <div class="a-modules a">
        <a href="planner.php">Planner and Notes</a><a href="moduleVisibility.php">Dashboard Settings</a><br>
        </div>
        <input type="text" id="moduleSearch" style="width:50%" placeholder="Search..." oninput="filterModules()">
    </div>
</header>

<?php

$modules = [
    'Get to Know Your Way Around Campus' => [
        'visibility' => false,
        'content' => '<h2>Welcome to Campus!</h2>
                    <a href="UWW Interactive map/web/index.html">Interactive Map</a><br>
                    <a href="https://www.uww.edu/adminaffairs/parking-regulations">Parking Information</a><br>
                    <a href="https://www.bird.co/#ride-on">Use Birds to Zoom Around Town!</a>'],
    'Helpful Academic Resources' => [
        'visibility' => false,
        'content' => '<h2>Helpful Academic Resources</h2>
                      <a href="https://www.uww.edu/academics/departments-and-majors">List of Programs</a><br>
                      <a href="https://www.uww.edu/library">Checkout our Libraries</a><br>
                      <a href="tutor.php">Connect with a Tutor</a><br>
                      <a href="https://www.ratemyprofessors.com/school/1604">Rate/Review our Professors</a>'],
    'Campus Life Resources' => [
        'visibility' => false,
        'content' => '<h2>Campus Life Resources</h2>
                    <a href="diningInfoPage.php">Dining Halls</a><br>
                    <a href="diningHallAlerts.php">Submit a Dining Hall Alert</a><br>
                    <a href="https://www.uww.edu/rec-sports">Fitness Information</a>'],
    'Student Directory' => [
        'visibility' => false,
        'content' => '<h2>Student Directory</h2>
                    <a href="https://myapps.uww.edu">Click here to access all UWW Apps!</a>'],
    'Get Involved' => [
        'visibility' => false,
        'content' => '<h2>Get Involved at UWW!</h2><a href="submitAnEvent.php">Submit an Event Here!</a><br>
                        <a href="https://www.uww.edu/documents/Rec%20Sports/Weekly%20Activity%20Schedules/2023-2024/AthleticEventsCalendar%202023-24.pdf">Athletic Events</a>'],
    'Need Technical Help?' => [
        'visibility' => false,
        'content' => '<h2>Having Technical Issues?</h2>
                       <a href="https://www.uww.edu/housing/services/technology/resnet">ResNET</a><br>
                        <a href="https://www.uww.edu/documents/colleges/cobe/2015%20docs/resource%20guide%20fall%202015%2009.11.15.pdf">CoBE Tech for the College of Business and Economics</a>'],
    'Graduation Resources' => [
        'visibility' => false,
        'content' => '<h2>Graduating Soon?</h2>
                    <a href="https://www.uww.edu/career">Career Services</a><br>'],
    'Career Resources' => [
        'visibility' => false,
        'content' => '<h2>Career Resources</h2>
                    <a href="https://www.uww.edu/registrar/graduation">Graduation Services</a>'],
    'Other Resources' => [
        'visibility' => false,
        'content' => '<h2>Other Resources</h2>
                    <a href="https://www.uww.edu/career">Career Services</a><br>
                    <a href="https://www.uww.edu/registrar/graduation">Graduation Services</a>'],
];

foreach ($checked as $module) {
    $moduleName = $module["moduleName"];
    $modules[$moduleName]['visibility'] = true;
}

?>

<div class="module-container">
    <?php
    // Display modules in the form
    foreach ($modules as $moduleName => $module) {
        if ($module['visibility']) {
            echo "<div class='styled-module'><div class='a-modules a'>" . $module['content'] . "</div></div>";
        }
    }
    ?>
</div>
<script>
    function filterModules() {
        var input, filter,  modules,  module, h2, a, i, txtValue;
        input = document.getElementById("moduleSearch");
        filter = input.value.toUpperCase();
        modules = document.getElementsByClassName("styled-module");

        for (i = 0; i <  modules.length; i++) {
            module =  modules[i];
            h2 =  module.getElementsByTagName("h2")[0];
            a =  module.getElementsByTagName("a")[0];
            txtValue = h2.textContent|| h2.innerText|| a.textContent || a.innerText;

            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                 module.style.display = "";
            } else {
                 module.style.display = "none";
            }
        }
    }
</script>

</body>
