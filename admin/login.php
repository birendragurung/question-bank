<?php 
    $error  = '';
    session_start();
    include '../includes/helpers.php';
    include '../includes/database.php';
    if (isset($_SESSION['user'])) {
        header('location:welcome.php');
    }
    if (!empty($_GET)) {
        if (!empty($_GET['e'])) {
            $error_flag     = $_GET['e'];
            switch ($error_flag) {
                case '1':
                    $error  .= 'Login form not submitted';
                    break;
                case '2':
                    $error  .= 'Login form incomplete';
                    break;
                case '3':
                    $error  .= 'Username doesnot exist';
                    break;
                default:
                    break;
            }
        }
    }
?>
<!DOCTYPE html>
<head>
    <title><?php echo getTitle(__FILE__); ?></title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <!--[if lte IE 8]><script src="<?php echo base_url(); ?>assets/js/ie/html5shiv.js"></script><![endif]-->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/main.css" />
    <link rel="icon" href="<?php echo base_url(); ?>images/favicon.png" type="image/x-icon">
    <!--[if lte IE 8]><link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/ie8.css" /><![endif]-->


</head>
<body>
<body class="homepage">
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
                    </header>
                </div>
            <!-- end of header -->
            <!--========================-->

            <div id="main-wrapper">
                <div class="container">
                    <div class="row 200%">
                    <!-- Content -->
                        <div class="8u 12u$(medium) important(medium)">
                            <div id="content">
                                <!-- Content -->
                                <article>
                                <?php if ($error != ''): ?>
                                    <div style="border:1px solid lightgrey;padding-left:10px;margin-bottom:20px;background-color:antiquewhite;"><?php echo $error; ?></div>
                                <?php endif; ?>
                                    <form action="admin.php" method="post">
                                        <label for="username"><h3>&nbsp;&nbsp;&nbsp;Username:</h3></label>
                                        <input type="text" name="username" placeholder="Username"><br>
                                        <label for="password"><h3>&nbsp;&nbsp;&nbsp;Password:</h3></label>
                                        <input type="password" name="password" placeholder="Password"><br>
                                        <input type="submit" value="Login" name="login" style="background-color:grey;padding:5px 45px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <input type="reset" value="Reset form" style="background-color:grey;padding:5px 20px;">
                                    </form>
                                </article>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
</body>