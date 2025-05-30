<?php
    include('connection.php');
    session_start();

    $convo_uid =  $_POST['convo_uid'];
    $uid = $_POST['uid'];
    $sql = "'SELECT ACCOUNT1 ACCOUNT2 FROM CONVERSATION WHERE 
        ConversationID = '$convo_uid'";

    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);

    $account1 = $row["ACCOUNT1"];
    $account2 = $row['ACCOUNT2'];

    if ($account1 == $uid)
    {
        $_SESSION['receiver_id'] = $account2;
    }
    else
    {
        $_SESSION['receiver_id'] = $account1;
    }

    $_SESSION['convo_uid'] = $row['ConversationID'];
    header('Location: dashboard.php');
    exit();
?>