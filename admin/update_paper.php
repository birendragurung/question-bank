<?php  
 /**
 * updates the file that are already existing in the database
 */
 session_start();
 if (!isset($_SESSION['user'])) {
 	header('location:login.php');
 }
 include '../includes/database.php';
 include '../includes/helpers.php';
 $error = '';
 if (!empty($_GET) OR !empty($_POST)) {//getting id from source file
 	if (!empty($_GET['id'])) {
 		$paper_id 	= $_GET['id'];
 	}
 	elseif(!empty($_GET['re'])){
 		//allow to enter to this script
 		$paper_id 	= $_GET['id'];
 	}
 	elseif(!empty($_POST['submit']) &!empty($_FILES)){
 		//allow to enter to this script
 		$paper_id 	= $_POST['id'];
 	}
 	elseif(!empty($_POST['submit']) & empty($_FILES)){
 		//allow to enter to this script
 		$paper_id 	= $_POST['id'];
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
		<!--[if lte IE 8]><script src="<?php echo base_url(); ?>assets/js/ie/html5shiv.js"></script><![endif]-->
		<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/main.css" />
		<link rel="icon" href="<?php echo base_url(); ?>images/favicon.png" type="image/x-icon">
		<!--[if lte IE 8]><link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/ie8.css" /><![endif]-->
	</head>
	<body class="homepage">
		<?php include 'theader.php'; ?>
				<div id="main-wrapper">
					<div class="container">
						<div class="row 200%">
								<div class="4u 12u$(medium)">
									<?php include 'sidebar.php'; ?>
								</div>
						<!-- Content -->
							<div class="8u 12u$(medium) important(medium)">
								<div id="content">
									<!-- Content -->
										<article>
											<?php 
											if(empty($_POST)){//entering the script directly from other file with get method where id of the paper is passed to this script
												if (empty($_GET['re']) ) {
													echo '<br><h3>Please choose the file for update</h3>';
													$db 			= new Database();
													$db->connect();
													$paper_exists	= $db->select('papers', '*', null, 'id = '. $paper_id);
													if($paper_exists){
															//paper exists and is unique
															$paper_array 	= $db->getResult();
															$subject_id		= $paper_array[0]['sub_id'];
															//check if subject exists in db
															if ($db->select('subjects', '*', null , 'id = '.$subject_id)) {
																//subject id for generating subject info
																$subject_array 	= $db->getResult();
																$subject_name	= $subject_array[0]['sub_name'];
																$subject_code	= $subject_array[0]['sub_code'];
															}
															else{
																$error .= '<br> subject not in database';
															}
															//check if course exist in db
															$course_id 		= $paper_array[0]['course_id'];
															if ($db->select('courses', '*', null , 'id = ' . $course_id)) {
																//course exists in database
																$course_array	= $db->getResult();
																$course_name 	= $course_array[0]['course_name'];
																$course_code 	= $course_array[0]['course_code'];
															}
															else{
																//course is not in database
																$error .= '<br>Course not found in database';
															}
															//check if level exist in db
															$level_id 		= $paper_array[0]['level_id'];
															if ($db->select('levels', '*', null , 'id = ' . $level_id)) {
																//course exists in database
																$level_array	= $db->getResult();
																$level_name 	= $level_array[0]['level_name'];
																$level_code 	= $level_array[0]['level_id'];
															}
															else{
																//course is not in database
																$error .= '<br>Level not found in database';
															}
													}
													else{
														//paper not in database
														$error	.= '<br>Paper not found in database';
													}
													if ($error == '') {//then show update form
											?>
											<form action="update_paper.php" method="post" enctype="multipart/form-data">
												<input type="hidden" name="id" value="<?php echo $paper_id; ?>">
												<input disabled type="text" value="Course Name : <?php echo $course_name; ?>" style = "margin-bottom:10px" >
												<input disabled type="text" value="Course Code : <?php echo $course_code; ?>" style = "margin-bottom:10px">
												<input disabled type="text" value="Level Name : <?php echo $level_name; ?>" style = "margin-bottom:10px">
												<input disabled type="text" value="Level Code : <?php echo $level_code; ?>" style = "margin-bottom:10px">
												<input disabled type="text" value="Subject Name : <?php echo $subject_name; ?>" style = "margin-bottom:10px">
												<input disabled type="text" value="Subject Code : <?php echo $subject_code; ?>" style = "margin-bottom:10px">
												<input type="file" name="new_file" accept="application/pdf" style = "margin-bottom:10px">
												<input type="submit" name="submit" value="Update" style = "margin-bottom:10px; ">
												<input type="reset" value="Reset" style = "margin-bottom:10px; float:right;">
											</form>


											<?php
													}// end of if($error == '')
													else{
														//there is some error
														echo $error;
													}
												}// end of if empty $_get['re']
												else{
													//it is a resubmission case and it will be handled by the code later below
												}

											}//end of if(empty($_POST))
											else{
												//form submitted by post method
												//file upload form to be displayed
												if (isset($_POST['submit'])) {
													//form has been submitted
													if ($_FILES['new_file']['tmp_name'] != '') {
														//files has been sent to server for verification from the form
														//check for file validation
														if (updater($paper_id)) {
															//file successfully uploaded through the updater helper
															//from here file is sent to updater helper for verifying and saving file
															echo '<br>file successfully updated';
															//show the updated info of the paper
															$db 			= new Database();
															$db->connect();
															$paper_exists	= $db->select('papers', '*', null, 'id = '. $paper_id);
															if($paper_exists){
																//paper exists and is unique
																$paper_array 	= $db->getResult();
																$subject_id		= $paper_array[0]['sub_id'];
																//check if subject exists in db
																if ($db->select('subjects', '*', null , 'id = '.$subject_id)) {
																	//subject id for generating subject info
																	$subject_array 	= $db->getResult();
																	$subject_name	= $subject_array[0]['sub_name'];
																	$subject_code	= $subject_array[0]['sub_code'];
																}
																else{
																	$error .= '<br> subject not in database';
																}
																//check if course exist in db
																$course_id 		= $paper_array[0]['course_id'];
																if ($db->select('courses', '*', null , 'id = ' . $course_id)) {
																	//course exists in database
																	$course_array	= $db->getResult();
																	$course_name 	= $course_array[0]['course_name'];
																	$course_code 	= $course_array[0]['course_code'];
																}
																else{
																	//course is not in database
																	$error .= '<br>Course not found in database';
																}
																//check if level exist in db
																$level_id 		= $paper_array[0]['level_id'];
																if ($db->select('levels', '*', null , 'id = ' . $level_id)) {
																	//course exists in database
																	$level_array	= $db->getResult();
																	$level_name 	= $level_array[0]['level_name'];
																	$level_code 	= $level_array[0]['level_id'];
																}
																else{
																	//course is not in database
																	$error .= '<br>Level not found in database';
																}
															}
											?>	
														<h3>Paper details</h3>
														<form action="#">
															<input type="hidden" name="id" value="<?php echo $paper_id; ?>"><br>
															<input disabled type="text" value="Course Name : <?php echo $course_name; ?>" style = "margin-bottom:10px" >	
															<input disabled type="text" value="Course Code : <?php echo $course_code; ?>" style = "margin-bottom:10px">
															<input disabled type="text" value="Level Name : <?php echo $level_name; ?>" style = "margin-bottom:10px">
															<input disabled type="text" value="Level Code : <?php echo $level_code; ?>" style = "margin-bottom:10px">
															<input disabled type="text" value="Subject Name : <?php echo $subject_name; ?>" style = "margin-bottom:10px">
															<input disabled type="text" value="Subject Code : <?php echo $subject_code; ?>" style = "margin-bottom:10px">
														</form>
											<?php
														}
														else{
															echo $error;
															echo '<br><a href="update_paper.php?re=1&id=' . $paper_id . '" title="">Try again</a>';
														}
													}
													else{
														//no file is chosen in the form
														$error .= '<br>No file chosen';
														echo $error;
														echo '<br><a href="update_paper.php?re=1&id=' . $paper_id . '" title="">Try again</a>';
													}
												}
												else{
													//form not submitted
													$error	.= '<br>Form not submitted';
												}
											}//end of else
											if (!empty($_GET)) {
												if (!empty($_GET['re'])) {//check for re-submission
													echo '<h4>Please choose file carefully (*include pdf files only size< 8MB)</h4>';
													$paper_id = $_GET['id'];
													$db 			= new Database();
													$db->connect();
													$paper_exists	= $db->select('papers', '*', null, 'id = '. $paper_id);
													if($paper_exists){
															//paper exists and is unique
															$paper_array 	= $db->getResult();
															$subject_id		= $paper_array[0]['sub_id'];
															//check if subject exists in db
															if ($db->select('subjects', '*', null , 'id = '.$subject_id)) {
																//subject id for generating subject info
																$subject_array 	= $db->getResult();
																$subject_name	= $subject_array[0]['sub_name'];
																$subject_code	= $subject_array[0]['sub_code'];
															}
															else{
																$error .= '<br> subject not in database';
															}
															//check if course exist in db
															$course_id 		= $paper_array[0]['course_id'];
															if ($db->select('courses', '*', null , 'id = ' . $course_id)) {
																//course exists in database
																$course_array	= $db->getResult();
																$course_name 	= $course_array[0]['course_name'];
																$course_code 	= $course_array[0]['course_code'];
															}
															else{
																//course is not in database
																$error .= '<br>Course not found in database';
															}
															//check if level exist in db
															$level_id 		= $paper_array[0]['level_id'];
															if ($db->select('levels', '*', null , 'id = ' . $level_id)) {
																//course exists in database
																$level_array	= $db->getResult();
																$level_name 	= $level_array[0]['level_name'];
																$level_code 	= $level_array[0]['level_id'];
															}
															else{
																//course is not in database
																$error .= '<br>Level not found in database';
															}
													}
													else{
														//paper not in database
														$error	.= '<br>Paper not found in database';
													}
													if ($error == ''){//then show update form
														
												?>
														<form action="update_paper.php" method="post" enctype="multipart/form-data">
															<input type="hidden" name="id" value="<?php echo $paper_id; ?>">
															<input disabled type="text" value="Course Name : <?php echo $course_name; ?>" style = "margin-bottom:10px" >
															<input disabled type="text" value="Course Code : <?php echo $course_code; ?>" style = "margin-bottom:10px">
															<input disabled type="text" value="Level Name : <?php echo $level_name; ?>" style = "margin-bottom:10px">
															<input disabled type="text" value="Level Code : <?php echo $level_code; ?>" style = "margin-bottom:10px">
															<input disabled type="text" value="Subject Name : <?php echo $subject_name; ?>" style = "margin-bottom:10px">
															<input disabled type="text" value="Subject Code : <?php echo $subject_code; ?>" style = "margin-bottom:10px">
															<input type="file" name="new_file" style = "margin-bottom:10px">
															<input type="submit" name="submit" value = "Update" style = "margin-bottom:10px; ">
															<input type="reset" value="Reset" style = "margin-bottom:10px; float:right;">
														</form>
												<?php 
													}
													else{
														echo "<br>An error encountered";
													}
												}//end if if(!empty($_GET['re']))
											}//end of if(!empty($_GET))
											echo $error;
											?>

										</article>

								</div>
							</div>
						</div>
					</div>
				</div>

<?php include 'tfooter.php'; ?>