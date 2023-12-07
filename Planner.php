<?php
session_start();
$title = "Planner";
include "db_conn.php";
include "header.php";

if (!$db) {
    echo "Could not connect to database!";
    exit();
}

if (!isset($_SESSION["netID"])) {
    header("Location: login.php");
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

    $sql = "SELECT `ID`, `title`, `details`, `creationTime`, `updateTime` FROM `note` WHERE `netID` = :netID;";
    $stm = $db->prepare($sql);
    $stm->execute($parameters);
    $noteSet = $stm->fetchAll(PDO::FETCH_ASSOC);
}
?>
    <script>
        function createNote(ID = null, newTitle = null, details = null, creationTime = null, updateTime = null) {
            const noteContainer = document.getElementById('noteContainer');

            const note = document.createElement('div');
            note.className = 'note';
            if (ID != "" && ID != null) {
                note.id = "note-" + ID;
            }

            const title = document.createElement('h2');
            title.id = "note-title";
            title.contentEditable = true;
            if (newTitle === null) {
                title.innerText = 'New Note';
            }
            else {
                title.innerText = newTitle;
            }
            title.addEventListener('blur', function(e) {
                updateNote(e);
            });

            const content = document.createElement('div');
            content.id = "note-content";
            content.contentEditable = true;
            if (details === null) {
                content.innerText = 'Write your note here.';
            }
            else {
                content.innerText = details;
            }
            content.addEventListener('blur', function(e) {
                updateNote(e);
            });

            const space = document.createElement('div');
            space.innerText = '\n';

            const lastUpdatedTimestamp = document.createElement('div');
            lastUpdatedTimestamp.id = 'update-timestamp'
            lastUpdatedTimestamp.className = 'timestamp';
            var newUpdateTime = null;
            if (updateTime === null) {
                newUpdateTime = getCurrentDateTime();
            }
            else {
                newUpdateTime = updateTime;
            }
            lastUpdatedTimestamp.innerText = 'Last Updated: ' + convertDateTime(newUpdateTime);

            const timestamp = document.createElement('div');
            timestamp.className = 'timestamp';
            var newCreationTime = null;
            if (creationTime === null) {
                newCreationTime = getCurrentDateTime();
            }
            else {
                newCreationTime = creationTime;
            }
            timestamp.innerText = 'Created: ' + convertDateTime(newCreationTime);

            const deleteButton = document.createElement('span');
            deleteButton.className = 'delete-button';
            deleteButton.innerText = 'Delete';
            deleteButton.addEventListener("click", function() {
                deleteNote(note);
            });

            note.appendChild(title);
            note.appendChild(content);
            note.appendChild(space);
            note.appendChild(lastUpdatedTimestamp);
            note.appendChild(timestamp);
            note.appendChild(deleteButton);

            noteContainer.insertBefore(note, noteContainer.children[0]);

            if (ID == null) {
                addNote(title.innerText, content.innerText, newUpdateTime, newCreationTime);
            }

            var noteHeader = document.getElementById("note-table");
            var height = noteHeader.offsetTop;
            window.scrollTo(0, height);
        }

        function getCurrentDateTime() {
            var current = new Date();
            var cDate = current.getFullYear() + '-' + (current.getMonth() + 1).toString().padStart(2, '0') + '-' + current.getDate().toString().padStart(2, '0');
            var cTime = current.getHours().toString().padStart(2, '0') + ":" + current.getMinutes().toString().padStart(2, '0') + ":" + current.getSeconds().toString().padStart(2, '0');
            var dateTime = cDate + ' ' + cTime;
            
            return dateTime;
        }

        function convertDateTime(dateTime) {
            var year = dateTime.substring(0, 4);
            var month = dateTime.substring(5, 7).padStart(2, '0');
            var day = dateTime.substring(8, 10).padStart(2, '0');
            var hours = dateTime.substring(11, 13).padStart(2, '0');
            var minutes = dateTime.substring(14, 16).padStart(2, '0');
            var seconds = dateTime.substring(17, 19).padStart(2, '0');
            var ampm = hours >= 12 ? 'PM' : 'AM';

            return `${month}-${day}-${year} ${format12HourTime(hours, minutes, seconds)} ${ampm}`;
        }

        // Function to format 12-hour time
        function format12HourTime(hours, minutes, seconds) {
            const hour12 = hours % 12 || 12;
            return `${hour12}:${minutes}:${seconds}`;
        }

        // Function to add note to database
        function addNote(title, content, updateTime, creationTime) {
            var xhr = new XMLHttpRequest();
            var data = {
                method: "add",
                noteTitle: title,
                noteContent: content,
                noteUpdateTime: updateTime,
                noteCreationTime: creationTime
            };
            var parameters = JSON.stringify(data);
            xhr.open("POST", "processNote.php", true);
            xhr.setRequestHeader("Content-type", "application/json");
            xhr.send(parameters);
            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        console.log(xhr.responseText);
                    }
                    else {
                        console.error("There was a problem with the request.");
                    }
                }
            };
        }

        // Function to update note
        function updateNote(e) {
            document.getElementById('update-timestamp').innerText = 'Last Updated: ' + convertDateTime(getCurrentDateTime());
            var target = e.target;
            var parent = target.parentNode;
            var idStr = parent.id.substring(5);
            var parentID = parseInt(idStr);

            var xhr = new XMLHttpRequest();
            if (target.id == "note-title") {
                var data = {
                    method: "update",
                    noteID: parentID,
                    noteTitle: target.innerText,
                    noteUpdateTime: getCurrentDateTime()
                };
            }
            if (target.id == "note-content") {
                var data = {
                    method: "update",
                    noteID: parentID,
                    noteContent: target.innerText,
                    noteUpdateTime: getCurrentDateTime()
                };
            }
            var parameters = JSON.stringify(data);
            xhr.open("POST", "processNote.php", true);
            xhr.setRequestHeader("Content-type", "application/json");
            xhr.send(parameters);
            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        console.log(xhr.responseText);
                    }
                    else {
                        console.error("There was a problem with the request.");
                    }
                }
            };
        }

        // Function to delete note
        function deleteNote(note) {
            note.remove();
            var idStr = note.id.substring(5);
            var idInt = parseInt(idStr);

            var xhr = new XMLHttpRequest();
            var data = {
                method: "delete",
                noteID: idInt
            };
            var parameters = JSON.stringify(data);
            xhr.open("POST", "processNote.php", true);
            xhr.setRequestHeader("Content-type", "application/json");
            xhr.send(parameters);
            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        console.log(xhr.responseText);
                    }
                    else {
                        console.error("There was a problem with the request.");
                    }
                }
            };
        }
    </script>
