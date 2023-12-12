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
        <input type="text" id="moduleSearch" style="width:25%" placeholder="Search..." oninput="filterModules()">
    </div>
</header>

<?php

$modules = [
    'Get to Know Your Way Around Campus' => [
        'visibility' => false,
        'content' => '<h2>Welcome to Campus!</h2>
                    <a href="UWW Interactive map/web/index.html">Interactive Map</a><br>
                    <a href="https://www.uww.edu/adminaffairs/parking-regulations" target="_blank">Parking Information</a><br>
                    <a href="https://www.bird.co/#ride-on" target="_blank">Use Birds to get around Whitewater!</a>'],
    'Helpful Academic Resources' => [
        'visibility' => false,
        'content' => '<h2>Helpful Academic Resources</h2>
                      <a href="https://www.uww.edu/academics/departments-and-majors" target="_blank">List of Programs</a><br>
                      <a href="https://www.uww.edu/library" target="_blank">Checkout our Libraries</a><br>
                      <a href="tutor.php">Connect with a Tutor</a><br>
                      <a href="https://www.ratemyprofessors.com/school/1604" target="_blank">Rate/Review our Professors</a><br>
                      <a href="https://www.uww.edu/documents/registrar/Calendars/2023-2024/2023-2024%20CALENDAR-Adjusted%20Final%20Update.pdf" target="_blank">Academic Calendar</a><br>
                      <a href="https://www.uww.edu/documents/registrar/Schedule%20of%20Classes/UPDATED%20Final%20Exams%20-%20Master%20Grid%20Exam%20Schedule.pdf" target="_blank">Final Exam Schedule</a>'],
    'Campus Life Resources' => [
        'visibility' => false,
        'content' => '<h2>Campus Life Resources</h2>
                    <a href="diningInfoPage.php">Dining Hours</a><br>
                    <a href="fitnessHours.php">Fitness Hours</a><br>
                    <a href="https://www.uww.edu/housing/services/laundry" target="_blank">On-Campus Laundry<br>
                    <a href="https://www.uww.edu/uc/dining-services" target="_blank">Dining Services</a><br>
                    <a href="https://www.uww.edu/rec-sports" target="_blank">Recreation Sports & Facilities</a>'],
    'Student Directory' => [
        'visibility' => false,
        'content' => '<h2>Student Directory</h2>
                    <a href="https://myapps.uww.edu" target="_blank">Click here to access all UWW Apps!</a>'],
    'Get Involved' => [
        'visibility' => false,
        'content' => '<h2>Get Involved at UWW!</h2><a href="submitAnEvent.php">Submit an Event Here!</a><br>
                        <a href="https://www.uww.edu/documents/Rec%20Sports/Weekly%20Activity%20Schedules/2023-2024/AthleticEventsCalendar%202023-24.pdf" target="_blank">Athletic Events</a>'],
    'Need Technical Help?' => [
        'visibility' => false,
        'content' => '<h2>Having Technical Issues?</h2>
                       <a href="https://www.uww.edu/housing/services/technology/resnet" target="_blank">ResNET</a><br>
                        <a href="https://www.uww.edu/documents/colleges/cobe/2015%20docs/resource%20guide%20fall%202015%2009.11.15.pdf" target="_blank">CoBE Tech Resource Guide</a>'],
    'Graduation Resources' => [
        'visibility' => false,
        'content' => '<h2>Graduating Soon?</h2>
                    <a href="https://www.uww.edu/registrar/graduation" target="_blank">Graduation Services</a>'],
    'Career Resources' => [
        'visibility' => false,
        'content' => '<h2>Career Resources</h2>
                    <a href="https://www.uww.edu/career" target="_blank">Career Services</a><br>']
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
            echo "<div class='styled-module'><div class='a-modules a'>" . $module['content'] . "</div><br></div>";
        }
    }
    ?>
</div>
<script>
    function filterModules() {
        var input, filter, modules, module, links, link, i, j, txtValue;
        input = document.getElementById("moduleSearch");
        filter = input.value.toUpperCase();
        modules = document.getElementsByClassName("styled-module");

        for (i = 0; i < modules.length; i++) {
            module = modules[i];
            links = module.getElementsByTagName("a");
            var moduleMatchesFilter = false;

            for (j = 0; j < links.length; j++) {
                link = links[j];
                txtValue = link.textContent || link.innerText;

                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    moduleMatchesFilter = true;
                    break;
                }
            }
            if (moduleMatchesFilter) {
                module.style.display = "";
            } else {
                module.style.display = "none";
            }
        }
    }
</script>

</body>
