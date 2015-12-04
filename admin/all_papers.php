<?php
	session_start(); 
	include "../includes/helpers.php";
	if (!isset($_SESSION['user'])){
		header('location:login.php');
	}
	include '../includes/database.php';
	$db = new Database();
	$db->connect();	
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
		<style>
			.paper-file{
				display : inline-block;
				margin  : 5px;
				padding : 15px;
				border 	: 1px solid whitesmoke;
			}
		</style>
	</head>
	<body class="homepage">
<?php include 'theader.php'; ?>
		<div id="main-wrapper">
			<div class="container">
				<div id="content">
					<!-- Content -->
						<article>
							<?php  
								if (!empty($_GET)) {
									if (!empty($_GET['e'])) {
										if ($_GET['e'] == 1) {
											echo '<div style = "background-color:antiquewhite;border:1px solid lightgrey;">Please select valid course.</div>';
										}
										elseif($_GET['e'] == 2){
											echo '<div style = "background-color:antiquewhite;border:1px solid lightgrey;">Please select course.</div>';
										}
									}
								}
							?>
							<h2>All papers</h2>

							<?php 
								$sql 		= "SELECT * FROM courses";
								$courses 	= $db->query($sql);
								if ($courses->num_rows > 0){		
									while ($course = $courses->fetch_assoc()) {
										echo('<h4 style="background-color:whitesmoke; padding-left:5px;">'.$course['course_name'].'</h4>');
										$course_id	= $course['id'];
										$sql 		= "SELECT * FROM papers WHERE course_id = $course_id";
										$papers 	= $db->query($sql);
										if ($papers->num_rows > 0) {
											while ($paper = $papers->fetch_assoc()) {
												$paper_id 		= $paper['id'];
												$year			= $paper['year'];
												$lev_id			= $paper['level_id'];
												$level_name		= $db->query("SELECT level_name FROM levels where id = $lev_id");
												$lev_name 		= $level_name->fetch_assoc();
												$sub_id			= $paper['sub_id'];
												$subject_name	= $db->query("SELECT sub_name FROM subjects WHERE id = $sub_id");
												$sub_name 		= $subject_name->fetch_assoc();
							?>
												<div class="paper-file">
													<div class="paper-img" style="display:inline-block;position:relative;">
														<a href="<?php echo base_url(); ?>admin/download.php?id=<?php echo $paper_id; ?>" download><img style="height:30px;position:absolute;right:-10px;top:-10px;" src="<?php echo base_url(); ?>images/download.png" alt=""></a>
														<a href="<?php echo base_url(); ?>admin/download.php?id=<?php echo $paper_id; ?>">
															<img style="margin:5px;height:90px;display:block;" src="<?php echo base_url(); ?>images/dpdf.ico" alt="">
														</a>
														<span style='text-align:centre;'><?php echo strtoupper($sub_name['sub_name']); ?></span><br>
														<span><?php echo($lev_name['level_name'].' '. $year); ?></span>
													</div>
													<br>
													<a href="<?php echo base_url(); ?>admin/update_paper.php?id=<?php echo $paper_id; ?>"><b style="color:#0090c5;">Update paper</b></a><br>
													<a href="<?php echo base_url(); ?>admin/delete_paper.php?id=<?php echo $paper_id; ?>"><b style="color:#0090c5;">Delete paper</b></a>
												</div>
							<?php  	
											}//end of while
										}//end of: if($papers->num_rows)
										else{
											//no papers are there in this course
											echo '<h4 style= "color:grey;padding-left:10px;">No papers are uploaded to this course</h4>';
										}
									}//end of while
							 	}//end of if
							?>
						</article>
				</div>
			</div>
		</div>

<?php include 'tfooter.php'; 
$db->disconnect(); ?>