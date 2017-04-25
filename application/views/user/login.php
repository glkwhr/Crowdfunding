<div class="container">
<?php switch ($mode): ?>
<?php case 'succeeded': ?>
<!-- TODO: Auto login -->
<?php header('location:' . APP_URL); break; ?>

<?php case 'failed': ?>
<!-- TODO: Show error message -->
<?php if (isset($errors)) { extract($errors); } ?>
<div class="alert">
	<button type="button" class="close" data-dismiss="alert">&times;</button>
	<strong>Warning!</strong> <?php if (isset($error)): echo $error; else:?>Failed to log in! Please retry.<?php endif?>
</div>
<?php case 'login': ?>
<!-- Show registration form -->
<div class="hero-unit">
<h2><?php echo $title ?></h2>
<form action="<?php echo APP_URL ?>/user/login" method="post">
	<label>Username</label>
	<input type="text" name="usrname" required="required">
	<br>
	<label>Password</label> 
	<input type="password" name="pwd" required="required"> 
	<br>
	<input type="checkbox" name="remember" value="true"> Remeber Me <br> 
	<br> <br> 
	<input type="submit" value="Login">
</form>
<?php endswitch ?>
</div>
</div>