<?php
/**
 * this code returns the base url of the site
 */
function base_url() {
	// output: /QuestionBank/index.php
	$currentPath = $_SERVER['PHP_SELF']; // or alternatively $_SERVER['SERVER_NAME'] will generate the same
	
	// output: Array ( [dirname] => /QuestionBank [basename] => index.php [extension] => php [filename] => index ) 
	$pathInfo = pathinfo($currentPath); 
	
	// output: localhost
	$hostName = $_SERVER['HTTP_HOST']; 
	
	// output: http://
	$protocol = strtolower(substr($_SERVER["SERVER_PROTOCOL"],0,5))=='https://'?'https://':'http://';
	
	// return: http://localhost/QuestionBank/
	return $protocol.$hostName.'/QuestionBank/';
}

/**
 *this function uses the filename to generate the title for the site
 */
function getTitle($t){
	$title = explode('\\' , $t);
	$i = 0;
	foreach ($title as $key) {
		$i++;
	}
	$title = strtoupper(substr(($title[$i-1]),0, -4));
	$title = str_replace('_', ' ', $title);
	return $title;
}

/**
 * this function is for checking sessions
 */
function check_session(){

}

/**
 * this function is for form validation
 */
function paper_validator($course_id, $level_id, $subject_id, $year, $paper_file){
	global $form_error;
	$form_error = '';
	$db = new Database();
	$db->connect();
	$sql = "SELECT * FROM courses WHERE id = $course_id";
	$courses_obj = $db->query($sql);
	if ($courses_obj->num_rows > 0) {					
		//if true, it means the course exists in the database
		$course_row = $courses_obj->fetch_array();	
		$sql 		= "SELECT * FROM levels WHERE id = '$level_id'";
		$levels_obj	= $db->query($sql);
		if ($levels_obj->num_rows > 0) {				
			//if true, it means the level exists in the database
			$level_row	= $levels_obj->fetch_assoc();
			$sql	= "SELECT * FROM course_level WHERE course_id = $course_id 	AND level_id = $level_id";
			$course_level = $db->query($sql);
			if ($course_level->num_rows > 0) {		
				//if true, it means the course contains the level
				$sql			= "SELECT * FROM subjects WHERE id = $subject_id";
				$subjects_obj 	= $db->query($sql);
				if ($subjects_obj->num_rows > 0) {	
					//if true, it means the subject is in the database
					$subject_row = $subjects_obj->fetch_array();
					$sql		 = "SELECT * FROM level_subject WHERE level_id = $level_id AND subject_id = $subject_id";
					$level_subject	= $db->query($sql);
					if ($level_subject->num_rows > 0) {	
						//if true, it means the level contains the subject
						//check if the subject paper of the same year is already in the database 
						if ($year < 2050 OR $year > date('Y')+57) {
							// year is invalid
							$error .= '<br> Invalid year';
						}
						else{
							//year is valid...
							$extension = 'pdf';
							$sql	= "SELECT * FROM papers WHERE course_id = $course_id AND level_id = $level_id AND sub_id = $subject_id AND year = '$year'";
							$paper_obj = $db->query($sql);
							if ($paper_obj->num_rows >0) {
								//if true, it means the paper is already present in the database
								//check if the uploaded file is smaller than the maximum allowed size : 10mb = 10000000
								if (preg_match("/$extension\$/i", $_FILES['pdf_file']['name'])) {
									//check if the uploaded file is a pdf file
									if ($_FILES['pdf_file']['size'] < 10000000) {	
										//this means the pdf file is smaller than the maximum allowed file size
										return 1;	// this returned value is manipulated in the including file for update after alerting the user
										//if 1 is returned to the invoking function, then prompt the user to update the file
									}
									else{
										$form_error .= 'The uploaded file is too large.';
									}
								}
								else{
									$form_error .= 'The uploaded file is not a pdf file';
								}
								
							}
							else{		
								//Paper does not exist in the database, so insert into the database after further validation
								//check if the uploaded file is a pdf file or not and then insert in the database
								if (preg_match("/$extension\$/i", $_FILES['pdf_file']['name'])){
									//check if the uploaded file is smaller than the maximum allowed size : 10mb = 10000000 
									if ($_FILES['pdf_file']['size'] < 10000000) {
										return 2;	// this returned value is manipulated in the including file for insertion
										//if 2 is returned, then directly add the paper to database and save file in disk
									}
									else{
										$form_error .= 'The uploaded file is too large.';
									}
								}
								else{
									$form_error .= 'The uploaded file is not a pdf file';
								}
							}// ending else
						}// ending else
						// ending else
					}
					else{
						$level_name = $level_row['level_name'];
						$sub_name 	= $subject_row['sub_name'];
						$form_error .= '<br>The level '."'". $level_name ."'". ' does not contain the subject '."'".$sub_name."'";
						return false;
					}
				}
				else{
					$form_error .= '<br>The subject is not registered in the database';
					return false;
				}
			}
			else{
				$course_name 	= $course_row['course_name'];
				$level_name		= $level_row['level_name'];
				$form_error 	.= '<br>The course '."'".$course_name."'".' doesnot contain the level '."'".$level_name."'";
				return false;

			}
		}
		else{
			$form_error .= '<br>The level is not registered';
			return false;
		}
	}
	else{
		$form_error .= '<br>The course is not registered';
		return false;
	}
}

