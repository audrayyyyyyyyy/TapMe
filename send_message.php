<?php
    include('connection.php');
    session_start();

    if (ISSET($_POST['send-message']))
    {
        $sender = mysqli_real_escape_string(
            $conn, $_POST['senderID']
        );
        $message = mysqli_real_escape_string(
            $conn, $_POST['message']
        );
        
        $convo_id = mysqli_real_escape_string(
            $conn, $_POST['convoID']
        );

        // Insert Message
        $sql = "INSERT INTO MESSAGE 
            (CONVERSATIONID, CONTENT, DATETIME, SENDER)
            VALUES ('$convo_id', '$message', NOW(), '$sender') ";

        if (mysqli_query($conn, $sql))
        {
            // Get messageID
            $message_id =  mysqli_insert_id($conn);

            // Update Convo Inbox
            $sql = "UPDATE Conversation SET LastMessage='$message_id', LastSender='$sender'
            WHERE ConversationID = '$convo_id'";

            $result = mysqli_query($conn, $sql);

            header("location: dashboard.php");
            exit();
        }
        else
        {
            echo '<script> alert("ERROR: Message not sent!"); </script>';
            session_destroy();
            header('location: index.php');
            exit();
        }

        
        
    }
?>