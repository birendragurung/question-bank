<?php 
		session_start();
		include "../includes/helpers.php";
		if (!isset($_SESSION['user'])){
			header('location:login.php');
		}
		include '../includes/database.php';
		// $db = new Database();
		// $db->connect();	
		if (isset($_POST['submit'])) {
			if (!empty($_POST['course']) AND !empty($_POST['level']) AND !empty($_POST['subject_name']) AND !empty($_POST['subject_code']) ) {
				$course_id		= $_POST['course'];	//store course id in $course
				$level_id 		= $_POST['level'];	//store level id in $level
				$subject_name	= $_POST['subject_name'];//store subject id in $subject
				$subject_code	= $_POST['subject_code'];//stores  subject code
				$form_error	= '';	// form error message variable changed from the form_validator function
				$paper_valid= '';
				if ($course_id == 'NULL') {
					$course = NULL;
				}
				if ($level_id == 'NULL') {
					$level = NULL;
				}
				if ($subject_name == 'NULL') {
					$subject_name = NULL;
				}
				if ($subject_code == 'NULL') {
					$subject_code = NULL;
				}
				if (!empty($course_id) AND !empty($level_id) AND !empty($subject_name) AND !empty($subject_code)) {	//form has all the required data
					if ($subject_valid = subject_validator($course_id, $level_id, $subject_name, $subject_code)) {
						//code to do after form is validated
						//
						//
					}	//-- end of if(form_validator())
					else{
						// no code here for now.. this page will get displayed with the content of the variable $form_error 
						// logically this will not redirect to the new_paper.php file but will send the html file to the browser with the error message and link to the new_paper.php file with prepopulating values
					}
				}	//	end of if(!empty())
				else{	//	form validator returns false i.e form has invalid data
					$data = '';
					if ($course_id != NULL) {
						$data .= '&course='.$course_id;
					}
					if ($level_id != NULL) {
						$data .= '&level='.$level_id;
					}
					if ($subject_code != NULL) {
						$data .= '&subject='.$subject_code;
					}								
					header('location:new_subject.php?e=2'.$data);	//Incomplete data set
				}
			}
			else{	//some of the fields have not been selected or/and the file is not selected
				$data = '';
				if ($_POST['course'] == 'NULL') {
					$course_id	= NULL;
				}
				if ($_POST['level'] == 'NULL') {
					$level_id 		= NULL;
				}
				if ($_POST['subject_name'] == '') {
					$subject_name 	= NULL;
				}
				if ($_POST['subject_code'] == '') {
					$subject_code	= NULL;
				}
				if (!empty($_POST['course']) AND $_POST['course'] != 'NULL') {
					$course_id 	= $_POST['course'];	//store course id in $course
				}
				if (!empty($_POST['level']) AND $_POST['level'] != 'NULL') {
					$level_id	= $_POST['level'];	//store course id in $course
				}
				if (!empty($_POST['subject_code']) AND $_POST['subject_code'] != 'NULL') {
					$subject_code = $_POST['subject'];	//store level id in $level
				}
				if (!empty($_POST['subject_name']) AND $_POST['subject_name'] != 'NULL') {
					$subject_name= $_POST['year'];//store subject id in $subject
				}				
				if ($course_id != NULL) {
					$data .= '&course='.$course_id;
				}
				if ($level_id != NULL) {
					$data .= '&level='.$level_id;
				}
				if ($subject_name != NULL) {
					$data .= '&subject_name='.$subject_name;
				}
				if ($subject_code != NULL) {
					$data .= '&subject_code='.$subject_code;
				}
				if ($fe != '') {
					$data .= $fe;	//no use of this if block  for now
				}
				header('location:new_subject.php?e=3'.$data);
			}
		}
		else{//		to forbid direct access without submitting the form
			header('location:new_subject.php?e=1');
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
	</head>
	<body class="left-sidebar">
<?php include 'theader.php'; ?>
<!-- Main wrapper -->
<div id="main-wrapper">
	<div class="container">
		<div class="row 200%">
			<div class="4u 12u$(medium)">
				<?php include 'sidebar.php'; ?>
			</div>
		<!-- Content -->
			<div class="8u 12u$(medium) important(medium)">
				<div id="content">
					<article>
						content area for the insert page where the data inserted is shown <br> 
				<?php 
					if ($form_error != '') { 
						//there is some validation error in the new subject 
				?>
						<div style="background-color:antiquewhite;border:1px solid lightgrey;padding-left: 20px;padding-bottom: 15px;line-height: 15px;">
							<?php echo $form_error; ?>
						</div>
					<?php
						$data 			= '';
						$course 		= $_POST['course'];	//store course id in $course
						$level 			= $_POST['level'];	//store level id in $level
						$subject_name	= $_POST['subject_name'];//store subject id in $subject
						$subject_code	= $_POST['subject_code'];
						if (!empty($_POST['course']) AND $_POST['course'] != 'NULL') {
							$course_id 	= $_POST['course'];	//store course id in $course
						}
						if (!empty($_POST['level']) AND $_POST['level'] != 'NULL') {
							$level_id 		= $_POST['level'];	//store course id in $course
						}
						if (!empty($_POST['subject_code']) AND $_POST['subject_code'] != 'NULL') {
							$subject_code 	= $_POST['subject_code'];	//store level id in $level
						}
						if (!empty($_POST['subject_name']) AND $_POST['subject_name'] != 'NULL') {
							$subject_name		= $_POST['subject_name'];//store subject id in $subject
						}				
						if ($course != NULL) {
							$data .= '&course='.$course;
						}
						if ($level != NULL) {
							$data .= '&level='.$level;
						}
						if ($subject_name != NULL) {
							$data .= '&subject_name='.$subject_name;
						}
						if ($subject_code != NULL) {
							$data .= '&subject_code='.$subject_code;
						}
					?>
					<a href="<?php echo base_url().'admin/new_subject.php?'.$data; ?>">Go back to form</a>
				<?php 
					}
					else{
						//no form error occured.. ie subject successfully added to the database
						echo 'New subject added to database';
					}
				?>
					</article>
				</div>
			</div>
		</div>
	</div>
</div>
<?php include 'tfooter.php'; ?>