/**
 * this function uploads the pdf file from the form to the respective directory papers/course/level/filename.pdf
 */
function uploader(){	
	/**
	 * the default max_upload_filesize in php is 2 mb
	 * so if a larger file is to be uploaded then go to php.ini inside xampp/apache and change the value of max_upload_filesize as required 
	 */
	$target_dir = 'C:/xampp/htdocs/QuestionBank/papers/';	//folder where the file is to be stored
	$conn 		= new Database();	//creating new connection
	$conn->connect();	//connecting to the database
	$info 		= pathinfo($_FILES['pdf_file']['name']);	//filename of uploaded file
	$ext 		= '.' . $info['extension']; // get the extension of the file
	$course_id 	= $_POST['course'];
	$level_id	= $_POST['level'];
	$subject_id	= $_POST['subject'];
	$year		= $_POST['year'];
	$sql		= "SELECT course_code FROM courses WHERE id = $course_id";//sql command to fetch the course code for determining the name of the course directory
	$course_code = $conn->query($sql)->fetch_object()->course_code;	//gets the course code of the course from course table in the database
	$target_course_dir = $course_code.'/';
	$paper_name	= '';	//file name of the pdf paper file
	// echo 'direcgtoy name:'. dirname(__FILE__);
	//mkdir($target_dir.$target_course_dir);
	if (!file_exists($target_dir.$target_course_dir) ) {	
		//the course folder doesnot exist...
			// echo ' <br>1. if (!file_exists(' . $target_dir . $target_course_dir . ') ) {';
    	if (mkdir($target_dir.$target_course_dir)) {
    		//new folder for courses created...
	    		// echo '<br>1.1 from helper: Directory for course created : '. $target_dir . $target_course_dir;
    		$sql		= "SELECT level_id FROM levels WHERE id = $level_id";//sql command to fetch the course code for determining the name of the course directory
			$level_code = $conn->query($sql)->fetch_object()->level_id;	//gets the level code of the level from course table in the database
			$target_level_dir = $level_code.'/';
			if(!file_exists($target_dir.$target_course_dir.$level_code)){
				//the level folder doesnot exist...
					// echo '<br>1.1.1 if(!file_exists(' . $target_dir . $target_course_dir . $level_code . ')){}';
				if(mkdir( $target_dir . $target_course_dir . $target_level_dir )){
					//new folder created for the level with level_id = $level_code
						// echo '<br>1.1.1.1   if(mkdir( '.$target_dir . $target_course_dir . $target_level_dir.' )){';
						// echo '<br>Message from helper: Directory for level created : '. $target_dir . $target_course_dir . $target_level_dir;
					$sql			= "SELECT sub_code FROM subjects WHERE id = $subject_id";//sql command to fetch the subject code for determining the filename of the new uploaded file
					$subject_code	= $conn->query($sql)->fetch_object()->sub_code;	//gets the course code of the course from course table in the database
					$paper_name 	= $subject_code . '_' . $year; //name of the pdf file
					$final_location	= $target_dir . $target_course_dir . $target_level_dir . $paper_name . $ext;	//final location of the file
					$file_path		= 'papers/' . $target_course_dir . $target_level_dir . $paper_name . $ext; //path of the file to be stored in the database
					$sql 			= "SELECT location FROM papers WHERE course_id = " . $course_id . " AND level_id = " . $level_id . " AND sub_id = " . $subject_id . "AND location = " . $file_path;
					$file_exists	= ($conn->query($sql))?$conn->query($sql)->fetch_object()->location:false;
					if(!$file_exists){
						//file is not recorded in the database, i.e. the paper doesnot exist in the database
						if(move_uploaded_file($_FILES['pdf_file']['tmp_name'], $final_location ) ){
							//file successfully saved to permanent location
							//now save the file path in the database in location field in table: papers
								// echo "<br>1.1.1.1  if(move_uploaded_file(" . $_FILES['pdf_file']['tmp_name'] . "," .  $target_dir . $target_course_dir . $target_level_dir . $paper_name . "{";
								// echo '<br>Message from helper : File successfully added';
							$paper_details = array(
													'course_id' => $course_id,
													'level_id'	=> $level_id,
													'sub_id'	=> $subject_id,
													'location'	=> $conn->escapeString($file_path),
													'year'		=> $year
													);
							if ($conn->insert('papers' , $paper_details)) {	
									// echo '<br>Message from DB: file saved in database';						
									$insert_id 		= $conn->getResult();//stores the array returned from the database object $conn
									$return_value	= $insert_id[0];	//return value for paper_id
									return $insert_id[0]; //returning the new id of the paper inserted
							}
							else{
									// echo '<br>Message from DB: couldnot insert record into database(file already exists in the database)';
								return false;
							}
							
						}
						else{
								// echo ' <br>1.1.2  Error from helper.php: could not save file ';
							return false;
						}
					}
					else{
							// echo '<br>Warning from helper: File already present in the database';
					}
				}
				else{
					//could not create new directory for levels
						// echo '<br> Error from helper.php:could not create new level folder';
					return false;
				}
			}
			else{
				//the level folder exists
				//move the uploaded file to this folder
					// echo '<br>Message from helper: directory for levels already exists '.$level_code;
				$final_location = $target_dir.$target_course_dir.$target_level_dir;
				$sql			= "SELECT sub_code FROM subjects WHERE id = $subject_id";//sql command to fetch the subject code for determining the filename of the new uploaded file
				$subject_code 	= $conn->query($sql)->fetch_object()->sub_code;	//gets the course code of the course from course table in the database
				$paper_name 	= $subject_code.'_'.$year;  // permanent name of the paper
				$final_location = $target_dir . $target_course_dir . $target_level_dir . $paper_name . $ext ; //final location of the file to be stored in the disk
				$file_path		= 'papers/' . $target_course_dir . $target_level_dir. $paper_name . $ext ; //path of the file to be stored in the database
				$sql 			= "SELECT location FROM papers WHERE course_id = " . $course_id . " AND level_id = " . $level_id . " AND sub_id = " . $subject_id . "AND location = " . $file_path;
				$file_exists	= ($conn->query($sql))?$conn->query($sql)->fetch_object()->location:false;
				if(!$file_exists){
					if(move_uploaded_file($_FILES['pdf_file']['tmp_name'], $final_location)){
						//file successfully saved to permanent location
						//now save the file path in the location field in table: papers
							// echo "<br>1.1.1.1  if(move_uploaded_file(" . $_FILES['pdf_file']['tmp_name'] . "," .  $target_dir . $target_course_dir . $target_level_dir . $paper_name . "{";
							// echo '<br>Message from helper : File successfully saved in disk';
						$paper_details = array(
												'course_id' => $course_id,
												'level_id'	=> $level_id,
												'sub_id'	=> $subject_id,
												'location'	=> $conn->escapeString($file_path),
												'year'		=> $year
												);
						if ($conn->insert('papers' , $paper_details)) {		
								// echo '<br>Message from DB: file saved in database';					
							$insert_id 	= $conn->getResult();//stores the result from the object $conn which is in the form of array
							$return_value	= $insert_array[0];	//return value for paper_id
							return $insert_id; //returning the new id of the paper inserted
						}
						else{
								// echo '<br>Message from DB: couldnot insert record into database(file already exists in the database)';
							return false;
						}
					}
					else{
							// echo ' <br>1.1.2  Error from helper.php: could not save file in disk';
						return false;
					}
				}
			}
    	}
    	else{
    		//the new folder could not be created
	    		// echo '<br>Error from helper:could not create directory for course. '.$target_dir.$target_course_dir;
    		return false;
    	}      
	} 
	else{
		//the course directory already exists...
		//check if the level directory exists or not
			// echo '<br>Message from helper : directory for course exists : '.
		$sql		= "SELECT level_id FROM levels WHERE id = $level_id";//sql command to fetch the course code for determining the name of the course directory
		$level_code = $conn->query($sql)->fetch_object()->level_id;	//gets the level code of the level from level table in the database
		$target_level_dir = $level_code.'/';	//directory name for level
		if(!file_exists($target_dir.$target_course_dir.$target_level_dir)){
			//the level folder doesnot exist
			if(mkdir($final_location = $target_dir.$target_course_dir.$target_level_dir)){
				//new folder created for the level with level_id = $level_code
					// echo '<br>Directory for level exists.';
				$sql			= "SELECT sub_code FROM subjects WHERE id = $subject_id";//sql command to fetch the subject code for determining the filename of the new uploaded file which then concatenates with the year to give the full filename
				$subject_code 	= $conn->query($sql)->fetch_object()->sub_code;	//gets the course code of the course from course table in the database
				$paper_name		= $subject_code . '_' . $year;
				$final_location = $target_dir . $target_course_dir . $target_level_dir . $paper_name . $ext;
				$file_path 		= 'papers/' . $target_course_dir . $target_level_dir . $paper_name . $ext;
				$sql 			= "SELECT location FROM papers WHERE course_id = " . $course_id . " AND level_id = " . $level_id . " AND sub_id = " . $subject_id . "AND location = " . $file_path;
				$file_exists	= ($conn->query($sql))?$conn->query($sql)->fetch_object()->location:false;
				if(!$file_exists){	
					if(move_uploaded_file($_FILES['pdf_file']['tmp_name'], $final_location)){
							// echo '<br>Error from helper: file successfully saved in disk';
						$paper_details = array(
												'course_id' => $course_id,
												'level_id'	=> $level_id,
												'sub_id'	=> $subject_id,
												'location'	=> $conn->escapeString($file_path),
												'year'		=> $year
												);
						if ($conn->insert('papers' , $paper_details)) {		
								// echo '<br>Message from DB: file saved in database';					
							$insert_id 		= $conn->getResult();//stores the result from the database object $conn and is in the form of array
							$return_value	= $insert_id[0];	//return value for paper_id
							return $return_value; //returning the new id of the paper inserted
						}
						else{
								// echo '<br>Message from DB: couldnot insert record into database(file already exists in the database)';
							return false;
						}
					}
					else{
							// echo '<br>Error from helper : file couldnot be added';
						return false;
					}
				}
				else{
						// echo '<br>Message from DB: couldnot insert record into database(file already exists in the database)';
				}
			}
			else{
					// echo '<br>Error from helper:folder could not be created';
				return false;
			}
		}
		else{
			//the level folder exists
			//move the uploaded file to this folder
				// echo '<br>Message from helper : directory for level exists : ';	
			$final_location	= $target_dir . $target_course_dir . $target_level_dir;
			$sql			= "SELECT sub_code FROM subjects WHERE id = $subject_id";//sql command to fetch the subject code for determining the filename of the new uploaded file
			$subject_code 	= $conn->query($sql)->fetch_object()->sub_code;	//gets the course code of the course from course table in the database
			$paper_name	   .=	$subject_code . '_' . $year;
			$final_location = $target_dir . $target_course_dir . $target_level_dir . $paper_name . $ext;
			$file_path 		= 'papers/' . $target_course_dir . $target_level_dir . $paper_name . $ext;
			$sql 			= "SELECT location FROM papers WHERE course_id = " . $course_id . " AND level_id = " . $level_id . " AND sub_id = " . $subject_id . "AND location = " . $file_path;
			$file_exists	= ($conn->query($sql))?$conn->query($sql)->fetch_object()->location:false;
			if(!$file_exists){
				if(move_uploaded_file($_FILES['pdf_file']['tmp_name'], $final_location)){
						// echo '<br>Message from helper: file successfully added';
					$paper_details = array(
											'course_id' => $course_id,
											'level_id'	=> $level_id,
											'sub_id'	=> $subject_id,
											'location'	=> $conn->escapeString($file_path),
											'year'		=> $year
											);
					if ($conn->insert('papers' , $paper_details)) {	
							// echo '<br>Message from DB: file saved in database';						
						$insert_array 	= $conn->getResult();
						$return_value	= $insert_array[0];
						return $return_value; //returning the new id of the paper inserted
					}
					else{
							// echo '<br>Message from DB: couldnot insert record into database';
						return false;
					}
				}
				else{
						// echo '<br>Error from helper : file couldnot be added';
					return false;
				}
			}
			else{
					// echo '<br>Message from helper: File already exists in the database';
			}
		}	
	}
}	//end of function uploader

