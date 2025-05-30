<?php
    include('connection.php');
    session_start();

    if (ISSET($_POST['edit-account']))
    {
        $firstname = mysqli_real_escape_string(
            $conn, $_POST['firstname']
        );
        $lastname = mysqli_real_escape_string(
            $conn, $_POST['lastname']
        );
        $uid = mysqli_real_escape_string(
            $conn, $_POST['uid']
        );
   
        // Update Account
        $sql = "UPDATE ACCOUNT SET 
            Firstname='$firstname',
            Lastname='$lastname'
            WHERE AccountID='$uid'";

        // Run sql
        $result = mysqli_query($conn, $sql);

        // Update Sessions
        $_SESSION['firstname'] = $firstname;
        $_SESSION['lastname'] = $lastname;

        // Reroute back to dashboard
        header("location: dashboard.php");
        exit();
    }
?>