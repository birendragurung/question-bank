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
		<!--[if lte IE 8]><script src="<?php echo base_url(); ?>assets/js/ie/html5shiv.js"></script><![endif]-->
		<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/main.css" />
		<link rel="icon" href="<?php echo base_url(); ?>images/favicon.png" type="image/x-icon">
		<!--[if lte IE 8]><link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/ie8.css" /><![endif]-->
	</head>
	<body class="left-sidebar">
<?php include 'theader.php'; ?>

<div id="main-wrapper">
	<div class="container">
	
		<!-- left sidebar -->

			<div class="row 200%">
				<div class="4u 12u$(medium)">
					<?php include 'sidebar.php'; ?>
				</div>
							
		<!-- end of left sidebar -->
				<div class="8u 12u$(medium) important(medium)">
					<div id="content">

						<!-- Content -->
							<article>
								<h3>Add a new subject</h3>
							<?php
								if (!empty($_GET)) {	//$_GET data are passed as errors from insert_paper.php after submitting the form below
									echo '<div style = "border:1px solid lightgrey;padding-left:10px;margin-bottom:20px;background-color:antiquewhite;">';
									$error = '';
									if (!empty($_GET['e'])) {
										switch ($_GET['e']) {
											case '1':
												$error .= 'Please select data from here';
												break;
											case '2':
												$error .= 'Incomplete data set. Please select data<br>';
												break;
											case '3':
												$error .= 'Invalid data set.';
												break;
											default:
												$error .=  '';
												break;
										}
									}
									echo $error;
									if (!empty($form_error) ) { 
										echo $form_error; 
									} 
									echo '</div>';
								}
							?>

								<form action="insert_subject.php" method="post" >
									<select name="course" id="">
										<?php
										if(!empty($_GET)){
											if ($_GET['course']) { 
										?>
											<option value="<?php echo($_GET['course']); ?>">
													<?php 	$course 	= $_GET['course'];
															$course_row = $db->query("SELECT course_name FROM courses WHERE id = $course"); 
															$course 	= $course_row->fetch_assoc(); 
															echo $course['course_name']; 
													?>
											</option>							 
										<?php 
											}	//end of if($_GET'[])
											else{
												echo '<option value="NULL">--Select course--</option>';
											}
										}	//end of if(!empty($_GET))
											else{ 
										?>
											<option value="NULL">--Select course--</option>
										<?php 
											} 	//end of else
										?>
										<?php 
											$courses_obj = $db->query("SELECT * FROM courses");
											if ($courses_obj->num_rows > 0) {
												while ($course = $courses_obj->fetch_assoc()) {							
													echo '<option value="'.$course['id'].'">'.strtoupper($course['course_name']).'</option>';
												}
											}
										?>
									</select>
									<br>
									<select name="level" id="">
										<?php
										if (!empty($_GET)) {							
											if ($_GET['level']) { 
										?>
											<option value="<?php echo($_GET['level']); ?>">
													<?php 	$level 		= $_GET['level'];
															$level_row 	= $db->query("SELECT level_name FROM levels WHERE id = $level"); 
															$level 		= $level_row->fetch_assoc(); 
															echo $level['level_name']; 
													?>
											</option>							 
										<?php 
											}	//end of if($_GET'[])
											else{
												echo '<option value="NULL">--Select level--</option>';
											}
										}	//end of if(!empty($_GET))
											else{ 
										?>
											<option value="NULL">--Select level--</option>
										<?php 
											} 	//end of else
										?>
										<?php 
											$levels_obj = $db->query("SELECT * FROM levels");
											if ($levels_obj->num_rows >0) {
												while ($level = $levels_obj->fetch_assoc()) {
													echo '<option value="'. $level['id'].'">'. $level['level_name'].'</option>';
												}
											}
										?>
									</select>
									<br>
									<?php 
										if (!empty($_GET)) {
											if(!empty($_GET['subject_code'])){
									?>
										<input type="text" name="subject_code" value="<?php echo $_GET['subject_code']; ?>"><br>
									<?php		
											}
											else{
									?>
										<input type="text" name="subject_code" placeholder="Enter subject code"><br>
									<?php
											}
										} 
										else{
									?>
										<input type="text" name="subject_code" placeholder="Enter subject code"><br>
									<?php
										}
									?>
									<?php 
										if (!empty($_GET)) {
											if(!empty($_GET['subject_name'])){
									?>
										<input type="text" name="subject_name" value="<?php echo $_GET['subject_name']; ?>"><br>
									<?php		
											}else{
									?>
										<input type="text" name="subject_name" placeholder="Enter subject name"><br>
									<?php
											}
										} 
										else{
									?>
										<input type="text" name="subject_name" placeholder="Enter subject name"><br>
									<?php
										}
									?>
									<input type="submit" value="Submit" name="submit">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="reset">
								</form>
							</article>
							<!-- end of article section -->
					</div>
				</div>
			</div>
		</div>
	</div>
<?php include 'tfooter.php'; 
$db->disconnect();?>