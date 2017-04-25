<?php
if (session_status() == PHP_SESSION_NONE) {
	session_start();
}
?>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	
	<!-- Le styles -->
    <link href="<?php echo APP_URL?>/assets/css/bootstrap.min.css" rel="stylesheet">
    <style type="text/css">
      body {
        padding-top: 60px;
        padding-bottom: 40px;
      }
    </style>
    
	<title>Crowdfunding</title>
</head>
<body>
	<div class="navbar navbar-inverse navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="brand" href="<?php echo APP_URL?>">Crowdfunding</a>
          <div class="nav-collapse collapse">
            <ul class="nav">
              <li><a href="<?php echo APP_URL?>">Home</a></li>
			  <li><a href="<?php echo APP_URL?>/project">Projects</a></li>
			  <?php if ((new UserModel())->checkLogin()): ?> 
			  <li><a href="<?php echo APP_URL?>/user/profile">Profile(<?php echo $_SESSION['user']['username']?>)</a></li>
			  <li><a href="<?php echo APP_URL?>/user/logout">Logout</a></li> 
			  <?php else: ?>
			  <li><a href="<?php echo APP_URL?>/user/register">Register</a></li> 
			  <li><a href="<?php echo APP_URL?>/user/login">Login</a></li> 
            </ul>
            <?php endif?>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>