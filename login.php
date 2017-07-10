<?php
  require_once 'connect-db.php';

  $email = strip_tags($_POST['email']);
  $password = strip_tags($_POST['password']);
  $rememberme = $_POST['remember'];

  $email = $DBcon->real_escape_string($email);
  $password = $DBcon->real_escape_string($password);

  $query = $DBcon->query("SELECT user_id, email, password FROM tbl_users WHERE email='$email'");
  $row = $query->fetch_array();

  $count = $query->num_rows; //if email/password are correct returns must be 1 row

  if (password_verify($password, $row['password']) && $count == 1) { //if email and password match
    $hour = time() + 3600;
    setcookie('ID_my_site', $email, $hour); //remember email for 1 hour

    $year = time() + 31536000;
    if ($rememberme == '1' || $rememberme == 'on') {
      setcookie('email', $email, $year);
      setcookie('password', $password, $year); //remember email and password
    }

    $_SESSION['userSession'] = $row['user_id'];

    header("Location: home.php");
  } else {
    $msg = "<div class='alert alert-danger'>
            <span class='glyphicon glyphicon-info-sign'></span>&nbsp; Invalid Username or Password
            </div>";
  }
  $DBcon->close();
?>