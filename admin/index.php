<?php 
	if (isset($_SESSION['user'])) {
		header('location:welcome.php');
	}
	else{
		header('location:login.php');
	}
?>