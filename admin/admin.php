<?php  
	session_start();
	include '../includes/database.php';
	$error 	= '';
	if (!empty($_POST)) {
		if (isset($_POST['login'])) {
			if (!empty($_POST['username']) AND !empty($_POST['password'])) {
				$username 	= $_POST['username'];
				$password 	= $_POST['password'];
				$db 		= new Database;
				$db->connect();
				$user_exists= $db->select('admin_panel', '*', null, 'username=' . "'" . $username . "' AND password=" . "'" . $password . "'");
				$user_array	= $db->getResult();
				if (!empty($user_array)) {
					$_SESSION['user']	 = $username;
					header('location:welcome.php');
				}
				else{
					$error 	.= '<br>Username doesnot exist';
					header('location:login.php?e=3');
				}
			}
			else{
				$error 	.= '<br>Login form incomplete';
				header('location:login.php?e=2');
			}			
		}
		else{
			$error 	.= '<br>Login form not submitted';
			header('location:login.php?e=1');
		}
	}
?>