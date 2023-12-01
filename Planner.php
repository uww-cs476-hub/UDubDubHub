<?php
session_start();

include "db_conn.php";

if (!$db) {
    echo "Could not connect to database!";
    exit();
}

if (isset($_SESSION["netID"]) && isset($_POST["add-event"])) {
    $title = $_POST["event-name"];
    $day = $_POST["day-select"];
    $time = $_POST["time-input"];
    $netID = $_SESSION["netID"];

    $sql = "INSERT INTO `reminder` (`title`, `day`, `time`, `netID`)
            VALUES (:title, :day, :time, :netID);";
    $parameters = [
        ":title" => $title,
        ":day" => $day,
        ":time" => $time,
        ":netID" => $netID
    ];

    $stm = $db->prepare($sql);
    $stm->execute($parameters);
}

$reminderSet = null;
$noteSet = null;

if (isset($_SESSION["netID"])) {
    $sql = "SELECT `title`, `day`, `time` FROM `reminder` WHERE `netID` = :netID;";
    $parameters = [":netID" => $_SESSION["netID"]];

    $stm = $db->prepare($sql);
    $stm->execute($parameters);
    $reminderSet = $stm->fetchAll(PDO::FETCH_ASSOC);

    $sql = "SELECT `title`, `details`, `creationTime`, `updateTime` FROM `note` WHERE `netID` = :netID;";
    
    $stm = $db->prepare($sql);
    $stm->execute($parameters);
    $noteSet = $stm->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Planner</title>
    <link rel="stylesheet" href="plannerStyles.css">
    <script src="plannerScript.js"></script>
</head>

    <body>
    <!-- Planner Section -->
    <h1>Planner</h1>

    <div>
        <?php
        $days = array("Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday");
        ?>
        <table class='planner'>
            <tr>
            <?php
            foreach ($days as $day) {
                echo '<th class="day">' . $day . '</th>';
            }
            ?>
            </tr>
        </table>
    </div>

    <div class="add-event">
        <h2>Add Event</h2>
        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <label for="event-name">Event Name:</label>
            <input type="text" id="event-name" name="event-name">
            <label for="day-select">Select Day:</label>
            <select id="day-select" name="day-select">
                <?php
                foreach ($days as $day) {
                    echo '<option value="' . $day . '">' . $day . '</option>';
                }
                ?>
            </select>
            <label for="time-input">Time:</label>
            <input type="time" id="time-input" name="time-input">
            <button type="submit" name="add-event">Add Event</button>
        </form>

        <?php
        /*
        if (isset($_POST['add-event'])) {
            $eventName = $_POST['event-name'];
            $selectedDay = $_POST['day-select'];

            if (trim($eventName) !== '') {
                echo '<script>addEvent("' . htmlspecialchars($eventName) . '", "' . htmlspecialchars($selectedDay) . '");</script>';
            } else {
                echo '<script>alert("Please enter an event name.");</script>';
            }
        }
        */
        ?>

        <script>
            //Function to add an Event, does not work yet, maybe implement with DB?
            function addEvent(eventName, selectedDay) {
                const dayElement = document.querySelector('.' + selectedDay);
                const eventElement = document.createElement('div');
                eventElement.className = 'event';
                eventElement.textContent = eventName;

                dayElement.appendChild(eventElement);
            }
        </script>
    </div>

    <!-- Note Taker Section -->

    <br><br>
    <h1>Notes</h1>

    <div>
        <button onclick="createNote()">Create Note</button>
    </div>

    <div class="note-container" id="noteContainer">
        <!-- Notes will be dynamically added here -->
        <?php
            if (count($noteSet) > 0) {
                foreach($noteSet as $note) {
                    $title = $note["title"];
                    $details = $note["details"];
                    $creationTime = $note["creationTime"];
                    $updateTime = $note["updateTime"];
                    ?>
                    <script>
                        createNote("<?php echo $title; ?>", "<?php echo $details; ?>", "<?php echo $creationTime; ?>", "<?php echo $updateTime; ?>");
                    </script>
                    <?php
                }
            }
        ?>
    </div>
    </body>
</html>