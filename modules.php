<?php
session_start();
include "db_conn.php";

$title = "Dashboard";
include 'header.php';

if (!isset($_SESSION["netID"])) {
    header("Location: login.php");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sql = "DELETE FROM `save` WHERE `netID` = :netID;";
    $parameters = [
        ":netID" => $_SESSION["netID"]
    ];
    $stm = $db->prepare($sql);
    $stm->execute($parameters);

    if (isset($_POST["modules"])) {
        foreach ($_POST["modules"] as $module) {
            $sql = "INSERT INTO `save` (`moduleName`, `netID`) VALUES (:moduleName, :netID);";
            $parameters = [
                ":moduleName" => $module,
                ":netID" => $_SESSION["netID"]
            ];
            $stm = $db->prepare($sql);
            $stm->execute($parameters);
        }
    }

    header("Location: modules.php");
}

$sql = "SELECT `moduleName` FROM `save` WHERE `netID` = :netID;";
$parameters = [
    ":netID" => $_SESSION["netID"]
];
$stm = $db->prepare($sql);
$stm->execute($parameters);
$checked = $stm->fetchAll();

$modules = [
    'Get to Know Your Way Around Campus' => [
        'visibility' => false,
        'content' => '<h2>Welcome to Campus!</h2>
                    <a href="UWW Interactive map/web/index.html">Interactive Map</a><br>
                    <a href="uniCenterMap.php">University Center Map</a><br>
                    <a href="https://www.uww.edu/adminaffairs/parking-regulations" target="_blank">Parking Information</a><br>
                    <a href="https://www.bird.co/#ride-on" target="_blank">Use Birds to get around Whitewater!</a>'],
    'Student Directory' => [
        'visibility' => false,
        'content' => '<h2>Student Directory</h2>
                    <a href="https://myapps.uww.edu" target="_blank">Access all UWW Academic Apps here</a>'],
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
                    <a href="https://www.uww.edu/uc/dining-services" target="_blank">Dining Services</a><br>
                    <a href="https://www.uww.edu/housing/services/laundry" target="_blank">On-Campus Laundry<br>
                    <a href="fitnessHours.php">Fitness Hours</a><br>
                    <a href="https://www.uww.edu/rec-sports" target="_blank">Recreation Sports & Facilities</a>'],
    'Get Involved' => [
        'visibility' => false,
        'content' => '<h2>Get Involved at UWW!</h2>
                        <a href="submitAnEvent.php">Submit your own Whitewater Event!</a><br>
                        <a href="https://www.uww.edu/uc/get-involved/warhawk-connection-center#events" target="_blank">Warhawk Connection Center</a>
                        <a href="https://www.uww.edu/documents/Rec%20Sports/Weekly%20Activity%20Schedules/2023-2024/AthleticEventsCalendar%202023-24.pdf" target="_blank">Athletic Events</a><br>
                        <a href="https://www.uww.edu/a/97816" target="_blank">Join a Club Sport</a><br>
                        <a href="https://www.uww.edu/rec-sports/intramural-sports" target="_blank">Join an Intramural Sport</a><br>
                        <a href="https://www.uww.edu/uc/get-involved/greek-community" target="_blank">Greek Life Information</a>'],
    'Need Technical Help?' => [
        'visibility' => false,
        'content' => '<h2>Having Technical Issues?</h2>
                       <a href="https://www.uww.edu/housing/services/technology/resnet" target="_blank">ResNET</a><br>
                        <a href="https://www.uww.edu/documents/colleges/cobe/2015%20docs/resource%20guide%20fall%202015%2009.11.15.pdf" target="_blank">CoBE Tech Resource Guide</a><br>
                        <a href="https://www.uww.edu/its/services" target="_blank">Other Technical Services</a>'],
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

<div id="sidebar">
    <a href="planner.php">Planner and Notes</a>

    <div class="dropdown">
        <button class="dropbtn" onclick="toggleVisibility('moduleVisibility')">Dashboard Settings</button>
        <div class="dropdown-content" id="moduleVisibility" style="display: none; color: white;">
            <h4 style="text-align: center;">Update Module Visibility</h4>
            <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <?php
                foreach ($modules as $moduleName => $module) {
                    $checked = $module['visibility'] ? 'checked' : '';
                    ?>
                    <input type="checkbox" name="modules[]" value="<?php echo $moduleName; ?>" <?php echo $checked; ?>>
                    <label><?php echo $moduleName; ?></label>
                    <br>
                    <?php
                }
                ?>
                <br>
                <div style="text-align: center;"><button id="update-visibility" type="submit">Update Visibility</button></div>
            </form>
        </div>
    </div>
    
    <?php
    if (isset($_SESSION['isAdmin']) && $_SESSION['isAdmin']) {
    ?>
        <div class="dropdown">
            <button class="dropbtn" onclick="toggleVisibility('adminSettings')">Admin Settings</button>
            <div class="dropdown-content" id="adminSettings" style="display: none; color: white;">
                <a href="submittedEvents.php" style="font-size: 0.95vw; margin-left: 15px;">Submitted Events</a>
            </div>
        </div>
    <?php
    }
    ?>

    <a href="index.php?mode=logout">Logout</a>
</div>

<div id="content">
    <header>
        <div class="styled-container">
            <?php
            echo "<div id='menu-btn' class='a-modules a'><a href='javascript:void(0)' onclick='toggleSidebar()'>☰ Menu</a></div>";
            ?>
            <br>
            <img src="Whitewater Logos/UW-Whitewater_logo_wht_lead_hortizontal.png" style="width:25%">
            <h1><?php echo "Welcome, " . $_SESSION["firstName"] . "!"; ?></h1>
            <input type="text" id="moduleSearch" style="width:50%" placeholder="Search..." oninput="filterModules()">
        </div>
    </header>

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
    <div id="moduleVisibility" style="display: none;">
        <h2>Update Module Visibility</h2>
        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <?php
            foreach ($modules as $moduleName => $module) {
                $checked = $module['visibility'] ? 'checked' : '';
                ?>
                <input type="checkbox" name="modules[]" value="<?php echo $moduleName; ?>" <?php echo $checked; ?>>
                <label><?php echo $moduleName; ?></label>
                <br>
                <?php
            }
            ?>
            <br>
            <button type="submit">Update Visibility</button>
        </form>
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

    function toggleSidebar() {
        var sidebar = document.getElementById("sidebar");
        sidebar.classList.toggle("active");

        var content = document.getElementById("content");
        content.classList.toggle("active");
    }

    function toggleVisibility(id) {
        var moduleVisibility = document.getElementById(id);
        moduleVisibility.style.display = moduleVisibility.style.display === 'none' ? 'block' : 'none';
    }
</script>
</div>
</body>
