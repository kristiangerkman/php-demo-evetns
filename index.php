<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="style.css" rel="stylesheet" />
</head>

<body>

    <div class="main-content">

        <?php
        if (!isset($_SESSION['logged_in'])) {
            // User is not logged in, show login form
            include 'components/login_form.php';
        } else {
            // User is logged in, show dashboard or other content
            include 'dashboard.php';
        }
        ?>
    </div>
</body>

</html>