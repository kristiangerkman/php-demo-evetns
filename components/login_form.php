<?php
$error = null;

function generateError($e) {
    return '<div class="error-container" id="error-container"><p id="error-message">' . $e . '</p></div>';
}

if (isset($_POST['register-username']) && isset($_POST['register-password'])) {

    require_once 'classes/dbHandler.php';

    $dbhandler = new DatabaseHandler();
    $db = $dbhandler->connect();

    if (empty($db)) {
        die("connection error.");
    }

    $register_username = $db->real_escape_string(strip_tags($_POST['register-username']));
    $register_password = $db->real_escape_string(strip_tags($_POST['register-password']));

    require_once "classes/userHandler.php";

    $userhandler = new UserHandler();

    $res = $userhandler->create_user($db, $register_username, $register_password);

    if (is_int($res)) {
        $_SESSION['user_id'] = $res;
        echo '<script>window.location.reload();</script>';
        exit;
    } else {
        $error = generateError($res);
    }
}

if (isset($_POST['login-username']) && isset($_POST['login-password'])) {
    require_once 'classes/dbHandler.php';
    require_once 'classes/userHandler.php';

    $dbhandler = new DatabaseHandler();
    $db = $dbhandler->connect();

    if (!$db) {
        die("Connection error.");
    }

    // Sanitize and escape inputs
    $login_username = $db->real_escape_string(strip_tags($_POST['login-username']));
    $login_password = $db->real_escape_string(strip_tags($_POST['login-password']));

    $userhandler = new UserHandler();
    $res = $userhandler->login($db, $login_username, $login_password);

    if (is_int($res)) {
        // Login successful: set session variable and reload the page
        $_SESSION['user_id'] = $res;
        echo '<script>window.location.reload();</script>';
        exit;
    } else {
        // Login failed: display error message
        $error = generateError($res);
    }
}
?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css" />
    <title>Login</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- jQuery CDN -->
</head>

<body>
    <div class="form-container">
        <?php echo $error ?>

        <!-- Login Form -->
        <div class="login-form" id="login-form">
            <h1>Login</h1>
            <form action="" method="post">
                <label>Username:</label>
                <input type="text" name="login-username" id="login-username"><br>
                <label>Password:</label>
                <input type="password" name="login-password" id="login-password">
                <div class="button-container">
                    <input class="button" type="submit" value="Login" id="login">
                    <p id="create-account-link">Create a new account</p>
                </div>
            </form>
        </div>

        <!-- Register Form -->
        <div class="login-form" id="register-form" style="display: none;">
            <h1>Register</h1>
            <form action="" method="post">
                <label>Username:</label>
                <input type="text" name="register-username" id="register-username"><br>
                <label>Password:</label>
                <input type="password" name="register-password" id="register-password">
                <div class="button-container">
                    <input class="button" type="submit" value="Register" id="register">
                    <p id="login-link">Already have an account?</p>
                </div>
            </form>
        </div>
    </div>

    <script>
        $(document).ready(function() {

            if ($("#error-container").is(":visible")) {
                setTimeout(function () {
                    $("#error-container").fadeOut();
                }, 5000);
            }

            $('#create-account-link').click(function() {
                $('#login-form').hide();
                $('#register-form').show();
                clearInputs(); // Clear all input fields
            });

            // Switch to Login form
            $('#login-link').click(function() {
                $('#register-form').hide();
                $('#login-form').show();
                clearInputs(); // Clear all input fields
            });

            // Function to clear all input fields
            function clearInputs() {
                $('#login-username, #login-password, #register-username, #register-password, #register-confirm-password').val('');
            }
        });
    </script>
</body>

</html>