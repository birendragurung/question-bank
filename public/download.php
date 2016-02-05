<?php 
	include '../includes/helpers.php';
	include '../includes/database.php';
	$db 	= new Database();
	$db->connect();
	$error	= '<br>Cannot access this file.';
	if (!empty($_GET)) {
		if (!empty($_GET['id'])) {
			$id = $_GET['id'];
			//syntax for $db->select is : select(  tablename, fields to select , join table, where condition, order, limit)
			$paper_exists	= $db->select('papers', '*' , null , 'id = '. $id);
			if($paper_exists){
				$db_result 		= $db->getResult();
				$location		= $db_result[0]['location'];
				header('location:'. base_url() . $location);
			}
			else{
				$error = '<br>Paper unavailable';
			}
		}
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

						<?php echo $error; ?>
						</article>

				</div>
			</div>
		</div>

<?php include 'tfooter.php'; ?>