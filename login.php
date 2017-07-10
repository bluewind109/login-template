<?php
  require_once 'connect-db.php';

  $email = strip_tags($_POST['email']);
  $password = strip_tags($_POST['password']);
  $remember = $_POST['remember'];

  $email = $DBcon->real_escape_string($email);
  $password = $DBcon->real_escape_string($password);

  $query = $DBcon->query("SELECT user_id, email, password FROM tbl_users WHERE email='$email'");
  $row = $query->fetch_array();

  $cookie_name = "user";
  $cookie_value = $id;
  $expiry = time() + (86400 * 30);

  $count = $query->num_rows; //if email/password are correct returns must be 1 row

  if (password_verify($password, $row['password']) && $count == 1) { //if email and password match

    if($remember == 'true') {
      //setting cookie variable
      setcookie($cookie_name, $cookie_value, $expiry);
    } else {
      session_start();
      $_SESSION['user'] = $row['user_id'];
    }

    //redirecting to home page
    header("Location: home.php");
  } else {
    $msg = "<div class='alert alert-danger'>
            <span class='glyphicon glyphicon-info-sign'></span>&nbsp; Invalid Username or Password
            </div>";
  }
  $DBcon->close();
?>