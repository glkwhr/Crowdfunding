<?php
if (session_status() == PHP_SESSION_NONE) {
	session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	
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
<nav class="navbar navbar-default navbar-fixed-top">
  <div class="container">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#nav-collapse" aria-expanded="false">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="<?php echo APP_URL?>">Crowdfunding</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="nav-collapse">
    
      <ul class="nav navbar-nav navbar-left">
        <li>
	      <form class="navbar-form" action="<?php echo APP_URL ?>/project/search" method="post">
	        <div class="input-group">
	          <input type="text" class="form-control" name="keyword" placeholder="Search Projects...">
	          <span class="input-group-btn">
		        <button type="submit" class="btn btn-default">Go</button>
		      </span>
	        </div>
	      </form>
        </li>
      </ul>      
      
      <ul class="nav navbar-nav navbar-right">	    
	    <?php if ((new UserModel())->checkLogin()): ?> 
	    <li><a href="<?php echo APP_URL?>/user/home">Home</a></li>
	    <li><a href="<?php echo APP_URL?>/project/search">Projects</a></li>
	    
	    <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo $_SESSION['user']['username']?><span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="<?php echo APP_URL?>/user/profile">Profile</a></li>
            <li><a href="<?php echo APP_URL?>/user/profile">My Projects</a></li>
            <li><a href="<?php echo APP_URL?>/user/profile">My Pledges</a></li>
            <li><a href="<?php echo APP_URL?>/user/history">Browsing History</a></li>
            <li role="separator" class="divider"></li>
            <li><a href="<?php echo APP_URL?>/user/logout">Logout</a></li>
          </ul>
        </li>
	    <?php else: ?>
	    <li><a href="<?php echo APP_URL?>/">Home</a></li>
	    <li><a href="<?php echo APP_URL?>/project/search">Projects</a></li>
	    <li><a href="<?php echo APP_URL?>/user/register">Register</a></li> 
	    <li><a href="<?php echo APP_URL?>/user/login">Login</a></li> 
	    <?php endif?>
      </ul>
      
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>