/**
 * this function checks if the subject name and subject code are valid in order to be recorded in teh database
 * the funcion has no parameters. all the required data are fetched from $_POST
 */
function subject_validator($course_id, $level_id, $subject_name, $subject_code){
	global $form_error;
	$form_error = '';
	$db = new Database();
	$db->connect();
	$subject_code = strtoupper($subject_code);
	$sql = "SELECT * FROM courses WHERE id = $course_id";
	$courses_obj = $db->query($sql);
	if ($courses_obj->num_rows > 0) {					
		//if true, it means the course exists in the database
		$course_row = $courses_obj->fetch_array();	
		$sql 		= "SELECT * FROM levels WHERE id = '$level_id'";
		$levels_obj	= $db->query($sql);
		if ($levels_obj->num_rows > 0) {				
			//if true, it means the level exists in the database
			$level_row	= $levels_obj->fetch_assoc();
			$sql	= "SELECT * FROM course_level WHERE course_id = $course_id 	AND level_id = $level_id";
			$course_level = $db->query($sql);
			if ($course_level->num_rows > 0) {		
				//if true, it means the course contains the level
				//check if the subject code already exists
				$sql				= "SELECT * FROM subjects WHERE sub_code = '" . $subject_code . "'";
				$subject_exists		= $db->query($sql);
				if ($subject_exists->num_rows == 0 ) { 
						// echo ' subjects is new';
					//the objects contains 0 rows ie no match for the subject in the database
					//the new subject code is unique ie does not exist in the database
					$subject_name		= trim($subject_name);
					$subject_name 		= stripslashes($subject_name);
				  	$subject_name		= htmlspecialchars($subject_name);//removing unnecessary symbols
				  	$subject_code 		= trim($subject_code);
	  				$subject_code		= stripslashes($subject_code);
	  				$subject_code		= htmlspecialchars($subject_code);
	  				$sub_params			= array(
	  										'sub_code'	=> $subject_code,
	  										'sub_name'	=> $subject_name
	  					); 
	  				if($db->insert('subjects', $sub_params)){
	  					//subject added successfully to table subjects
		  					// echo '<br>Message from database: Subject saved to table subjects in database';
	  					//add the new subject to table level_subject
	  					$db_result 		= $db->getResult();
	  					$subject_id 	= $db_result[0];
	  					$table 			= 'level_subject';
	  					$params 		= array(
	  									'level_id' 		=> $level_id, 
	  									'subject_id'	=> $subject_id
	  									);
	  					if ($db->insert($table, $params)) {
	  						//the level and subject are linked together
		  						// echo '<br>Message from database: subject and level ids added to the table level_subject successfully';
	  					}
	  					else{
	  						$form_error .= '<br>The subject and leves couldnot be added together';
	  					}
	  				}
					else{
						//Subject couldnot be added
						$form_error	.= '<br>The subject could not be saved to the database';
							// echo '<br>Message from helper : Subject could not be saved to database';
					}
				}
				else{
					//the subject with the subject code already exists
					$form_error	.= '<br>The subject already exists in the database';
						// echo '<br>Warning from helper : Subject already exists in the database';
				}
				
			}
			else{
				//
				$course_name 	= $course_row['course_name'];
				$level_name		= $level_row['level_name'];
				$form_error 	.= '<br>The course '."'".$course_name."'".' doesnot contain the level '."'".$level_name."'";
				return false;

			}
		}
		else{
			//
			$form_error .= '<br>The level is not registered';
			return false;
		}
	}
	else{
		//
		$form_error .= '<br>The course is not registered';
		return false;
	}
}

