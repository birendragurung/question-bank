<?php 
		session_start();
		include "../includes/helpers.php";
		if (!isset($_SESSION['user'])){
			header('location:login.php');
		}
		include '../includes/database.php';
		$db = new Database();
		$error = '';
		$db->connect();	
		if (!empty($_GET)) {
			if (!empty($_GET['id'])) {
				//paper id which is to be deleted 
				$paper_id 	= $_GET['id'];
			}
			else{
				header('location:all_papers.php');
			}
		}
		else{
			header('location:all_papers.php');
		}
?>
<html>
	<head>
		<title><?php echo getTitle(__FILE__); ?></title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<link rel="icon" href="<?php echo base_url(); ?>images/favicon.png" type="image/x-icon">
		<!--[if lte IE 8]><script src="<?php echo base_url(); ?>assets/js/ie/html5shiv.js"></script><![endif]-->
		<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/main.css" />
		<!--[if lte IE 8]><link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/ie8.css" /><![endif]-->
	</head>
	<body class="homepage">
<?php include 'theader.php'; ?>

<div id="main-wrapper">
	<div class="container">
		<div id="content">
			<div class="row 200%">
				<div class="4u 12u$(medium)">
					<?php include 'sidebar.php'; ?>
				</div>

				<div class="8u 12u$(medium) important(medium)">
					<div id="content">
						<!-- Content -->
							<article>
								<?php  
									if (!empty($_GET)) {
										if(!empty($_GET['c'])){// confirm parameter c
											$db = new Database();
											$db->connect();
											$sql = "select * from papers where id = 3";
											$a= $db->query($sql);
											$paper_exists 	= $db->select('papers', '*', null , 'id=' . $paper_id);
											if ($paper_exists) {
												//paper exists in database
												$paper_details 	= $db->getResult();
												if(!empty($paper_details)){
													$paper_location = $paper_details[0]['location'];
													$root_dir 		= 'C:/xampp/htdocs/QuestionBank/';
													$file_location 	= $root_dir.$paper_location;
													if (file_exists($file_location)) {
														//file exists in the database
														if (unlink($file_location)) {
															//file deleted from disk
															//after deleting file from disk, delete record from database
															if ($db->delete('papers', 'id='.$paper_id)) {
																//file record successfully deleted from the database
																echo '<br><h3>File successfully deleted</h3>';
															}
															else{
																//error while deleting record from database
																$error .= '<br>File record could not be deleted from the database';
															}
														}
														else{
															//file not deleted
															$error .= '<br>File could not be deleted';
														}
													}
													else{
														//file does not exist
														$error .= '<br>File does not exist in the directory';
													}
												}
												else{
													$error .= '<br>File already deleted.';
												}
											}
											else{
												//paper does not exist in the database
												$error .= '<br>Paper does not exist in database';
											}
										}
										else{
											//file confirmation not given, so prompt user for file deletion
											echo '<br><h2>Do you want to delete this file?</h2>';
											echo '<br> <a href="delete_paper.php?id='.$paper_id. '&c=1" title=""><input type="button" value="Yes"></a>';
										}
									}
									echo $error;
								?>
							</article>

					</div>
				</div>
			</div>

<?php include 'tfooter.php'; ?>