<?php 
	include "../includes/helpers.php";
	include '../includes/database.php';
	$db = new Database();
	$db->connect();
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
			<!-- Features -->
				<div id="features-wrapper">
					<div class="container">
						<h2>Select course from here:</h2>
						<div class="row">
						<?php 
							$course_exists 	= $db->select('courses', '*', null, 1);//select all the courses
							if ($course_exists) {
								$course_arrays 	= $db->getResult();
								foreach ($course_arrays as $course_array) {
									$course_name	= $course_array['course_name'];
									$course_id		= $course_array['id'];							
						?>
							<div class="4u 12u(medium)">
								<!-- Box -->
									<section class="box feature">
										<a href="course_paper.php?c=<?php echo $course_id; ?>" style="text-decoration:none;color:grey;">
											<div class="inner" >
												<header>
													<h2><?php echo $course_name; ?></h2>
												</header>
											</div>
										</a>
									</section>
								<!-- end of box -->
							</div>
						<?php 
								}//end of foreach
							}//end of if($course_exists)
						?>
						</div>
					</div>
				</div>


<?php 	include 'tfooter.php';
		$db->disconnect(); 
?>