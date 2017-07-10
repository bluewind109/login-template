<?php
	session_start();
	include_once 'connect-db.php';

  if(isset($_COOKIE['user']) && $_COOKIE['user'] != '') {
    $user =$_COOKIE['user'];
    //get user data from mysql

  } else if(isset($_SESSION['user']) && $_SESSION['user'] != '') {
    $user = $_SESSION['user'];
  } else {
    header("Location: index.php");
  }

	if (!isset($_SESSION['user'])) {
		header("Location: index.php");
	}

	$query = $DBcon->query("SELECT * FROM tbl_users WHERE user_id=".$_SESSION['user']);
	$userRow = $query->fetch_array();
	$DBcon->close();
?>

<!DOCTYPE html>
<html lang="en-US">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- BASIC INFO (title, keywords, description) -->
  <title>Home</title>

  <!-- LIBRARIES CSS -->
  <link href=".\css\bootstrap.css" rel="stylesheet">
  <link href=".\css\bootstrap-theme.css" rel="stylesheet">
  
  <!-- FONTS -->
  
</head>
<body>
	<nav class="navbar navbar-default navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="http://www.codingcage.com">Coding Cage</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li class="active"><a href="http://www.codingcage.com/2015/03/simple-login-and-signup-system-with-php.html">Back to Article</a></li>
            <li><a href="http://www.codingcage.com/search/label/jQuery">jQuery</a></li>
            <li><a href="http://www.codingcage.com/search/label/PHP">PHP</a></li>
          </ul>
          <ul class="nav navbar-nav navbar-right">
            <li><a href="#"><span class="glyphicon glyphicon-user"></span>&nbsp; <?php echo $userRow['username']; ?></a></li>
            <li><a href="logout.php?logout"><span class="glyphicon glyphicon-log-out"></span>&nbsp; Logout</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>

	<div class="container" style="margin-top:150px;text-align:center;font-family:Verdana, Geneva, sans-serif;font-size:35px;">
	 <a href="http://www.codingcage.com/">Coding Cage - Programming Blog</a><br /><br />
	    <p>Tutorials on PHP, MySQL, Ajax, jQuery, Web Design and more...</p>
	</div>

	<!-- JQUERY-->
  	<script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.2.0.min.js"></script>

	<!--COMPILED AND MINIFIED JAVASCRIPT-->
 	<script src=".\js\bootstrap.min.js"></script>
</body>
</html>