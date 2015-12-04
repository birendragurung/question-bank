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
			if (!empty($_POST['course']) AND !empty($_POST['level']) AND !empty($_POST['subject']) AND !empty($_POST['year']) AND !empty($_FILES['pdf_file']['name'])) {
				//all the input fields are filled 
				$course 	= $_POST['course'];	//store course id in $course
				$level 		= $_POST['level'];	//store level id in $level
				$subject	= $_POST['subject'];//store subject id in $subject
				$year		= $_POST['year'];
				$paper_file	= $_FILES['pdf_file']['name'];
				$form_error	= '';	// form error message variable changed from the form_validator function
				$fe 		= '';	// form error message variable to pass back to new_paper.php for error handling similar to $form_error // this variable has no use
				$paper_valid= '';	//stores value 1 if form is valid and the paper already exists in the database, stores value 2 if form is valid and the paper doesnot exist in the database
				if ($course == 'NULL') {
					$course = NULL;
				}
				if ($level == 'NULL') {
					$level = NULL;
				}
				if ($subject == 'NULL') {
					$subject = NULL;
				}
				if (!empty($course) AND !empty($level) AND !empty($subject)) {	//form has all the required data
					if ($paper_valid = paper_validator($course, $level, $subject, $year, $paper_file)) {
						//code to do after form is validated
						//if the function returns 1 then paper already exists in the database so update the file
						//else if the function returs 2 then the paper doesnot exist, add to database
					}	//-- end of if(form_validator())
					else{
						// no code here for now.. this page will get displayed with the content of the variable $form_error 
						// logically this will not redirect to the new_paper.php file but will send the html file to the browser with the error message and link to the new_paper.php file with prepopulating values
					}
				}	//	end of if(!empty())
				else{	//	form validator returns false i.e form has invalid data
					$data = '';
					if ($course != NULL) {
						$data .= '&course='.$course;
					}
					if ($level != NULL) {
						$data .= '&level='.$level;
					}
					if ($subject != NULL) {
						$data .= '&subject='.$subject;
					}								
					header('location:new_paper.php?e=2'.$data);	//Incomplete data set
				}
			}
			else{	//some of the fields have not been selected or/and the file is not selected
				$data = '';
				if ($_POST['course'] == 'NULL') {
					$course 	= NULL;
				}
				if ($_POST['level'] == 'NULL') {
					$level 		= NULL;
				}
				if ($_POST['subject'] == 'NULL') {
					$subject 	= NULL;
				}
				if ($_POST['year'] == 'NULL') {
					$year 		= NULL;
				}
				if (!empty($_FILES['pdf_file']['name'])) {
					$pdf_file = $FILES['pdf_file']['name'];
				}
				else{	//pdf file is not uploaded
					$data .= '&f=1';	//file not uploaded
				}
				if (!empty($_POST['course']) AND $_POST['course'] != 'NULL') {
					$course 	= $_POST['course'];	//store course id in $course
				}
				if (!empty($_POST['level']) AND $_POST['level'] != 'NULL') {
					$level 		= $_POST['level'];	//store course id in $course
				}
				if (!empty($_POST['subject']) AND $_POST['subject'] != 'NULL') {
					$subject 	= $_POST['subject'];	//store level id in $level
				}
				if (!empty($_POST['year']) AND $_POST['year'] != 'NULL') {
					$year		= $_POST['year'];//store subject id in $subject
				}				
				if ($course != NULL) {
					$data .= '&course='.$course;
				}
				if ($level != NULL) {
					$data .= '&level='.$level;
				}
				if ($subject != NULL) {
					$data .= '&subject='.$subject;
				}
				if ($year != NULL) {
					$data .= '&year='.$year;
				}
				if ($fe != '') {
					$data .= $fe;	//no use of this 'if' block  for now
				}
				header('location:new_paper.php?e=3'.$data);
			}
		}
		else{//		to forbid direct access without submitting the form
			header('location:new_paper.php?e=1');
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
						 <br> 
				<?php 
					if ($form_error !='') { 
				?>
						<div style="background-color:antiquewhite;border:1px solid lightgrey;padding-left: 20px;padding-bottom: 15px;line-height: 15px;"><?php echo $form_error; ?></div>
					<?php
						$data 		= '';
						$course 	= $_POST['course'];	//store course id in $course
						$level 		= $_POST['level'];	//store level id in $level
						$subject	= $_POST['subject'];//store subject id in $subject
						$year		= $_POST['year'];
						if (!empty($_POST['course']) AND $_POST['course'] != 'NULL') {
							$course 	= $_POST['course'];	//store course id in $course
						}
						if (!empty($_POST['level']) AND $_POST['level'] != 'NULL') {
							$level 		= $_POST['level'];	//store course id in $course
						}
						if (!empty($_POST['subject']) AND $_POST['subject'] != 'NULL') {
							$subject 	= $_POST['subject'];	//store level id in $level
						}
						if (!empty($_POST['year']) AND $_POST['year'] != 'NULL') {
							$year		= $_POST['year'];//store subject id in $subject
						}				
						if ($course != NULL) {
							$data .= '&course='.$course;
						}
						if ($level != NULL) {
							$data .= '&level='.$level;
						}
						if ($subject != NULL) {
							$data .= '&subject='.$subject;
						}
						if ($year != NULL) {
							$data .= '&year='.$year;
						}
					?>
					<a href="<?php echo base_url().'admin/new_paper.php?'.$data; ?>">Go back to form</a>
				<?php 
					}
					else{//there is no form error ie the form data are valid data
						if ($paper_valid == 1) {//$paper_valid = 1 is returned from helper paper_validator() function
							$course_id	= $_POST['course'];
							$level_id	= $_POST['level'];
							$subject_id	= $_POST['subject'];
							$year		= $_POST['year'];
							$sql 		= "SELECT * FROM papers WHERE course_id =" . $course_id . " AND level_id = " . $level_id . " AND sub_id = ". $subject_id ." AND year = " . $year;
							$db 		= new Database;
							$db->connect();
							$paper_details = $db->query($sql);
							$paper_id  	= $paper_details->fetch_object()->id;
							echo '<h3>The paper already exixts. Do you want to update?</h3><br><br>  <a href="update_paper.php?id=' . $paper_id . '" title="" style = 
																												"-moz-transition: background-color .25s ease-in-out;
																												 -webkit-transition: background-color .25s ease-in-out;
																												 -ms-transition: background-color .25s ease-in-out; 
																												 transition: background-color .25s ease-in-out;
																												 -webkit-appearance: none; position: relative;
																												 display: inline-block; 
																												 background: #0090c5; 
																												 color: #fff; text-decoration: none;
																												 border-radius: 6px; 
																												 font-weight: 800; 
																												 outline: 0; 
																												 border: 0; 
																												 cursor: pointer; 
																												 font-size: 1.35em; 
																												 margin-bottom:10px;
																												 padding: 0.6em 1.5em;" 
																											>Yes</a>';
							echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="new_paper.php" title="" style =	
																		"-moz-transition: background-color .25s ease-in-out;
																		 -webkit-transition: background-color .25s ease-in-out;
																		 -ms-transition: background-color .25s ease-in-out; 
																		 transition: background-color .25s ease-in-out;
																		 -webkit-appearance: none; position: relative;
																		 display: inline-block; 
																		 background: #0090c5; 
																		 color: #fff; text-decoration: none;
																		 border-radius: 6px; 
																		 font-weight: 800; 
																		 outline: 0; 
																		 border: 0; 
																		 cursor: pointer; 
																		 font-size: 1.35em; 
																		 margin-bottom:10px;
																		 padding: 0.6em 1.5em;" 
																	>Cancel</a>';

							$db->disconnect();
						}
						else{	//
							$course_id	= $_POST['course'];
							$level_id	= $_POST['level'];
							$subject_id	= $_POST['subject'];
							$year		= $_POST['year'];
							$upload_id	= uploader();	//uploaded() function returns the id of the paper from the database if the paper is saved successfully,else returns false
							if ($upload_id) {
								//show the details of the uploaded file with the details below:
								echo '<br>File successfully uploaded.';
								$conn 			= new Database();
								$conn->connect();
								$sql 			= "SELECT * FROM courses WHERE  id = ". $course_id;
								$course_obj 	= $conn->query($sql);
								$course_name 	= $course_obj->fetch_object()->course_name;
								$sql 			= "SELECT * FROM levels WHERE  id = ". $level_id;
								$level_obj 		= $conn->query($sql);
								$level_name 	= $level_obj->fetch_object()->level_name;
								$sql 			= "SELECT * FROM subjects WHERE  id = ". $subject_id;
								$subject_obj 	= $conn->query($sql);
								$subject_name 	= $subject_obj->fetch_object()->sub_name;
								$sql			= "SELECT location FROM papers WHERE id = " . $upload_id;
								$location 		= $conn->query($sql)->fetch_object()->location;
							?>
						<form action="">
							<br>Courses:<br><input disabled style = "margin-top:5px;padding-left:10px;" type="text" value="<?php echo $course_name; ?>">
							<br>Level:<br><input disabled style = "margin-top:5px;padding-left:10px;" type="text" value="<?php echo $level_name; ?>">
							<br>Subject:<br><input disabled style = "margin-top:5px;padding-left:10px;"  type="text" value="<?php echo $subject_name; ?>">
							<br>Year:<br><input disabled style = "margin-top:5px;padding-left:10px;" type="text" value="<?php echo $year; ?>">
							<br>Location:<br><input disabled style = "margin-top:5px;padding-left:10px;" type="text" value="<?php echo $location; ?>">
							<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="new_paper.php">Upload again</a>
						</form>
							<?php
							}	//end of if($upload_id)
							else{
								echo '<br>Failed to save file';
								echo '<a href="new_paper.php" title="">Go back</a>';
							}
						}
					}
				?>
					</article>
				</div>
			</div>
		</div>
	</div>
</div>
<?php include 'tfooter.php'; ?>