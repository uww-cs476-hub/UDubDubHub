<?php
session_start();
$title = "Tutor";
include "db_conn.php";
include 'header.php';

if (!$db) {
    echo "Could not connect to database!";
    exit();
}
?>

<body>
<div class="styled-container">
    <div class='a-modules a' style='float:left'><a href='modules.php'>← Dashboard</a></div>
    <br>
    <img src="Whitewater Logos/UW-Whitewater_logo_blk_lead_hortizontal.png" style="width:25%">
<h1>Tutoring Service</h1>
<div class="search-bar-tutor">
    <input type="text" id="majorSearch" placeholder="Search for a major..." oninput="filterMajors()">
</div>
</div>
<div class="tutor-container">
    <?php
    $sql = "SELECT * FROM `major`";
    $stm = $db->prepare($sql);
    $stm->execute();
    $majors = $stm->fetchAll(PDO::FETCH_ASSOC);

    foreach ($majors as $major) {
        $majorName = $major["name"];
        $randomTutors = generateRandomTutors(); // Function to generate random tutor names

        echo "<div class='course-card' id='major-$majorName'>";
        echo "<h2 onclick='toggleTutors(\"$majorName\")'>$majorName</h2>";
        echo "<div class='tutors' style='display: none;'>";
        foreach ($randomTutors as $tutor) {
            echo "<div class='tutor'>";
            echo "<p>$tutor</p>";
            echo "<button class='contact-button' onclick='contactTutor(\"$tutor\")'>Contact this tutor</button>";
            echo "</div>";
        }
        echo "</div>";
        echo "</div>";
    }

    function generateRandomTutors() {
        $tutorNames = ["Spider-man", "Batman", "Harry Potter", "Barack Obama", "Donald Trump", "Walter White"];
        shuffle($tutorNames);
        return array_slice($tutorNames, 0, rand(1, count($tutorNames)));
    }
    ?>
</div>

<script>
    function toggleTutors(majorName) {
        var tutorsDiv = document.getElementById('major-' + majorName).getElementsByClassName('tutors')[0];
        tutorsDiv.style.display = (tutorsDiv.style.display === 'none' || tutorsDiv.style.display === '') ? 'flex' : 'none';
    }

    function contactTutor(tutorName) {
        alert("Contacting " + tutorName + ". Please check your email for further instructions.");
    }

    function filterMajors() {
        var input, filter, cards, card, h2, i, txtValue;
        input = document.getElementById("majorSearch");
        filter = input.value.toUpperCase();
        cards = document.getElementsByClassName("course-card");

        for (i = 0; i < cards.length; i++) {
            card = cards[i];
            h2 = card.getElementsByTagName("h2")[0];
            txtValue = h2.textContent || h2.innerText;

            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                card.style.display = "";
            } else {
                card.style.display = "none";
            }
        }
    }
</script>
</body>
</html>
