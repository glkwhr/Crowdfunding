<?php switch ($mode): ?>
<?php case 'successful': ?>
<!-- TODO: Auto login -->
<a class="big" href="<?php echo APP_URL ?>">Registration succeeded!	Click to return to index.</a>
<?php break; ?>

<?php case 'failed': ?>
<!-- TODO: Show error message -->
<h3>Registration Failed! Please retry.</h3>
<?php if (isset($errors)) { extract($errors); } ?>

<?php case 'register': ?>
<!-- Show registration form -->
<form action="<?php echo APP_URL ?>/user/register" method="post">
	<label>Username</label> <br /> 
	<input type="text" name="usrname">
	<span class="error"><?php if (isset($unameError)) { echo $unameError; }?></span>
	<br /> <br /> 
	<label>Password</label>	<br /> 
	<input type="password" name="pwd"> 
	<span class="error"><?php if (isset($upwdError)) { echo $upwdError; }?></span>
	<br /> <br /> 
	<label>Real	Name</label> <br /> 
	<input type="text" name="realname"> 
	<span class="error"><?php if (isset($nameError)) { echo $nameError; }?></span>
	<br /> <br /> 
	<label>Credit Card Number</label> <br /> 
	<input type="text" name="creditcardnum"> 
	<span class="error"><?php if (isset($ccnError)) { echo $ccnError; }?></span>
	<br /> <br /> 
	<label>Email Address</label> <br />
	<input type="text" name="email"> 
	<span class="error"><?php if (isset($emailError)) { echo $emailError; }?></span>
	<br /> <br /> 
	<label>Address</label> <br /> 
	<input type="text" name="addr"> 
	<br /> <br /> 
	<label>Interests (interest1, interest2, ...)</label> <br /> 
	<input type="text" name="interest"> 
	<span class="error"><?php if (isset($interestError)) { echo $interestError; }?></span>
	<br /> <br /> 
	<input type="submit" value="Register">
</form>
<?php endswitch ?>
