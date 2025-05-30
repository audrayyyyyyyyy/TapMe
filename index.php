<?php
  include('connection.php');
  session_start();
  
  if(ISSET($_POST['loginData'])) {
     
     $email = mysqli_real_escape_string($conn, $_POST['Email']);
     $password = mysqli_real_escape_string($conn, $_POST['Password']); 
     
     $sql = "SELECT ACCOUNTID, FIRSTNAME, LASTNAME FROM ACCOUNT WHERE EMAIL = '$email' AND PASSWORD = '$password'";

     $result = mysqli_query($conn, $sql);
     $row = mysqli_fetch_assoc($result);
     
     $count = mysqli_num_rows($result);
     
     // Check if there is an account with the same email and password,
     if($count == 1) {

        # Store basic user information
        $_SESSION['uid'] = $row['ACCOUNTID'];
        $_SESSION['firstname'] = $row['FIRSTNAME'];
        $_SESSION['lastname']  = $row['LASTNAME'];

        header("location: dashboard.php");
     }else {
        $error = "Your Login Name or Password is invalid";
     }
  }
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style.css">

  <title>Login</title>
</head>
<body>
  <div class="align_horizontal wrapper center_items_vertical">
    <img src="img/Branding.svg" alt=""class="branding">

    <div class="form_card align_vertical center-items center_items_vertical">
      <div class="align_vertical center-items">
        <img src="img/logo_icon.svg" class="logo_icon" alt="">
        <h3 class="form_title">Login</h3>
      </div>

      <form action="" method="POST">
        <div class="align_vertical column-std">
          <input type="email" placeholder="Email" name="Email" class="textField" required>
          <input type="password" placeholder="Password" name="Password" class="textField" required>
          <button type="submit" class="submit_btn center-items justify-items" name="loginData" > <div class="button_text">Login</div> </button>
        </div>
      </form>

      <div class="footer-text">Don't have an account? <a href="signup.php">Register here</a></div>
    </div>
  </div>
</body>
</html>