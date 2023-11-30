<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Planner</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 20px;
        }

        .planner {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 10px;
        }

        .day {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
            background-color: #f9f9f9;
        }

        .event {
            background-color: #4CAF50;
            color: white;
            padding: 8px;
            margin: 4px 0;
            border-radius: 5px;
        }

        .add-event {
            margin-top: 20px;
        }

        .note-container {
            max-width: 600px;
            width: 100%;
        }

        .note {
            background-color: #f8f8f8;
            border: 1px solid #ddd;
            margin: 10px 0;
            padding: 10px;
            border-radius: 5px;
        }

        .note h2 {
            margin-top: 0;
        }

        .delete-button {
            cursor: pointer;
            color: red;
        }

        .timestamp {
            color: grey;
        }

        .lastUpdatedTimestamp {
            color: grey;
        }
    </style>
</head>

    <body>
    <!-- Planner Section -->
    <h1>Planner</h1>

    <div class="planner">
        <?php
        $days = array("Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday");

        foreach ($days as $day) {
            echo '<div class="day">' . $day . '</div>';
        }
        ?>
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
                    echo '<option value="' . strtolower($day) . '">' . $day . '</option>';
                }
                ?>
            </select>
            <label for="time-input">Time:</label>
            <input type="time" id="time-input" name="time-input">
            <button type="submit" name="add-event">Add Event</button>
        </form>

        <?php
        if (isset($_POST['add-event'])) {
            $eventName = $_POST['event-name'];
            $selectedDay = $_POST['day-select'];

            if (trim($eventName) !== '') {
                echo '<script>addEvent("' . htmlspecialchars($eventName) . '", "' . htmlspecialchars($selectedDay) . '");</script>';
            } else {
                echo '<script>alert("Please enter an event name.");</script>';
            }
        }
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
    <div class="note-container" id="noteContainer">
        <!-- Notes will be dynamically added here -->
    </div>

    <div>
        <button onclick="createNote()">Create Note</button>
    </div>

        <script>
            // Function to create a new note
            function createNote() {
                const noteContainer = document.getElementById('noteContainer');

                const note = document.createElement('div');
                note.className = 'note';

                const title = document.createElement('h2');
                title.contentEditable = true;
                title.innerText = 'New Note';

                const content = document.createElement('div');
                content.contentEditable = true;
                content.innerText = 'Write your note here.';
                content.addEventListener('input', updateLastUpdated);

                const space = document.createElement('div');
                space.innerText = '\n';

                const lastUpdatedTimestamp = document.createElement('div');
                lastUpdatedTimestamp.className = 'timestamp';
                lastUpdatedTimestamp.innerText = 'Last Updated: ' + getCurrentDateTime();

                const timestamp = document.createElement('div');
                timestamp.className = 'timestamp';
                timestamp.innerText = 'Created: ' + getCurrentDateTime();

                const deleteButton = document.createElement('span');
                deleteButton.className = 'delete-button';
                deleteButton.innerText = 'Delete';
                deleteButton.onclick = function () {
                    note.remove();
                };

                note.appendChild(title);
                note.appendChild(content);
                note.appendChild(space);
                note.appendChild(timestamp);
                note.appendChild(lastUpdatedTimestamp);
                note.appendChild(deleteButton);

                noteContainer.appendChild(note);

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
    </body>
</html>