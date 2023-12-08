<?php
session_start();
$title = "Module Visibility";
include 'header.php';

// Check if form is submitted to update module visibility
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Assuming you have a form with checkboxes for each module
    $newVisibilityData = isset($_POST['visibility']) ? $_POST['visibility'] : [];

    // Save the updated visibility data to a file or database
    file_put_contents('visibilityData.json', json_encode($newVisibilityData));

    // Redirect back to the dashboard page
    header('Location: modules.php');
    exit;
}

// Read the current visibility data
//$visibilityData = json_decode(file_get_contents('visibilityData.json'), true);

$modules = [
    'Get to Know Your Way Around Campus',
    'Helpful Academic Resources',
    'Campus Life Resources',
    'Other Resources',
    'Student Directory',
    'Get Involved',
    'Need Technical Help?',
    'Graduation Resources',
    'Career Resources'
];
?>

<body>

<h2>Update Module Visibility</h2>

<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <?php foreach ($modules as $moduleName): ?>
        <label>
            <input type="checkbox" name="visibility[<?php echo $moduleName; ?>]"
                <?php echo isset($visibilityData[$moduleName]) && $visibilityData[$moduleName] ? 'checked' : ''; ?>>
            <?php echo $moduleName; ?>
        </label>
        <br>
    <?php endforeach; ?>

    <br>
    <button type="submit">Update Visibility</button>
</form>

</body>

