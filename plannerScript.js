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