<?php
session_start();

// Check if user is logged in
if (isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])) {
    // Unset all session variables
    session_unset();

    // Destroy the session
    session_destroy();

    // Redirect to index.php
    header('Location: ..');
    exit;
} else {
    // If not logged in, redirect to index.php directly
    header('Location: ..');
    exit;
}
?>