</head>

<body>
<!-- Planner Section -->
<div class="styled-container"><!--ww images from dr zach oster imported in here-->
    <div class='a-modules a' style='float:left'><a href='modules.php'>← Dashboard</a></div>
    <br><br>
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
                <option value="" disabled selected></option>
                <?php
                foreach ($days as $day) {
                    echo '<option value="' . $day . '">' . $day . '</option>';
                }
                ?>
            </select></td></tr>
        </div>
        <div class="event-item">
            <tr><td><label for="time-input">Time:</label></td></tr>
            <tr><td><input type="time" id="time-input" name="time-input" style="width:25%"></td></tr>
        </div>
        <div class="event-item">
            <tr><td><button type="submit" name="add-event">Add Event</button></td></tr>
        </div>
    </form>
    </table>
</div>

<!-- Note Taker Section -->
<table id="note-table">
    <tr><td><h1>Notes</h1></td></tr>

    <tr><td><button id="create-note" onclick="createNote()">Create Note</button></td></tr>

</table>

<div class="note-container" id="noteContainer">
    <!-- Notes will be dynamically added here -->
    <?php
    if (count($noteSet) > 0) {
        foreach($noteSet as $note) {
            $ID = $note["ID"];
            $title = $note["title"];
            $details = $note["details"];
            $creationTime = $note["creationTime"];
            $updateTime = $note["updateTime"];
            ?>
            <script>
                createNote("<?php echo $ID; ?>", "<?php echo $title; ?>", "<?php echo $details; ?>", "<?php echo $creationTime; ?>", "<?php echo $updateTime; ?>");
            </script>
            <?php
        }
    }
    ?>
</div>

<?php
    include "footer.html";
?>