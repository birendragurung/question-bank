<?php 
		session_start();
		$parent_file_name = __FILE__;
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
					<h3>Add a new paper</h3>
				<?php
					if (!empty($_GET)) {	//$_GET data are passed as errors from insert.php after submitting the form below
						echo '<div style = "border:1px solid lightgrey;padding-left:10px;margin-bottom:20px;background-color:antiquewhite;">';
						$error = '';
						if (!empty($_GET['e'])) {
							switch ($_GET['e']) {
								case '1':
									$error .= 'Please select data from here';
									break;
								case '2':
									$error .=  'Incomplete data set. Please select data<br>';
									break;
								case '3':
									$error .= 'Invalid data set.';
									break;
								default:
									$error .=  '';
									break;
							}
						}
						if (!empty($_GET['f'])) {
							if ($_GET['f']==1) {
								$error .= ' File not chosen. Please chose a pdf file for new paper';
							}
						}
						echo $error;
						if (!empty($form_error) ) { 
							echo $form_error; 
						} 
						echo '</div>';
					}
				?>

					<form action="insert_paper.php" method="post" enctype="multipart/form-data">
						<select name="course" id="">
							<?php
							if(!empty($_GET)){
								if(!empty($_GET['course'])){
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
								}
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
								if(!empty($_GET['level'])){
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
								}
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
						<select name="subject" id="">
							<?php
							if(!empty($_GET)){
								if (!empty($_GET['subject'])) { 
							?>
								<option value="<?php echo($_GET['subject']); ?>">
										<?php 	$subject 		= $_GET['subject'];
												$subject_row 	= $db->query("SELECT sub_name FROM subjects WHERE id = $subject"); 
												$subject 		= $subject_row->fetch_assoc(); 
												echo $subject['sub_name']; 
										?>
								</option>							 
							<?php 
								}	//end of if($_GET'[])
								else{
									echo '<option value="NULL">--Select subject--</option>';
								}
							}	//end of if(!empty($_GET))
								else{ 
							?>
								<option value="NULL">--Select subject--</option>
							<?php 
								} 	//end of else
							?>
							<?php
							$subjects_obj = $db->query("SELECT * FROM subjects");
								if ($subjects_obj->num_rows >0) {
									while ($subject = $subjects_obj->fetch_assoc()) {
										echo '<option value="'. $subject['id'].'">'. $subject['sub_name'].'</option>';
									}
								}
							?>
						</select><br>
						<select name="year" id="">
							<?php
							if(!empty($_GET)){
								if(!empty($_GET['year'])){
									if ($_GET['year']) { 
								?>
									<option value="<?php echo($_GET['year']); ?>">
											<?php 	$year 	= $_GET['year'];
													echo $year; 
											?>
									</option>							 
								<?php 
									}	//end of if($_GET'[])
								}
								else{
									echo '<option value="NULL">--Select year--</option>';
								}
							}	//end of if(!empty($_GET))
							else{ 
							?>
								<option value="NULL">--Select year--</option>
							<?php 
							} 	//end of else
							?>
							<script>
								  var myDate = new Date();
								  var year = myDate.getFullYear() + 57;
								  for(var i = 2050 ; i < year+1; i++){
									  document.write('<option value="'+i+'">'+i+'</option>');
								  }
							</script>
						</select><br>
						<input type="file" name="pdf_file" accept="application/pdf"><br><br>
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