/**
 * this function is used by the update_paper.php file for checking the file uploaded from form and adding into disk and the database
 * this function should be able to replace the older file with the newer file and the database details donot need any changes
 */
function updater($paper_id){
	global $error;
	$target_dir = 'C:/xampp/htdocs/QuestionBank/';	//folder where the folder for all files ie 'papers' is stored
	$db 			= new Database();
	$db->connect();
	$paper_exists 	= $db->select('papers', '*', null , 'id='. $paper_id);
	//check the file extension of the pdf file uploaded from the browser
	if ($_FILES['new_file']['type'] == 'application/pdf') {
		//the uploaded file is pdf file
		if ($paper_exists) {
			//papers exists in database
			$paper_details		= $db->getResult();	//stores the value of result(which is in the form of array[][])
			$paper_location 	= $paper_details[0]['location'];
			$main_location		= $target_dir.$paper_location;//storing the file location
			//now delete the file 
			if (file_exists($main_location)) {
				//file exists in the database
				if (unlink($main_location)) {
					//file has been deleted from the disk drive
					echo '<br> Previous file deleted';
					if (move_uploaded_file($_FILES['new_file']['tmp_name'], $main_location)) {
						//file saved to the disk
						return true;
					}
				}
				else{
					//could not delete file 
					$error .= '<br>Could not delete file';
				}
			}
			else{
				//paper doesnot exist
				$error 	.= '<br>Paper doesnot exist in database.';
				if (move_uploaded_file($_FILES['new_file']['tmp_name'], $main_location)) {
					//file saved to the disk
					return true;
				}
				
			}
		}
	}
	else{
		//the uploaded file is not pdf file
		$error 	.= '<br>The uploaded file is not pdf file';
		return false;
	}
}