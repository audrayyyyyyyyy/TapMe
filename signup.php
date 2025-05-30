<?php 
  	include('connection.php');
  	session_start();
  
  	if(ISSET($_POST['signupData'])) {
		
   		// Get the form Data
    	$firstname = mysqli_real_escape_string($conn, $_POST['firstname']);
    	$lastname = mysqli_real_escape_string($conn, $_POST['lastname']);
    	$email = mysqli_real_escape_string($conn, $_POST['Email']);
    	$password = mysqli_real_escape_string($conn, $_POST['Password']); 
		
		
    	// TODO: Check for duplicates
    	$email_sql = "SELECT Email FROM ACCOUNT WHERE EMAIL = '$email'";
    	$result = mysqli_query($conn, $email_sql);
    	if(mysqli_num_rows($result) == 0) {
		
    		// Insert Data to DB
    		$sql = "INSERT INTO account (Firstname, Lastname, Email, Password) VALUES ('$firstname', '$lastname','$email', '$password') ";
			
    		$result = mysqli_query($conn, $sql);
			
    		if ($result)
    		{
    		    echo '<script> alert("Account Created Succesfully."); </script>';
    		    header('Location: index.php');
    		}else{
    		    echo '<script> alert("Failed to create an account."); </script>';
    		}
	
	
    	}
  	}
?>



<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style.css">

  <title>signup</title>
</head>
<body>
  <div class="align_horizontal wrapper center-items">
    <img src="img/Branding.svg" alt=""class="branding">

    <div class="form_card align_vertical center-items center_items_vertical">
      <div class="align_vertical center-items">
        <img src="img/logo_icon.svg" class="logo_icon" alt="">
        <h3 class="form_title">Sign Up</h3>
      </div>

      <form action="" method="POST">
        <div class="align_vertical column-std">
          <div class="align_horizontal">
            <input type="text" placeholder="First Name" name="firstname" class="textField other-textfield" maxlength="100" required>
            <input type="text" placeholder="Last Name" name="lastname" class="textField other-textfield" maxlength="100" required>
          </div>
          <input type="email" placeholder="Email" name="Email" class="textField" maxlength="100" required>
          <input type="password" placeholder="Password" name="Password" class="textField" maxlength="100" required>
          <button type="submit" class="submit_btn center-items justify-items" name="signupData" > <div class="button_text">Sign Up</div> </button>
          
        </div>
      </form>

     <div class="footer-text">Already have an account? <a href="index.php">Login here</a></div>
    </div>
  </div>
</body>
</html>