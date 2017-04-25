<div class="container">
<?php switch ($mode): ?>
<?php case 'succeeded': ?>
<!-- TODO: Auto login -->

<div class="jumbotron center-block" style="text-align: center;">
  <h1>Welcome</h1>
  <h2>Registration succeeded!</h2>
  <p>Please login to enjoy all features.</p>
  <a class="btn btn-lg btn-success" role="button" href="<?php echo APP_URL ?>/user/login">Login now</a>
</div>
<?php break; ?>

<?php case 'failed': ?>
<?php if (isset($errors)) { extract($errors); } ?>
<?php case 'register': ?>
<!-- Show registration form -->
<form class="center-block jumbotron" style="max-width: 600px;" action="<?php echo APP_URL ?>/user/register" method="post">
  <h2><?php echo $title ?></h2>
  
  <div class="form-group <?php if (isset($unameError)) { echo 'has-error'; }?>">
	<label class="control-label">Username</label>
	<input class="form-control" type="text" name="usrname" required="required" placeholder="Username">
	<?php if (isset($unameError)): ?>
	<span class="help-block"><?php echo $unameError?></span>
	<?php endif?>
  </div>
  
  <div class="form-group <?php if (isset($upwdError)) { echo 'has-error'; }?>">
	<label class="control-label">Password</label>
	<input class="form-control" type="password" name="pwd" required="required" placeholder="Password">
	<?php if (isset($upwdError)): ?>
	<span class="help-block"><?php echo $upwdError?></span>
	<?php endif?>
  </div>
  
  <div class="form-group <?php if (isset($nameError)) { echo 'has-error'; }?>">
	<label class="control-label">Full Name</label>
	<input class="form-control" type="text" name="realname" required="required" placeholder="Full Name">
	<?php if (isset($nameError)): ?>
	<span class="help-block"><?php echo $nameError?></span>
	<?php endif?>
  </div>
  
  <div class="form-group <?php if (isset($ccnError)) { echo 'has-error'; }?>">
	<label class="control-label">Credit Card Number</label>
	<input class="form-control" type="text" name="creditcardnum" placeholder="Credit Card Number">
	<?php if (isset($ccnError)): ?>
	<span class="help-block"><?php echo $ccnError?></span>
	<?php endif?>
  </div>
  
  <div class="form-group <?php if (isset($emailError)) { echo 'has-error'; }?>">
	<label class="control-label">Email Address</label>
	<input class="form-control" type="email" name="email" placeholder="Email Address">
	<?php if (isset($emailError)): ?>
	<span class="help-block"><?php echo $emailError?></span>
	<?php endif?>
  </div>
  
  <div class="form-group">
	<label class="control-label">Address</label>
	<input class="form-control" type="text" name="addr" placeholder="Address">
  </div>
  
  <div class="form-group <?php if (isset($interestError)) { echo 'has-error'; }?>">
	<label class="control-label">Interests</label>
	<input class="form-control" type="text" name="interest" placeholder="Interest1,Interest2,...">
	<?php if (isset($interestError)): ?>
	<span class="help-block"><?php echo $interestError?></span>
	<?php endif?>
  </div>
  <div class="form-group">
    <button type="submit" role="button" class="btn btn-default btn-lg">Register</button>
  </div>
</form>
<?php endswitch ?>
</div>