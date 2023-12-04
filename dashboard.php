<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Dashboard</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Hello, <?php echo isset($_GET['username']) ? $_GET['username'] : 'guest';?></h1>
    </header>

    <?php
    $modules = [
        'Get to Know Your Way Around Campus' => true,
        'Helpful Academic Resources' => true,
        'Campus Life Resources' => true,
        'Other Resources' => true,
        'Student Directory' => true,
        'Get Involved' => true,
        'Need Technical Help?' => true,
        'Graduation Resources' => true,
        'Career Resources' => true,
    ];

    $userRole = isset($_GET['role']) ? $_GET['role'] : 'guest';
    $active;

    // Include dashboard content based on the user's role
    switch ($userRole) {
        case 'admin':
            $active = 'admin_dashboard.php';
            $modules = [
                'Get to Know Your Way Around Campus' => true,
                'Helpful Academic Resources' => true,
                'Campus Life Resources' => true,
                'Other Resources' => true,
                'Student Directory' => true,
                'Get Involved' => true,
                'Need Technical Help?' => true,
                'Graduation Resources' => true,
                'Career Resources' => true,
            ];
            break;
        case 'nf':
            $active = 'newStudentFreshman_dashboard.php';
            $modules = [
                'Get to Know Your Way Around Campus' => true,
                'Helpful Academic Resources' => true,
                'Campus Life Resources' => true,
                'Other Resources' => true,
                'Student Directory' => true,
                'Get Involved' => true,
                'Need Technical Help?' => true,
                'Graduation Resources' => false,
                'Career Resources' => false,
            ];
            break;
        case 'soj':
            $active = 'sophomoreJunior_dashboard.php';
            $modules = [
                'Get to Know Your Way Around Campus' => false,
                'Helpful Academic Resources' => false,
                'Campus Life Resources' => true,
                'Other Resources' => false,
                'Student Directory' => true,
                'Get Involved' => true,
                'Need Technical Help?' => true,
                'Graduation Resources' => false,
                'Career Resources' => false,
            ];
            break;
        case 's+':
            $active = 'seniorPlus_dashboard.php';
            $modules = [
                'Get to Know Your Way Around Campus' => false,
                'Helpful Academic Resources' => false,
                'Campus Life Resources' => false,
                'Other Resources' => true,
                'Student Directory' => true,
                'Get Involved' => true,
                'Need Technical Help?' => true,
                'Graduation Resources' => true,
                'Career Resources' => true,
            ];
            break;
        default:
            $active = 'default_dashboard.php';
            $modules = [
                'Get to Know Your Way Around Campus' => true,
                'Helpful Academic Resources' => true,
                'Campus Life Resources' => true,
                'Other Resources' => true,
                'Student Directory' => true,
                'Get Involved' => true,
                'Need Technical Help?' => true,
                'Graduation Resources' => true,
                'Career Resources' => true,
            ];
            break;
    }
    ?>

    <form method="post">
        <?php
        // Display modules in the form
        foreach ($modules as $module => $visibility) {
            echo "<label><input type='checkbox' name='$module' " . ($visibility ? 'checked' : '') . "> $module</label><br>";
        }
        ?>
        <input type="submit" value="Update Visibility">
    </form>

<?php include 'footer.html'; ?>