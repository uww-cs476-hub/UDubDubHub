<?php
session_start();

if (isset($_SESSION["netID"])) {
    header("Location: modules.php");
}

$title = "Survey";
include "header.php";
include "db_conn.php";

if (!$db) {
    echo "Could not connect to database!";
    exit();

}
?>
<div class="styled-container"><!--ww images from dr zach oster imported in here-->
<img src="Whitewater Logos/UW-Whitewater_logo_blk_lead_hortizontal.png" style="width:25%">
<h1>Welcome to the University of Wisconsin - Whitewater Information Hub</h1>
<h3>The U-Dub-Dub-Hub requires you to complete this simple survey. This allows us to get more information on you as a student so that we can give you the best experience within the hub.</h3>
    <h4>Already a user? Login <a class="a-CreateOneLogin" href="login.php">here</a></h4><!--link to login page-->
</div>
<?php
    if (isset($_SESSION['username_error'])) {
        echo '<div style="text-align: center; color: red;"><p>' . $_SESSION['username_error'] . '</p></div>';
        unset($_SESSION['username_error']);
    }
?>
    <form action="index.php?mode=addNewUser" method="post">
        <table>
        <tr>
            <td>
                <h2>Create an Account:</h2></td></tr>
        <tr>
            <!--this may need to become a variable in php that can be used for the home page to say "Welcome... $Name"-->
            <td>First Name:</td>
        </tr>
        <tr>
            <td><input type='text' id="firstName" name="firstName" required/></td>
        </tr>
        <tr>
            <!--this may need to become a variable in php that can be used for the home page to say "Welcome... $Name"-->
            <td>Last Name:</td>
        </tr>
        <tr>
            <td><input type='text' id="lastName" name="lastName" required/></td>
        </tr>
        <tr>
            <td>Standing:</td>
        </tr>
        <tr>
            <td> <select name="standing" class="dropdown-survey" required>
                <option value="" disabled selected></option>
                <option value="Freshman">Freshman</option>
                <option value="Sophomore">Sophomore</option>
                <option value="Junior">Junior</option>
                <option value="Senior">Senior+</option>
                <option value="Transfer Student">Transfer Student</option>
            </select></td>
        </tr>
        <tr>
            <!--the major and minor data will have to be imported here. I'm guessing that will be drawn from database?-->
            <td>Major:</td>
        </tr>
        <tr>
            <td> <select name="major" class="dropdown-survey" required>
                <option value="" disabled selected></option>
                <?php
                    $sql = "SELECT * FROM `major`";
                    
                    $stm = $db->prepare($sql);
                    $stm->execute();
                    $resultSet = $stm->fetchAll(PDO::FETCH_ASSOC);

                    foreach ($resultSet as $item) {
                        ?>
                            <option value="<?php echo $item["name"]; ?>"><?php echo $item["name"]; ?></option>
                        <?php
                    }
                ?>
            </select></td>
        </tr>
        <tr>
            <td>Minor:</td>
        </tr>
        <tr>
            <td> <select name="minor" class="dropdown-survey" required>
                <option value="None" selected>None</option>
                <?php
                    $sql = "SELECT * FROM `minor`";
                    $stm = $db->prepare($sql);
                    $stm->execute();
                    $resultSet = $stm->fetchAll(PDO::FETCH_ASSOC);

                    foreach ($resultSet as $item) {
                        ?>
                            <option value="<?php echo $item["name"]; ?>"><?php echo $item["name"]; ?></option>
                        <?php
                    }
                ?>
            </select></td>
        </tr>
        <tr>
            <td>Extra Enrollment Information:</td>
        </tr>
        <tr>
            <td><input type="radio" name="enrollmentType" value="On Campus"> I am an on-campus student</td>
        </tr>
        <tr>
            <td><input type="radio" name="enrollmentType" value="Online"> I am an online student</td>
        </tr>
        <tr>
            <!--backend will have to do log in coding here-->
            <td>Create a Username (Enter your Net ID):</td>
        </tr>
        <tr>
            <td><input type='text' id="netID" name="netID" required></td>
        </tr>
        <tr> <td>Create a Password:</td>
        </tr>
        <tr>
            <td><input type="password" id="password" name="password" required></td>
        </tr>
    </table>
    <input type="submit" value="Submit">
</form>
<?php
include "footer.html";
?>