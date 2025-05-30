<?php
    include('connection.php');
    session_start();

    $account1 =  $_POST['account1'];
    $account2 = $_POST['account2'];
    $sql = "SELECT ConversationID FROM CONVERSATION WHERE 
        (ACCOUNT1 = '$account1' AND ACCOUNT2 = '$account2') OR
        (ACCOUNT1 = '$account2' AND ACCOUNT2 = '$account1') ";


    $result = mysqli_query($conn, $sql);
    $count = mysqli_num_rows($result);
    if ($count == 0) {
        $sql = "INSERT INTO CONVERSATION (ACCOUNT1, ACCOUNT2) VALUES
        ('$account1', '$account2') ";

        $result = mysqli_query($conn, $sql);

        
    	if ($result)
    	{
    	    $row = mysqli_fetch_array($result);
            $_SESSION['convo_uid'] = $row['ConversationID'];
            $_SESSION['receiver_id'] = $account1;
            header('Location: dashboard.php');
            exit();

    	}else{
    	    echo '<script> alert("Failed to create an account."); </script>';
            # Destroy the current session
            session_destroy();
            
            header('location: index.php');
            exit();
        }
    }
    else
    {
        $row = mysqli_fetch_array($result);
        $_SESSION['convo_uid'] = $row['ConversationID'];
        $_SESSION['receiver_id'] = $account1;
        header('Location: dashboard.php');
        exit();
    }
?>