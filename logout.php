<?php
	session_start();

	if (!isset($_SESSION['userSession'])) {
	 header("Location: index.php");
	} else if (isset($_SESSION['userSession'])!="") {
	 header("Location: home.php");
	}

	//deleting cookie by setting expire to past time
	$res = setcookie('user', '', time() - 3600);

	if (isset($_GET['logout'])) {
		//destroy al session variables
		session_destroy();
		unset($_SESSION['userSession']);
		header("Location: index.php");
	}
?>