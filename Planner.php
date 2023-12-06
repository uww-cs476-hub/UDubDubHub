<?php
session_start();
$title = "Planner";
include "db_conn.php";
include "header.php";

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
    <script>
        function createNote(newTitle = null, details = null, creationTime = null, updateTime = null) {
            const noteContainer = document.getElementById('noteContainer');

            const note = document.createElement('div');
            note.className = 'note';

            const title = document.createElement('h2');
            title.contentEditable = true;
            if (newTitle === null) {
                title.innerText = 'New Note';
            }
            else {
                title.innerText = newTitle;
            }
            title.addEventListener('input', updateLastUpdated);

            const content = document.createElement('div');
            content.contentEditable = true;
            if (details === null) {
                content.innerText = 'Write your note here.';
            }
            else {
                content.innerText = details;
            }
            content.addEventListener('input', updateLastUpdated);

            const space = document.createElement('div');
            space.innerText = '\n';

            const lastUpdatedTimestamp = document.createElement('div');
            lastUpdatedTimestamp.className = 'timestamp';
            if (updateTime === null) {
                lastUpdatedTimestamp.innerText = 'Last Updated: ' + getCurrentDateTime();
            }
            else {
                lastUpdatedTimestamp.innerText = 'Last Updated: ' + updateTime;
            }

            const timestamp = document.createElement('div');
            timestamp.className = 'timestamp';
            if (creationTime === null) {
                timestamp.innerText = 'Created: ' + getCurrentDateTime();
            }
            else {
                timestamp.innerText = 'Created: ' + creationTime;
            }

            const deleteButton = document.createElement('span');
            deleteButton.className = 'delete-button';
            deleteButton.innerText = 'Delete';
            deleteButton.onclick = function () {
                note.remove();
            };

            note.appendChild(title);
            note.appendChild(content);
            note.appendChild(space);
            note.appendChild(lastUpdatedTimestamp);
            note.appendChild(timestamp);
            note.appendChild(deleteButton);

            noteContainer.insertBefore(note, noteContainer.children[0]);

            // Function to update when note was last updated
            function updateLastUpdated() {
                lastUpdatedTimestamp.innerText = 'Last Updated: ' + getCurrentDateTime();
            }
        }

        // Function to get the current time
        function getCurrentDateTime() {
            const now = new Date();
            const year = now.getFullYear();
            const month = (now.getMonth() + 1).toString().padStart(2, '0');
            const day = now.getDate().toString().padStart(2, '0');
            const hours = now.getHours().toString().padStart(2, '0');
            const minutes = now.getMinutes().toString().padStart(2, '0');
            const ampm = hours >= 12 ? 'PM' : 'AM';

            return `${month}-${day}-${year} ${format12HourTime(hours, minutes)} ${ampm}`;
        }

        // Function to format 12-hour time
        function format12HourTime(hours, minutes) {
            const hour12 = hours % 12 || 12;
            return `${hour12}:${minutes}`;
        }
    </script>
</head>

<body>
<!-- Planner Section -->
<div class="styled-container"><!--ww images from dr zach oster imported in here-->
    <img src="Whitewater Logos/UW-Whitewater_logo_blk_lead_hortizontal.png" style="width:25%">
    <h2>Planner</h2>
</div>
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
    <table>
    <tr><td><h2>Add Event</h2></td></tr>
    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <div class="event-item">
            <tr><td> <label for="event-name">Event Name:</label></td></tr>
            <tr><td><input type="text" id="event-name" name="event-name"></td></tr>
        </div>
        <div class="event-item">
            <tr><td><label for="day-select">Select Day:</label></td></tr>
            <tr><td> <select id="day-select" name="day-select">
                <?php
                foreach ($days as $day) {
                    echo '<option value="' . $day . '">' . $day . '</option>';
                }
                ?>
            </select></td></tr>
        </div>
        <div class="event-item">
            <tr><td> <label for="time-input">Time:</label></td></tr>
            <tr><td><input type="time" id="time-input" name="time-input" style="width:25%"></td></tr>
        </div>
        <div class="event-item">
            <tr><td><button type="submit" name="add-event">Add Event</button></td></tr>
        </div>
    </form>
    </table>
</div>

<!-- Note Taker Section -->
<table>
        <tr><td><h1>Notes</h1></td></tr>
<div>
    <tr><td><button onclick="createNote()">Create Note</button></td></tr>
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
</table>
</body>
</html>