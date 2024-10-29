<?php
session_start();

if (isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])) {
    session_unset();
    session_destroy();

    header('Location: ..');
    exit;
} else {
    header('Location: ..');
    exit;
}
?>