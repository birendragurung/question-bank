<?php 
	include "../includes/helpers.php";
		include '../includes/database.php';
		$db = new Database();
		$db->connect();
		$error = '';
		$course_code = '';	
		if (!empty($_GET)) {
			if (!empty($_GET['c']) ){
				//valid course is selected
				switch ($_GET['c']) {
					case '1':
						$course_code 	= "SLC";
						break;

					case '2':
						$course_code 	= "SCIENCE";
						break;

					case '3':
						$course_code 	= "COMMERCE";
						break;
					
					case '4':
						$course_code 	= "CSIT";
						break;

					case '5':
						$course_code 	= "BBA";
						break;

					default:
						$error .= '<br> Course not valid or could not be found.';
						break;
				}
			}
			else{
				header('location:all_papers.php?e=1');
			}
		}
		else{
			header('location:all_papers.php?e=2');
		}
?>
<html>
	<head>
		<title><?php echo getTitle(__FILE__); ?></title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<!--[if lte IE 8]><script src="<?php echo base_url(); ?>assets/js/ie/html5shiv.js"></script><![endif]-->
		<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/main.css" />
		<link rel="icon" href="<?php echo base_url(); ?>images/favicon.png" type="image/x-icon">
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
			<div class="row 200%">
				<div id="content">
					<!-- Content -->
						<article>
						<?php 
								if ($error == '') {
									$course_exists 		= $db->select('courses', '*', null, 'course_code='."'". $course_code. "'");
									if ($course_exists) {
										$course_array 	= $db->getResult();
										$course_id 		= intval($course_array[0]['id']);
										$course_name 	= $course_array[0]['course_name'];
										echo '<h3><br>Papers of course: '. $course_name . '</h3>';
										$paper_exists 	= $db->select('papers', '*', null, 'course_id='. $course_id);
										$paper_arrays 	= $db->getResult();
										if (empty($paper_arrays)) {
											echo '<h4>Papers not available</h4>';
										}
										foreach ($paper_arrays as $paper_array) {
											$paper_id 		= $paper_array['id'];
											$paper_year 	= $paper_array['year'];
											//fetching the details of subject of paper
											$subject_id 	= $paper_array['sub_id'];
											$subject_exists = $db->select('subjects', '*', null, 'id='. $subject_id);
											$subject_array 	= $db->getResult();
											$subject_name	= $subject_array[0]['sub_name'];
											//fetching details of level of paper
											$level_id 		= $paper_array['level_id'];
											$level_exists 	= $db->select('levels', '*', null , 'id='. $level_id);
											$level_array	= $db->getResult();
											$level_name 	= $level_array[0]['level_name'];
											
						?>
							<div class="paper-file">
								<div class="paper-img" style="display:inline-block;position:relative;">
									<a href="<?php echo base_url(); ?>admin/download.php?id=<?php echo $paper_id; ?>" download="download"><img style="height:30px;position:absolute;right:-10px;top:-10px;" src="<?php echo base_url(); ?>images/download.png" alt=""></a>
									<a href="<?php echo base_url(); ?>public/download.php?id=<?php echo $paper_id; ?>">
										<img style="margin:5px;height:90px;display:block;" src="<?php echo base_url(); ?>images/dpdf.ico" alt="">
									</a>
									<span style='text-align:centre;'><?php echo strtoupper($subject_name); ?></span><br>
									<span><?php echo($level_name.' '. $paper_year); ?></span>
								</div>
								<br>
							</div>
						<?php
										}//end of foreach
									}//end of if statement
									else{
										//course does not exist in database whose course code is $course_code
										$error 	.= '<br>Course not found in database';
									}
								}
								else{
									//some error occured in getting data
									echo $error;
								}		
						?>
						</article>

				</div>
			</div>
		</div>
	</div>
</div>
<?php include 'tfooter.php'; ?>