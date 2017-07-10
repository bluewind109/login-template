<?php
  session_start();

  //if either cookie or session is set, redirect to home page
  if ((isset($_COOKIE['user']) && $_COOKIE['user'] != '') 
    || (isset($_SESSION['user']) && $_SESSION['user'] != '')) {
    header("Location: home.php");
  } else {
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
     <form class="login" action="login.php" id="login-form" method="POST">
      <h2 class="form-signin-heading">Sign In</h2>

      <?php
        if (isset($msg)){
          echo $msg;
        }
      ?>

      <hr>

      <div class="form-group">
        <label for="email">Email Address</label>
        <input type="text" class="form-control" name="email" id="email" placeholder="Your email to login...">
      </div>

      <div class="form-group">
        <label for="password">Password</label>
        <input type="password" class="form-control" name="password" id="email" placeholder="Your password...">
      </div>

      <label><input type="checkbox" name="true" value="true" id="remember"> Remember Me</label>
      
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
<?php
}
?>