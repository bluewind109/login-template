<?php
  session_start();
  if (isset($_SESSION['userSession']) != ""){
    header("Location: home.php");
  }
  require_once 'connect-db.php';

  $unameErr = $emailErr = $pwErr = $repwErr = "";

  if(isset($_POST['reg'])){

    if (empty($_POST["username"])) {
      $unameErr = "Please enter your username!";
    } else {
      $uname = test_input($_POST["username"]); //check if username contains letters and whitespace
      $unamePattern = "/^.*(?=.{8,21})(?=.[a-zA-Z ]).*$/";
      if (!preg_match($unamePattern, $uname)) {
        $unameErr = "Username must be between 8-20 characters and only letters and white space allowed!";
      }
    }

    if (empty($_POST["email"])) {
      $emailErr = "Please enter your email!";
    } else {
      $email = test_input($_POST["email"]); //check if email in correct format

      if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $emailErr = "Invalid email format!";
      }
    }

    if (empty($_POST["password"])) {
      $pwErr = "Please enter your password!";
    } else {
      $upass = test_input($_POST["password"]); //check if password in invalid format
      $pattern = '/^.*(?=.{7,20})(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).*$/';
      if (!preg_match($pattern, $upass)) {
        $pwErr = "Your password must be between 7-20 chars, at least one upper case, one lower case, one digit!";
      }
    }

    if (empty($_POST["re-password"])) {
      $repwErr = "Please re-enter your password to confirm!";
    } else {
      $urepass = test_input($_POST["re-password"]);
      if ($_POST["password"] != $_POST["re-password"]) {
        $repwErr = "Please make sure your password match your confirm password!";
      }
    }

    $uname = strip_tags($_POST['username']); //strip the string from HTML tags
    $email = strip_tags($_POST['email']);
    $upass = strip_tags($_POST['password']);
    $urepass = strip_tags($_POST['re-password']);

    $uname = $DBcon->real_escape_string($uname); //add escape (backlash '\') before dangerous characters
    $email = $DBcon->real_escape_string($email);
    $upass = $DBcon->real_escape_string($upass);

    $hashed_password = password_hash($upass, PASSWORD_DEFAULT); //create a password hash

    $check_email = $DBcon->query("SELECT email FROM tbl_users WHERE email='$email'"); //check if the new email is conflict with the old ones in database
    $count = $check_email->num_rows;

    if ($count == 0) { //if no conflict, add this new user to db
      if($unameErr != "" || $emailErr != "" || $pwErr != "" || $repwErr != "") {
        $msg = "<div class='alert alert-danger'>
                    <span class='glyphicon glyphicon-info-sign'></span>&nbsp; Error while registering!
                  </div>";
        
      } else {
        $query = "INSERT INTO tbl_users(username,email,password) VALUES('$uname','$email','$hashed_password')";
        $data = $DBcon->query($query);
        if($data) {
          $msg = "<div class='alert alert-success'>
                    <span class='glyphicon glyphicon-info-sign'></span>&nbsp; Successfully registered!
                  </div>";
        }
      }
    } else {
      $msg = "<div class='alert alert-danger'>
                <span class='glyphicon glyphicon-info-sign'></span>&nbsp; Sorry email already existed.
              </div>";
    }

    $DBcon->close();
  }

  function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }
?>

<!DOCTYPE html>
<html lang="en-US">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- BASIC INFO (title, keywords, description) -->
  <title>Sign Up</title>

  <!-- LIBRARIES CSS -->
  <link href=".\css\bootstrap.css" rel="stylesheet">
  <link href=".\css\bootstrap-theme.css" rel="stylesheet">
  
  <!-- FONTS -->
  
</head>
<body>
  <div class="signin-form">
    <div class="container">
      <form class="form-signin form-horizontal" id="register-form" method="POST">
        <h2 class="form-signin-heading">Sign Up</h2>

        <?php
          if (isset($msg)){
            echo $msg;
          }
        ?>

        <hr>

        <div class="form-group">
          <label class="control-label col-sm-2" for="username">Username</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" name="username" id="username" placeholder="Your username...">
            <span class="error"><?php echo $unameErr;?></span>
          </div>
        </div>

        <div class="form-group">
          <label class="control-label col-sm-2" for="email">Email Address</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" name="email" id="email" placeholder="Your Email Address...">
            <span class="error"><?php echo $emailErr;?></span>
          </div>
        </div>

        <div class="form-group">
          <label class="control-label col-sm-2" for="password">Password</label>
          <div class="col-sm-10">
            <input type="password" class="form-control" name="password" id="password" placeholder="Your password...">
            <span class="error"><?php echo $pwErr;?></span>
          </div>
        </div>

        <div class="form-group">
          <label class="control-label col-sm-2" for="re-password">Confirm Password</label>
          <div class="col-sm-10">
            <input type="password" class="form-control" name="re-password" id="re- password" placeholder="Confirm your password...">
            <span class="error"><?php echo $repwErr;?></span>
          </div>
        </div>

        <hr>

        <div class="form-group">
          <button type="submit" class="btn btn-success" name="reg" id="reg">
            <span class="glyphicon glyphicon-ok-sign"></span>&nbsp; Register
          </button>
          <a href=".\index.php" class="btn btn-default" style="float:right;">LOGIN Here</a>
        </div>
      </form>
    </div> <!--end container-->
  </div> <!--end sign up form-->

  <!-- JQUERY-->
  <script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.2.0.min.js"></script>

  <!--COMPILED AND MINIFIED JAVASCRIPT-->
  <script src=".\js\bootstrap.min.js"></script>

</body>
</html>