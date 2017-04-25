<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Crowdfunding</title>
</head>
<body>
	<h1>Crowdfunding</h1>
	<ul id="nav"> 
	    <li><a href="<?php echo APP_URL?>">Home</a></li>
	    <li><a href="<?php echo APP_URL?>/project">Projects</a></li>
	    <?php if ((new UserModel())->checkLogin()): ?> 
	    <li><a href="<?php echo APP_URL?>/user/profile">Profile(<?php echo $_SESSION['user']['username']?>)</a></li>
	    <li><a href="<?php echo APP_URL?>/user/logout">Logout</a></li> 
	    <?php else: ?>
	    <li><a href="<?php echo APP_URL?>/user/register">Register</a></li> 
	    <li><a href="<?php echo APP_URL?>/user/login">Login</a></li> 
	    <?php endif?>
	</ul> 
	<h2><?php echo $title ?></h2>