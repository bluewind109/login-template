<?php
  session_start();
  require_once 'connect-db.php';

  if (isset($_SESSION['userSession']) != "") {
    header("Location: home.php");
    exit;
  }

  if (isset($_POST['login'])) {
    $email = strip_tags($_POST['email']);
    $password = strip_tags($_POST['password']);

    $email = $DBcon->real_escape_string($email);
    $password = $DBcon->real_escape_string($password);

    $query = $DBcon->query("SELECT user_id, email, password FROM tbl_users WHERE email='$email'");
    $row = $query->fetch_array();

    $count = $query->num_rows; //if email/password are correct returns must be 1 row

    if (password_verify($password, $row['password']) && $count == 1) {
      $_SESSION['userSession'] = $row['user_id'];
      header("Location: home.php");
    } else {
      $msg = "<div class='alert alert-danger'>
              <span class='glyphicon glyphicon-info-sign'></span>&nbsp; Invalid Username or Password
              </div>";
    }

    $DBcon->close();
  }
?>
<!DOCTYPE html>
<html lang="en-US">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- BASIC INFO (title, keywords, description) -->
  <title>Sign In</title>

  <!-- LIBRARIES CSS -->
  <link href=".\css\bootstrap.css" rel="stylesheet">
  <link href=".\css\bootstrap-theme.css" rel="stylesheet">
  
  <!-- FONTS -->
  
</head>
<body>
  <div class="signin-form">
    <div class="container">
     <form class="login" id="login-form" method="POST">
      <h2 class="form-signin-heading">Sign In</h2>

      <?php
        if (isset($msg)){
          echo $msg;
        }
      ?>

      <hr>

      <div class="form-group">
        <label for="email">Email Address</label>
        <input type="email" class="form-control" name="email" id="email" placeholder="Your email to login...">
      </div>

      <div class="form-group">
        <label for="password">Password</label>
        <input type="password" class="form-control" name="password" id="email" placeholder="Your password...">
      </div>

      <hr>
      <div class="form-group">
        <button type="submit" class="btn btn-info" name="login" id="login">
          <span class="glyphicon glyphicon-log-in"></span>&nbsp; Sign In
        </button>
        <a href=".\register.php" class="btn btn-default" style="float:right;">Sign UP Here</a>
      </div>
     </form>
    </div> <!--end container-->
  </div>

  <!-- JQUERY-->
  <script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.2.0.min.js"></script>

  <!--COMPILED AND MINIFIED JAVASCRIPT-->
  <script src=".\js\bootstrap.min.js"></script>

</body>
</html>