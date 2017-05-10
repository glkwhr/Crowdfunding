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
<form class="center-block jumbotron" enctype="multipart/form-data" style="max-width: 600px;" action="<?php echo APP_URL; ?>/project/edit/<?php echo $pid; ?>" method="post">
  <h2><?php echo $title ?></h2>

  <div class="form-group <?php if (isset($pnameError)) { echo 'has-error'; }?>">
	<label class="control-label">Username</label>
	<input class="form-control" type="text" name="pname" required="required"  value = "<?php echo $pname;?>" placeholder="Projectname">
	<?php if (isset($pnameError)): ?>
	<span class="help-block"><?php echo $pnameError?></span>
	<?php endif?>
  </div>

  <div class="form-group <?php if (isset($profpicError)) { echo 'has-error'; }?>" >
    <label class="control-label">Profile Photo</label>
    <input type="file" name="profpic">
    <span class="help-block">*.jpg, *.jpge, *.png (less than 1MB)</span>
    <?php if (isset($profpicError)): ?>
    <span class="help-block"><?php echo $profpicError?></span>
    <?php endif?>
  </div>

  <div class="form-group <?php if (isset($desError)) { echo 'has-error'; }?>">
	<label class="control-label">Description</label>
	<textarea class="form-control" style="resize: vertical;" rows="3" name="description" placeholder="Description"><?php echo $description;?></textarea>
	<?php if (isset($desError)): ?>
	<span class="help-block"><?php echo $desError?></span>
	<?php endif?>
  </div>

  <div class="form-group <?php if (isset($tagError)) { echo 'has-error'; }?>">
	<label class="control-label">Tag</label>
	<input class="form-control" type="text" name="tag" value = "<?php echo $tag;?>" placeholder="Tag">
	<?php if (isset($tagError)): ?>
	<span class="help-block"><?php echo $tagError?></span>
	<?php endif?>
  </div>
  
  <div class="form-group <?php if (isset($sampleError)) { echo 'has-error'; }?>" >
    <label class="control-label">Add Sample</label>
    <input type="file" name="sample">
    <span class="help-block"> less than 2MB </span>
    <?php if (isset($sampleError)): ?>
    <span class="help-block"><?php echo $sampleError?></span>
    <?php endif?>
  </div>

<?php if (isset($progress)):?>
  <div class="form-group <?php if (isset($progressError)) { echo 'has-error'; }?>">
	<label class="control-label">Progress</label>
	<input class="form-control" type="range" min="0" max="100" name="progress" required="required" value = "<?php echo $progress;?>" placeholder="Progress">
	<?php if (isset($progressError)): ?>
	<span class="help-block"><?php echo $progressError?></span>
	<?php endif?>
  </div>
<?php endif;?>

  <div class="form-group">
    <button type="submit" role="button" class="btn btn-default btn-lg">Update</button>
    <a href="<?php echo APP_URL . "/project/view/" . $pid;?>" class="btn btn-lg btn-default" role="button">Return</a>
  </div>
</form>
</div>
