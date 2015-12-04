<?php  
	$fileList 			 	= get_included_files();
	$parentFile 		 	= $fileList[0];
	$title 				 	= getTitle($parentFile);
	$current_course_code 	= ''; //variable for holding the name of current course
	$welcome 				= 'current';
	if ($title == 'COURSE_PAPER') {
		$course_paper 	= 1;
		if (!empty($_GET)) {
			if (!empty($_GET['c']) ){
				//valid course is selected
				switch ($_GET['c']) {
					case 'SLC':
						$current_course_code 	= "SLC";
						$welcome 				= '';
						break;

					case 'COMMERCE':
						$current_course_code 	= "COMMERCE";
						$welcome 				= '';
						break;

					case 'SCIENCE':
						$current_course_code 	= "SCIENCE";
						$welcome 				= '';
						break;

					case 'BBA':
						$current_course_code 	= "BBA";
						$welcome 				= '';
						break;

					case 'CSIT':
						$current_course_code 	= "CSIT";
						$welcome 				= '';
						break;
					
					default:
						// $error .= '<br> Course not valid or could not be found.';
						break;
				}
			}
		}
	}
?>
	<!-- section after the body tag -->
		<div id="page-wrapper">

			<!-- Header -->
				<div id="header-wrapper">
					<header id="header" class="container">

						<!-- Logo -->
							<div id="logo">
								<h1><a href="welcome.php">Question</a></h1>
								<span>Bank</span>
							</div>

						<!-- Nav -->
							<nav id="nav">
								<ul>
									<li class="<?php echo $welcome; ?>"><a href="welcome.php">Welcome</a></li>
									<?php 
										$db 			= new Database();
										$db->connect();
										$course_query 	= $db->select('courses', '*' , null, 1);
										$course_array 	= $db->getResult();
										$course_count 	= $db->numRows();//stores the no. of courses returned in above query
										for ($i=0; $i < $course_count ; $i++) { 
											if ($course_array[$i]['course_code'] == $current_course_code) {
												$current_course_class	= 'current';
											}
											else{
												$current_course_class 	= '';
											}
											echo '<li class = " ' . $current_course_class . ' "> <a href="course_paper.php?c=' . $course_array[$i]['course_code'] . '" title="">' . $course_array[$i]['course_code']. '</a>';
										}
									?>
								</ul>
							</nav>

					</header>
				</div>
			<!-- end of header -->
			<!--========================-->
