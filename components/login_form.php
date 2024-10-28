<!DOCTYPE html>
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
        <div class="error-container" id="error-container">
            <p>ERROR: Incorrect login information</p>
        </div>

        <!-- Login Form -->
        <div class="login-form" id="login-form">
            <h1>Login</h1>
            <form action="post_actions.php">
                <label>Username:</label>
                <input type="text" name="username" id="login-username"><br>
                <label>Password:</label>
                <input type="password" name="password" id="login-password">
                <div class="button-container">
                    <input class="button" type="button" value="Login" id="login">
                    <p id="create-account-link">Create a new account</p>
                </div>
            </form>
        </div>

        <!-- Register Form -->
        <div class="login-form" id="register-form" style="display: none;">
            <h1>Register</h1>
            <form action="post_actions.php">
                <label>Username:</label>
                <input type="text" name="username" id="register-username"><br><br>
                <label>Password:</label>
                <input type="password" name="password" id="register-password"><br>
                <label>Confirm password:</label>
                <input type="password" name="confirm-password" id="register-confirm-password">
                <div class="button-container">
                    <input class="button" type="button" value="Register" id="register">
                    <p id="login-link">Already have an account?</p>
                </div>
            </form>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            $('#error-container').hide()
            // Switch to Register form

            $('#create-account-link').click(function () {
                $('#login-form').hide();
                $('#register-form').show();
                clearInputs(); // Clear all input fields
            });

            // Switch to Login form
            $('#login-link').click(function () {
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