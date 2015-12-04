<?php  
	$fileList 			 	= get_included_files();
	$parentFile 		 	= $fileList[0];
	$title 				 	= getTitle($parentFile);
	$current_course_id		= ''; //variable for holding the name of current course
	$welcome 				= 'current';
	if ($title == 'COURSE_PAPER') {
		$course_paper 	= 1;
		if (!empty($_GET)) {
			if (!empty($_GET['c']) ){
				//valid course is selected
				switch ($_GET['c']) {
					case '1':
						$current_course_id	 	= 1;
						$welcome 				= '';
						break;

					case '2':
						$current_course_id	 	= 2;
						$welcome 				= '';
						break;

					case '3':
						$current_course_id	 	= 3;
						$welcome 				= '';
						break;

					case '4':
						$current_course_id	 	= 4;
						$welcome 				= '';
						break;

					case '5':
						$current_course_id	 	= 5;
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
											if ($course_array[$i]['id'] == $current_course_id) {
												$current_course_class	= 'current';
											}
											else{
												$current_course_class 	= '';
											}
											echo '<li class = " ' . $current_course_class . ' "> <a href="course_paper.php?c=' . $course_array[$i]['id'] . '" title="">' . $course_array[$i]['course_code']. '</a>';
										}
									?>
								</ul>
							</nav>

					</header>
				</div>
			<!-- end of header -->
			<!--========================-->
