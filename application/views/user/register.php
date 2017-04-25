<div class="container">
<?php switch ($mode): ?>
<?php case 'successful': ?>
<!-- TODO: Auto login -->
<a class="big" href="<?php echo APP_URL ?>">Registration succeeded!	Click to return to index.</a>
<?php break; ?>

<?php case 'failed': ?>
<!-- TODO: Show error message -->
<div class="alert">
	<button type="button" class="close" data-dismiss="alert">&times;</button>
	<strong>Warning!</strong> Registration Failed! Please retry.
</div>
<?php if (isset($errors)) { extract($errors); } ?>

<?php case 'register': ?>
<!-- Show registration form -->
<div class="hero-unit">
<h2><?php echo $title ?></h2>
<form action="<?php echo APP_URL ?>/user/register" method="post">
	<label>Username</label>
	<input type="text" name="usrname" required="required">
	<span class="error"><?php if (isset($unameError)) { echo $unameError; }?></span>
	<br>
	<label>Password</label>
	<input type="password" name="pwd" required="required"> 
	<span class="error"><?php if (isset($upwdError)) { echo $upwdError; }?></span>
	<br>
	<label>Real	Name</label>
	<input type="text" name="realname" required="required"> 
	<span class="error"><?php if (isset($nameError)) { echo $nameError; }?></span>
	<br>
	<label>Credit Card Number</label>
	<input type="text" name="creditcardnum"> 
	<span class="error"><?php if (isset($ccnError)) { echo $ccnError; }?></span>
	<br>
	<label>Email Address</label>
	<input type="text" name="email"> 
	<span class="error"><?php if (isset($emailError)) { echo $emailError; }?></span>
	<br>
	<label>Address</label>
	<input type="text" name="addr"> 
	<br>
	<label>Interests (interest1, interest2, ...)</label>
	<input type="text" name="interest"> 
	<span class="error"><?php if (isset($interestError)) { echo $interestError; }?></span>
	<br><br>
	<input type="submit" value="Register">
</form>
</div>
<?php endswitch ?>
</div>