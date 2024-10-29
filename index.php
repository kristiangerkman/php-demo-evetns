<?php session_start();?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
    <link href="style.css" rel="stylesheet" />
</head>

<body>

    <div class="main-content">

        <?php
        if (!isset($_SESSION['user_id'])) {
            include 'components/login_form.php';
        } else {
            include 'dashboard.php';
        }
        ?>
    </div>
</body>

</html>