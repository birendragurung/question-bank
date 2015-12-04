<?php 
		session_start();
		include "../includes/helpers.php";
		if (!isset($_SESSION['user'])){
			header('location:login.php');
		}	
		include '../includes/database.php';
		// $db = new Database();
		// $db->connect();
?>
<!DOCTYPE HTML>
<html>
	<head>
		<title><?php echo getTitle(__FILE__); ?></title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<!--[if lte IE 8]><script src="<?php echo base_url(); ?>assets/js/ie/html5shiv.js"></script><![endif]-->
		<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/main.css" />
		<link rel="icon" href="<?php echo base_url(); ?>images/favicon.png" type="image/x-icon">
		<!--[if lte IE 8]><link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/ie8.css" /><![endif]-->
	</head>
	<body class="homepage">
<?php include 'theader.php'; ?>
<?php include 'tbanner.php'; ?>

			<!-- Features -->
				<div id="features-wrapper">
					<div class="container">
						<div class="row">
							<div class="4u 12u(medium)">

								<!-- Box -->
									<section class="box feature">
										<a href="update_paper.php" style="text-decoration:none;color:grey;">
											<div class="inner">
												<header>
													<h2>Update paper</h2>
												</header>
											</div>
										</a>
									</section>

							</div>
							<div class="4u 12u(medium)">

								<!-- Box -->
									<section class="box feature">
										<a href="delete_paper.php" style="text-decoration:none;color:grey;">
										<div class="inner">
											<header>
												<h2>Delete paper</h2>
											</header>
										</div>
										</a>
									</section>

							</div>
							<div class="4u 12u(medium)">

								<!-- Box -->
									<section class="box feature">
										<a href="new_subject.php" style="text-decoration:none;color:grey;">
											<div class="inner">
												<header>
													<h2>Add new subject</h2>
												</header>
											</div>
										</a>
									</section>
							</div>
						</div>
					</div>
				</div>


<?php 	include 'tfooter.php';
		// $db->disconnect(); 
?>