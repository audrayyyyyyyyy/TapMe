<?php
    include('connection.php');

    if (ISSET($_POST['loginData']))
    {
        $email = mysqli_real_escape_string(
            $conn, $_REQUEST['Email']
        );
        $password = mysqli_real_escape_string(
            $conn, $_REQUEST['Password']
        );

        # TODO Use encrypted Passwords
        $sql = "SELECT AccountID, FIRSTNAME, LASTNAME FROM Account WHERE Account.email = '$email' and Account.password = '$password'";

        $result = mysqli_query($conn, $sql);
        $count = mysqli_num_rows($result);

        // If there is a match
        if ($count == 1)
        {
            $row = mysqli_fetch_assoc($result);           

            // Store basic user data in the session
            $_SESSION['uid'] = $row['accountID'];
            $_SESSION['Firstname'] = $row['Firstname'];
            $_SESSION['Lastname'] = $row['Lastname'];
            $_SESSION['convo_uid'] = '';

            header('Location: dashboard.php');
            exit();
        }

        header('Location: index.php');
        exit();
    }
   
?>