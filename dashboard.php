<?php
    include('connection.php');
    session_start();

    #Check if a user is logged in or not
    if (!ISSET($_SESSION['uid']))
    {
        header('location: index.php');
        exit();
    }

    $searchResult = '';
    $selectedAcc = '';
	$receiver_name = '';
	$convo_id = '';
    $uid = $_SESSION['uid'];

    if(isset($_POST['search_str']))
    {
        $search_str = mysqli_real_escape_string($conn, $_POST['search_str']);

        $sql = "SELECT ACCOUNTID, FIRSTNAME, LASTNAME FROM ACCOUNT WHERE
            FIRSTNAME LIKE '%$search_str%' OR LASTNAME LIKE '%$search_str%'";

        $searchResult = mysqli_query($conn, $sql);
    }

	if (isset($_SESSION["receiver_id"]))
	{
		$receiver_uid = $_SESSION['receiver_id'];
		$sql = "SELECT FIRSTNAME, LASTNAME FROM ACCOUNT WHERE ACCOUNTID = '$receiver_uid'";
		$result = mysqli_query($conn, $sql);
		$row = mysqli_fetch_assoc($result);

		$receiver_name = $row["FIRSTNAME"] . ' ' . $row['LASTNAME'];
	}

    if (isset($_SESSION['convo_uid']))
    {
        $convo_id = $_SESSION['convo_uid'];
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Dashboard</title>

		<script src="http://code.jquery.com/jquery-3.3.1.min.js"
    integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>

    <script>
    function show_func()
    {
        var element = document.getElementById("chat-history");
        element.scrollTop = element.scrollHeight;
    }
  </script>
</head>

<body onload="show_func()">
    <div class="dashboard-wrapper">

        <!-- Side Panel -->
        <div class="side-panel">
            <div class="side-panel-user">
                <img class= "profile-pic" src="img/profile_pictures/1.jpg" alt="cat">
                <div class = "username">
                    <p id='side-panel-username'><?php echo $_SESSION['firstname'] . ' ' . $_SESSION['lastname']; ?></p>
                    <a href="logout.php"><p id="logout"> Logout</p></a>
                </div>
                <button class= "button-pen" id="edit-btn">
                    <img class= "pen-icon" src="img/pen-icon.svg" alt="pen">
                </button>
            </div>

            <!-- Search -->
            <form  action="" method="Post" class="flex">
                <input type="text" placeholder="Search accounts" name="search_str" id="search-form" autocomplete="off">
            </form>

            <!-- Search Results -->
            <?php
                if ($searchResult)
                {
                    $count = mysqli_num_rows($searchResult);

                    if ($count)
                    {
                        ?>
                        <p id="search-result-label" class="inter small" >Search results</p>
                        
                        <div class="search-result-container">    
                            <?php

                            while($row = mysqli_fetch_assoc($searchResult))
                            {
                            ?>
                                <button class = "search-result">
                                    <img class= "search-profile-pic" src="img/profile_pictures/1.jpg">
                                    <div class="align-vertical">
                                        <p class="search-name"> <?php echo $row['FIRSTNAME'] . ' ' . $row['LASTNAME']; ?></p>
                                        <div class="search-uid-container">
                                            <p> uid: </p><p class="search-acc-id"><?php echo $row['ACCOUNTID']; ?></p>
                                        </div>
                                    </div>
                                    
                                </button>

                            <?php
                            }
                            ?>
                        </div>
                        <?php
                    }
                }
                
                
            ?>

            <!-- Inbox -->
            <p class="inbox-label">Inbox</p>
            
            <div id="Inbox-wrapper">
            <?php 
            
            // CONTINUE
                $sql = "SELECT message.*, account.*, Conversation.*
                FROM CONVERSATION, MESSAGE, ACCOUNT WHERE 
                (Account1 = '$uid' or Account2 = '$uid') AND
                (LastMessage = MessageID) 	AND
                account.accountID = Message.Sender;";
                
                $result = mysqli_query($conn, $sql);
                while($row = mysqli_fetch_assoc($result))
                {
                    
                    ?>
                    <button class="inbox">
                        <div class="align_horizontal center-items inbox-info-wrapper space-between">
                            <div class="align_horizontal center-items gap-small">
                                <img class= "search-profile-pic" src="img/profile_pictures/1.jpg" alt="cat">
                                <p class="inbox-sender inter small"> <?php echo $row['Firstname'] . " " . $row['Lastname'] ?></p>
                            </div>
                            <div style="max-width: 88px; float: right;">
                                <p style="font-family: Inter; font-size: 12px; color: #A9ABAD;"><?php echo $row['DateTime'] ?></p>
                            </div>
                            
                            <p style="display: none" class="inbox-convo-id">
                            <?php
                                if ($row['Account1'] == $uid)
                                {
                                    echo $row['Account2'];
                                }
                                else {
                                    echo $row['Account1'];
                                }
                            ?></p>

                        </div>
                        <span class="inbox-message"> <?php echo $row['Content'] ?> </span>
                    </button>
                    <?php
                }
              
            ?>
          
            </div>
            
        </div>


        <!-- Chats -->
				
        <div class="chats-panel">
            <div class="upper-chat"> 
                <img src="img/profile_pictures/2.jpg" alt="" id="other_profile">
                <p class="inter large">
					<?php echo $receiver_name ?>
				</p>
            </div>
            
            <div id="chat-history">
            <?php
                $sql = "SELECT Sender, Content, Datetime FROM MESSAGE WHERE CONVERSATIONID = '$convo_id'";
                $result = mysqli_query($conn, $sql);

                if ($result)
                {
                    while($row = mysqli_fetch_assoc($result))
                    {
                        if ($row["Sender"] == $uid)
                        {
                        ?>
                            <div class="message-wrapper" style="flex-direction: row-reverse">
                                <img src="img/profile_pictures/1.jpg" class="msg-profile-pic">
                                <span class="message_bubble inter small"><?php echo $row['Content']; ?></span>
                            </div>
                        <?php
                        }
                        else
                        {
                            ?>
                                <div class="message-wrapper" style="flex-direction: row">
                                    <img src="img/profile_pictures/1.jpg" class="msg-profile-pic">
                                    <span class="message_bubble inter small"><?php echo $row['Content']; ?></span>
                                </div>
                            <?php 
                        }
                    }
                }
            ?>
            </div>

            <form action="send_message.php" method="POST">
                <div class="chatbox-container">
                    <input type="text" placeholder="Enter your message" class="chat-textbox" name="message" autocomplete="false">
                    <input type="hidden" name="senderID" value="<?php echo $uid ?>">
                    <input type="hidden" name="convoID" value="<?php echo $convo_id ?>">

                    <button type="submit" class="send-button" name="send-message">
                        <img src="img/send.svg" class='send-button-img'>
                    </button>
                </div>
            </form>

        </div>


        <!-- User Detail  -->

        <div class="user-detail">
            <img src="img/profile_pictures/2.jpg" class= "user-detail-pic">
            <p id="user-detail-name">
				<?php echo $receiver_name; ?>
			</p>
        </div>
    </div>


    <!-- Edit Account Modal -->
    <div class="blur center-item" id="edit-modal" style="display:none">
        <div id="edit-account">
            <button class="close-button" id="close-edit-btn"><img src="img/cross.svg" alt=""></button>
            <form class="align_vertical space-between fill-height" method="POST" action="edit_account.php">
                <div class='align_vertical center-items '>
                    <img id="edit-profile-pic" src="img/profile_pictures/1.jpg" alt="">
                    <p class="inter small"> Edit Profile</p>
                </div>
                <div class='align_vertical gap-small center-items'>
                    <input type="text" placeholder="Firstname" class="textField-normal" name="firstname" id="edit-firstname-input">
                    <input type="text" placeholder="Lastname" class="textField-normal" name="lastname" id="edit-lastname-input">
                    <input type="hidden" name="uid" value="<?php echo $uid ?>">
                </div>
                <button type="submit" class="button-normal" name='edit-account'>Save</button>
                
            </form>
        </div>   
    </div>
    
    <!-- When user clicks on a search result -->
    <script>
    $(document).ready(function () {
      $('.search-result').on('click', function()
      {
				var account1 = $(this).find('.search-acc-id').text();
				

				$.post("convo.php", {
					"account1": account1,
					"account2": <?php echo $_SESSION['uid'] ?>
				});
				location.reload();
      });
    });
    </script>

    <!-- When user clicks on a search result -->
    <script>
    $(document).ready(function () {
      $('.inbox').on('click', function()
      {
				var account1 = $(this).find('.inbox-convo-id').text();

				$.post("convo.php", {
					"account1": account1,
					"account2": <?php echo $_SESSION['uid'] ?>
				});
				location.reload();
      });
    });
    </script>

    <!-- When user clicks on a Edit Account -->
    <script>
    $(document).ready(function () {
      $('#edit-btn').on('click', function()
      {
        var fname = "<?php echo $_SESSION['firstname'] ?>";
        var lname = "<?php echo $_SESSION['lastname'] ?>"
        $('#edit-modal').show();

        $('#edit-firstname-input').val(fname);
        $('#edit-lastname-input').val(lname);

      });
    });
    </script>


    <!-- When user clicks on close edit button -->
    <script>
    $(document).ready(function () {
      $('#close-edit-btn').on('click', function()
      {
        $('#edit-modal').hide();
      });
    });
    </script>

</body>
</html>
