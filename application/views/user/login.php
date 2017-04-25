<div class="container">
<?php switch ($mode): ?>
<?php case 'succeeded': ?>
<!-- TODO: Auto login -->
<?php header('location:' . APP_URL); break; ?>

<?php case 'failed': ?>
<!-- TODO: Show error message -->
<?php if (isset($errors)) { extract($errors); } ?>
<?php case 'login': ?>
<!-- Show registration form -->
<form class="jumbotron center-block" style="max-width: 600px;" action="<?php echo APP_URL ?>/user/login" method="post">
  <div class="form-group <?php if (isset($error)) { echo 'has-error'; }?>">
    <h2><?php echo $title ?></h2>
    <?php if (isset($error)): ?>
	<span class="help-block"><?php echo $error?></span>
	<?php endif?>
  </div>
  <div class="form-group <?php if (isset($error)) { echo 'has-error'; }?>">
	<label class="control-label">Username</label>
	<input type="text" class="form-control" name="usrname" required="required" placeholder="Username">
  </div>
  <div class="form-group <?php if (isset($error)) { echo 'has-error'; }?>">
	<label class="control-label">Password</label> 
	<input type="password" class="form-control" name="pwd" required="required" placeholder="Password"> 
  </div>
  <div class="checkbox">
    <label>
	  <input type="checkbox" name="remember" value="true"> Remeber Me
	</label>
  </div>
  <button type="submit" role="button" class="btn btn-default btn-lg">Log in</button>
</form>
<?php endswitch ?>
</div>