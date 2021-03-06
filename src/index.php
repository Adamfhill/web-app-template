<?php

  // Constants
  $DEBUG_MODE = false;

  // Start a session
  session_start();

  // Prepare the page
  if(isset($_GET['page']))
  {
    // Check if the user is logging out
    if($_GET['page'] == "logout")
    {
      session_destroy();
      session_unset();
      session_start();
    }

    // Get the path of the file to load
    $filename = "views/" . $_GET['page'] . ".php";
    $jsfilename = "js/" . $_GET['page'] . ".js";
    if(!file_exists($filename))
    {
      $filename = "views/404.php";
    }
  }
  else
  {
    // Not specified, load the home page
    $filename = "views/home.php";
    $jsfilename = "";
  }

  // Prepare the session variables
  if(!isset($_SESSION["authenticated"]))  $_SESSION["authenticated"] = false;
  if(!isset($_SESSION["email"]))          $_SESSION["email"] = "";

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Web Application Title</title>

  <!-- Bootstrap -->
  <link href="/css/bootstrap.min.css" rel="stylesheet">

  <!-- Font Awesome -->   
  <link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
  
  <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>

<body>
  <?php
  if($DEBUG_MODE)
  {
    ini_set("display_errors", 1);
    ini_set("track_errors", 1);
    ini_set("html_errors", 1);
    error_reporting(E_ALL);
  }
  ?>
  <nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="/"><i class="fa fa-cube"></i> Web Application</a>
      </div>
      <div id="navbar" class="collapse navbar-collapse">
        <ul class="nav navbar-nav">
          <li><a href="/item/"><i class="fa fa-bar-chart"></i> Item with Icon</a></li>
          <li><a href="/item/">Item with Menu</a></li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
          <?php if($_SESSION["authenticated"]) { ?>
            <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> ' . $_SESSION["email"] . ' <b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li><a href="/profile/"><i class="fa fa-cog"></i> Profile</a></li>
                <li><a href="#"><i class="fa fa-lock"></i> Change Password</a></li>
                <li class="divider"></li>
                <li><a href="/logout/"><i class="fa fa-sign-out"></i> Sign out</a></li>
              </ul>
            </li>
          <?php } else { ?>
            <li><a href="/register/"><i class="fa fa-file-text-o"></i> Register</a></li>
            <li><a href="/login/"><i class="fa fa-sign-in"></i> Sign in</a></li>
          <?php } ?>
        </ul>
      </div>
    </div>
  </nav>
  <br /><br /><br /><br /><br />

  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <?php require $filename; ?>
      </div>
    </div>
    <?php if($DEBUG_MODE) { ?>
      <div class="row">
        <div class="col-lg-12">
          <?php echo "<pre>" . print_r($_SESSION, TRUE) . "</pre>"; ?>
        </div>
      </div>
    <?php } ?>
  </div>

  <!-- Include the necessary scripts -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
  <script src="/js/bootstrap.min.js"></script>

  <!-- Load the javascript file for the page if applicable -->
  <?php
  if(file_exists($jsfilename))
  {
    echo '<script src="/' . $jsfilename . '"></script>';
  }
  ?>
</body>
</html>