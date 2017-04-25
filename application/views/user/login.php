<?php switch ($mode): ?>
<?php case 'succeeded': ?>
<!-- TODO: Auto login -->
<?php header('location:' . APP_URL); break; ?>

<?php case 'failed': ?>
<!-- TODO: Show error message -->
<h3>Failed to log in! Please retry.</h3>
<?php if (isset($errors)) { extract($errors); } ?>

<?php case 'login': ?>
<!-- Show registration form -->
<form action="<?php echo APP_URL ?>/user/login" method="post">
	<label>Username</label> <br /> 
	<input type="text" name="usrname" required="required">
	<br /> <br /> 
	<label>Password</label>	<br /> 
	<input type="password" name="pwd" required="required"> 
	<br /> <br />  
	<input type="checkbox" name="remember" value="true"> Remeber Me 
	<span class="error"><?php if (isset($error)) { echo $error; }?></span>
	<br /> <br />  
	<input type="submit" value="Login">
</form>
<?php endswitch ?>