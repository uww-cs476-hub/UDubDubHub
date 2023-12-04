<!DOCTYPE html>
<html lang="en">
    <head>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>UW-Whitewater Scheduler</title>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
</head>
    <body>
        <div class='container-fluid'>

        <?php // UW-Whitewater Schedule Planner - By Martin.D.Amundsen;

        include("pdo_connect.php"); //To connect to uwwdb

        if (!$db) {
            echo "Could not connect to the database";
            exit();
        }
        ?>
        <style>
            .menu-link > a { color: #fff; font-weight: 500; padding-left: 20px; }
            .menu-bar { background-color: maroon;}
        </style>
        <div class="row">
            <h3 style="text-align: center;">UW-Whitewater Semester Planner</h3>
            <div class="col-sm-12">
                <img src="logo.jpg" alt="UWW" height="200px">
            </div>
            <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #6c757d;">
                <div class="collapse navbar-collapse" id="navbarText">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item active">
                            <a class="nav-link" href="index.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="index.php?mode=schedules">Schedule of Classes</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="index.php?mode=schedules&filter=COMPSCI">COMPSCI Classes</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="index.php?mode=schedules&filter=MATH">MATH Classes</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link"  href="index.php?mode=schedules&filter=MAGD">MAGD Classes</a> 
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link" href="index.php?mode=schedules&filter=CORE">CORE Classes</a>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link" href="index.php?mode=planner">Schedule Planner</a>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>

   
        <?php

        $mode = "";
        $parameterValues = null;
        $pageTitle = "";
        $columns = array();
        
        try {
            if (isset($_GET['mode'])) {
                $mode = $_GET['mode'];
            }
            
            switch ($mode) {
                case "schedules": // Shows the various schedules depending on what filter, or lack there of, is applied

                    if (isset($_GET['filter'])) {
                        $filter = $_GET['filter'];
                        $sql = "SELECT `subject`, `number`, `section`, `days`, `time`, `credits`, `instructor`, `location`, `id` 
                        FROM `schedules` WHERE `subject` = :filter ORDER BY `subject`, `number`";
                        
                        $parameterValues = array(":filter" => $filter);
                        
                        $pageTitle = "Schedule of {$filter} Classes";
                        
                    } else {
                        $sql = "SELECT `subject`, `number`, `section`, `days`, `time`, `credits`, `instructor`, `location`, `id`
                        FROM `schedules` ORDER BY `subject`, `number`";
                        $pageTitle = "Schedule of Classes";
                    }

                    $resultSet = getAll($sql, $db, $parameterValues);
                    
                    $columns = array("Course", "Section", "Time", "Credits", "Instructor", "Location", "Action");
                    displayResultSet($pageTitle, $resultSet, $columns);
                    break;

                case 'add': // adds sections to semesterplan database

                    $plan;
                    if (isset($_GET['sched'])){
                        $plan = $_GET['sched'];
                        $sql = "ALTER TABLE `semesterplan`AUTO_INCREMENT = 1; INSERT INTO `semesterplan`(`scheduleid`) VALUES ($plan)";
                        $statement = $db->prepare($sql);
                        $statement->execute($parameterValues);
                        echo "<h3>Successfully Added Section to Semester Plan</h3>";
                    } else {
                        echo "Was Unable to Add Schedule to Planner, please try again later";
                        die();
                    }
                    break;

                case 'planner': // displays whichever sections are also within the semesterplan database

                    
                        $sql = "SELECT `subject`, `number`, `section`, `days`, `time`, `credits`, `instructor`, `location`, `schedules`.`id`, `scheduleid` 
                        FROM `schedules`, `semesterplan` WHERE `schedules`.`id` = `semesterplan`.`scheduleid`";
                        $pageTitle = "Semester Plan";

                        $resultSet = getAll($sql, $db, $parameterValues);

                        if (!$resultSet) {
                            echo $pageTitle;
                            echo "<h3>Your Semester Plan is Empty</h3>";
                        } else {
                        $columns = array("Course", "Section", "Time", "Credits", "Instructor", "Location", "Action");
                        displayPlanner($pageTitle, $resultSet, $columns);
                        }
                    break;

                case 'deleteplan': // deletes section from semester planner

                    $delete;
                    if(isset($_POST['id'])){
                        $delete = $_POST['id'];
                        $sql = "DELETE FROM `semesterplan` where `scheduleid` = $delete";
                        $statement = $db->prepare($sql);
                        $statement->execute($parameterValues);
                        echo "<h3>Successfully Deleted Section from Semester Plan</h3>";
                    } else {
                        echo "Was Unable to Delete Schedule from Planner, please try again later";
                        die();
                    }

                    break;
                
                default: 
                    echo "<h3>Welcome to UWW Semester Planner<h3>";
                    echo "<div class='col-sm-12'><img src='campus.jpg' alt='UWW' height='500px' width='1000px'></div>";
                    break;
            }
                 
        } catch (PDOException $e) {
            echo "Error!: ". $e->getMessage() . "<br/>";
            die();
        }

?>

        </div>
    </body>
</html>

<?php
function displayResultSet($pageTitle, $resultSet, $columns) { // Displays rows of classes and assigns links to add classes to schedule planner
            echo $pageTitle;
            echo "<table class='table table-sm'>";

            $numCols = count($columns);
            if ($numCols > 0) {
                echo "<thead><tr>";
                foreach($columns as $c) {
                    echo "<th>{$c}</th>";
                }
                echo "</thead>";
            }
            
            echo "<tbody>";
            foreach($resultSet as $item){
                echo "<tr>";
                    echo "<td>{$item['subject']} {$item['number']}</td>";
                    echo "<td>{$item['section']}</td>";
                    echo "<td>{$item['days']} {$item['time']}</td>";
                    echo "<td>{$item['credits']}</td>";
                    echo "<td>{$item['instructor']}</td>";
                    echo "<td>{$item['location']}</td>";
                    echo "<td><a href=index.php?mode=add&sched={$item['id']}>Add to Semester Plan</a></td>";
                echo "</tr>";
            }
            echo "</tbody></table>";
}

function displayPlanner($pageTitle, $resultSet, $columns) { // Displays classes within the planner and the buttons used to send POST data to delete sections respectively
            $totalCredits = 0;
            echo $pageTitle;
            echo "<table class='table table-sm'>";

            $numCols = count($columns);
            if ($numCols > 0) {
                echo "<thead><tr>";
                foreach($columns as $c) {
                    echo "<th>{$c}</th>";
                }
                echo "</thead>";
            }
            
            echo "<tbody>";
            foreach($resultSet as $item){
                echo "<tr>";
                    echo "<td>{$item['subject']} {$item['number']}</td>";
                    echo "<td>{$item['section']}</td>";
                    echo "<td>{$item['days']} {$item['time']}</td>";
                    echo "<td>{$item['credits']}</td>";
                    echo "<td>{$item['instructor']}</td>";
                    echo "<td>{$item['location']}</td>";
                    echo "<td><form method='post' action='index.php?mode=deleteplan' ><input type='hidden' name='id' value='{$item['id']}' /><button type='submit' class='btn btn-primary' onclick='return confirm('Are you sure you wish to delete this record?')' >Delete</button></form></td>";
                    $totalCredits += $item['credits'];
                echo "</tr>";
            }
            echo "</tbody></table>";
            echo "Total Number of Credits: ".$totalCredits;
}

function getAll($sql, $db, $parameterValues = null){

    $statement = $db->prepare($sql);

    $statement->execute($parameterValues );

    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
    
    return $result;
}

?>