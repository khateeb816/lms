<?php session_start(); 

function redirect(){
  if($_SESSION['role'] == 'student'){
      echo "<script>window.location.href = './dashboard/student/';</script>";
      exit();
  } elseif($_SESSION['role'] == 'admin'){
      echo "<script>window.location.href = './dashboard/admin/';</script>";
      exit();
  }
   elseif($_SESSION['role'] == 'teacher'){
       echo "<script>window.location.href = './dashboard/teacher/';</script>";
       exit();
  }
   elseif($_SESSION['role'] == 'management'){
      echo "<script>window.location.href = './dashboard/management/';</script>";
      exit();
  }
  else{

      echo "<script>window.location.href = 'login.php';</script>";
      exit();
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>

  <!-- Basic Page Needs
	================================================== -->
  <meta charset="utf-8">
  <title>Educenter - Education HTML Template</title>

  <!-- Mobile Specific Metas
	================================================== -->
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="description" content="Construction Html5 Template">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
  <meta name="author" content="Themefisher">
  <meta name="generator" content="Themefisher Educenter HTML Template v1.0">
  
  <!-- theme meta -->
  <meta name="theme-name" content="educenter" />

  <!-- ** Plugins Needed for the Project ** -->
  <!-- Bootstrap -->
  <link rel="stylesheet" href="plugins/bootstrap/bootstrap.min.css">
  <!-- slick slider -->
  <link rel="stylesheet" href="plugins/slick/slick.css">
  <!-- themefy-icon -->
  <link rel="stylesheet" href="plugins/themify-icons/themify-icons.css">
  <!-- animation css -->
  <link rel="stylesheet" href="plugins/animate/animate.css">
  <!-- aos -->
  <link rel="stylesheet" href="plugins/aos/aos.css">
  <!-- venobox popup -->
  <link rel="stylesheet" href="plugins/venobox/venobox.css">

  <!-- Main Stylesheet -->
  <link href="css/style.css" rel="stylesheet">

  <!--Favicon-->
  <link rel="shortcut icon" href="images/favicon.png" type="image/x-icon">
  <link rel="icon" href="images/favicon.png" type="image/x-icon">

</head>

<body>
  <!-- preloader start -->
  <!-- <div class="preloader">
    <img src="images/preloader.gif" alt="preloader">
  </div> -->
  <!-- preloader end -->

<!-- header -->
<header class="fixed-top header">
  <!-- top header -->
  <div class="top-header py-2 bg-white">
    <div class="container">
      <div class="row no-gutters">
        <div class="col-lg-4 text-center text-lg-left">
          <a class="text-color mr-3" href="tel:+443003030266"><strong>CALL</strong> +44 300 303 0266</a>
          <ul class="list-inline d-inline">
            <li class="list-inline-item mx-0"><a class="d-inline-block p-2 text-color" href="https://facebook.com/themefisher/"><i class="ti-facebook"></i></a></li>
            <li class="list-inline-item mx-0"><a class="d-inline-block p-2 text-color" href="https://twitter.com/themefisher"><i class="ti-twitter-alt"></i></a></li>
            <li class="list-inline-item mx-0"><a class="d-inline-block p-2 text-color" href="https://github.com/themefisher"><i class="ti-github"></i></a></li>
            <li class="list-inline-item mx-0"><a class="d-inline-block p-2 text-color" href="https://instagram.com/themefisher/"><i class="ti-instagram"></i></a></li>
          </ul>
        </div>
        <div class="col-lg-8 text-center text-lg-right">
          <ul class="list-inline">
            <li class="list-inline-item"><a class="text-uppercase text-color p-sm-2 py-2 px-0 d-inline-block" href="./login.php" >login</a></li>
            <li class="list-inline-item"><a class="text-uppercase text-color p-sm-2 py-2 px-0 d-inline-block" href="./register.php" >register</a></li>
          </ul>
        </div>
      </div>
    </div>
  </div>
  <!-- navbar -->
  <div class="navigation w-100">
    <div class="container">
      <nav class="navbar navbar-expand-lg navbar-dark p-0">
        <a class="navbar-brand" href="index.php"><img src="images/logo.png" alt="logo"></a>
        <button class="navbar-toggler rounded-0" type="button" data-toggle="collapse" data-target="#navigation"
          aria-controls="navigation" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navigation">
          <ul class="navbar-nav ml-auto text-center">
            <li class="nav-item <?php echo basename($_SERVER['PHP_SELF']) == 'index.php'? 'active': ''; ?>">
              <a class="nav-link" href="index.php">Home</a>
            </li>
            <li class="nav-item <?php echo basename($_SERVER['PHP_SELF']) == 'register.php'? 'active': ''; ?>">
              <a class="nav-link" href="./register.php">Register</a>
            </li>
            <li class="nav-item <?php echo basename($_SERVER['PHP_SELF']) == 'login.php'? 'active': ''; ?>">
              <a class="nav-link" href="./login.php">Login</a>
            </li>
          </ul>
        </div>
      </nav>
    </div>
  </div>
</header>