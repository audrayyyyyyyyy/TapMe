<?php
    session_start();

    # Destroy the current session
    session_destroy();

    # Go back to the login page
    header('location:index.php');
?>