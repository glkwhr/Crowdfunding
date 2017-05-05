<div class="container">
<?php switch ($mode): ?>
<?php case 'succeeded': ?>
<div class="center-block alert alert-success fade in alert-dismissable" style="max-width: 600px;" role="alert">
  <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">x</a>
  <strong>Succeeded</strong>
  " Your profile has been successfully updated! "
</div>
<?php break; ?>
<?php case 'failed': ?>
<?php if (isset($errors)) { extract($errors); } ?>
<?php endswitch ?>
<?php if (isset($data)) { extract($data); }?>
<form class="center-block jumbotron" style="max-width: 600px;" action="<?php echo APP_URL; ?>/user/profile" method="post">
  <h2><?php echo $title ?></h2>
  
  <div class="form-group <?php if (isset($unameError)) { echo 'has-error'; }?>">
	<label class="control-label">Username</label>
	<input class="form-control" type="text" name="usrname" required="required" readonly value="<?php echo $uname;?>" placeholder="Username">
	<?php if (isset($unameError)): ?>
	<span class="help-block"><?php echo $unameError?></span>
	<?php endif?>
  </div>
  
  <div class="form-group <?php if (isset($upwdError)) { echo 'has-error'; }?>">
	<label class="control-label">Old Password *</label>
	<input class="form-control" type="password" name="pwd" required="required" placeholder="Old Password">
	<?php if (isset($upwdError)): ?>
	<span class="help-block"><?php echo $upwdError?></span>
	<?php endif?>
  </div>
  
  <div class="form-group <?php if (isset($upwdError)) { echo 'has-error'; }?>">
	<label class="control-label">New Password</label>
	<input class="form-control" type="password" name="newpwd" placeholder="New Password">
	<?php if (isset($upwdError)): ?>
	<span class="help-block"><?php echo $upwdError?></span>
	<?php endif?>
  </div>
  
  <div class="form-group <?php if (isset($nameError)) { echo 'has-error'; }?>">
	<label class="control-label">Full Name</label>
	<input class="form-control" type="text" name="realname" required="required" value="<?php echo $name;?>" placeholder="Full Name">
	<?php if (isset($nameError)): ?>
	<span class="help-block"><?php echo $nameError?></span>
	<?php endif?>
  </div>
  
  <div class="form-group <?php if (isset($ccnError)) { echo 'has-error'; }?>">
	<label class="control-label">Credit Card Number</label>
	<input class="form-control" type="text" name="creditcardnum" value="<?php echo $ccn; ?>" placeholder="Credit Card Number">
	<?php if (isset($ccnError)): ?>
	<span class="help-block"><?php echo $ccnError?></span>
	<?php endif?>
  </div>
  
  <div class="form-group <?php if (isset($emailError)) { echo 'has-error'; }?>">
	<label class="control-label">Email Address</label>
	<input class="form-control" type="email" name="email" value="<?php echo $email; ?>" placeholder="Email Address">
	<?php if (isset($emailError)): ?>
	<span class="help-block"><?php echo $emailError?></span>
	<?php endif?>
  </div>
  
  <div class="form-group">
	<label class="control-label">Address</label>
	<input class="form-control" type="text" name="addr" value="<?php echo $addr; ?>" placeholder="Address">
  </div>
  
  <div class="form-group <?php if (isset($interestError)) { echo 'has-error'; }?>">
	<label class="control-label">Interests</label>
	<input class="form-control" type="text" name="interest" value="<?php echo $interest; ?>" placeholder="Interest1,Interest2,...">
	<?php if (isset($interestError)): ?>
	<span class="help-block"><?php echo $interestError?></span>
	<?php endif?>
  </div>
  <div class="form-group">
    <button type="submit" role="button" class="btn btn-default btn-lg">Update</button>
  </div>
</form>
</div>