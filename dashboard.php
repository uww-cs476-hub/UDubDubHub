<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UFT-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="styles.css">
        <?php include 'header.php'; ?>
    </head>
    <body>
        <?php
            $modules = [
                'module1' => true,
            ];
            $userRole = isset($_GET['role']) ? $_GET['role'] : 'guest';
            $active;
            // Include dashboard content based on the user's role
            switch( $userRole ) {
            case 'admin':
                $active = 'admin_dashboard.php';
                break;
            case 'nf':
                $active = 'newStudentFreshman.php';
                break;
            case 'soj':
                $active = 'sophomoreJunior.php';
                break;
            case's+':
                $active = 'senior.php';
                break;
            default:
                $active = 'default.php';
                break;
            }
        ?>
    </body>
    <footer>
        <?php include 'footer.php'; ?>
    </footer>
</html>