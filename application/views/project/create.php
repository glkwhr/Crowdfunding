<div class="container">
<?php switch ($mode): ?>
<?php case 'succeeded': ?>
<div class="jumbotron center-block" style="text-align: center;">
  <h2>Project successfully created!</h2>
</div>
<?php break; ?>

<?php case 'failed': ?>
<?php if (isset($errors)) { extract($errors); } ?>

<?php case 'create': ?>
<!-- Show registration form -->
<form class="center-block jumbotron" style="max-width: 700px;" action="<?php echo APP_URL ?>/project/create" method="post">
  <h2><?php echo $title ?></h2>
  <div class="form-group <?php if (isset($pnameError)) { echo 'has-error'; }?>">
	<label class="control-label">Project Title</label>
	<input class="form-control" type="text" name="pname" required="required" placeholder="Title">
	<?php if (isset($pnameError)): ?>
	<span class="help-block"><?php echo $pnameError?></span>
	<?php endif?>
  </div>
  
  <div class="form-group <?php if (isset($desError)) { echo 'has-error'; }?>">
	<label class="control-label">Description</label>
	<textarea class="form-control" style="resize: vertical;" rows="3" name="description" required="required" placeholder="Description"></textarea>
	<?php if (isset($desError)): ?>
	<span class="help-block"><?php echo $desError?></span>
	<?php endif?>
  </div>

  <div class="form-group <?php if (isset($minError)) { echo 'has-error'; }?>">
	<label class="control-label">Minimum Amount</label>
	<input class="form-control" type="number" min="0" name="minamount" required="required" placeholder="Minimum Amount">
	<?php if (isset($minError)): ?>
	<span class="help-block"><?php echo $minError?></span>
	<?php endif?>
  </div>
  
  <div class="form-group <?php if (isset($maxError)) { echo 'has-error'; }?>">
	<label class="control-label">Maximum Amount</label>
	<input class="form-control" type="number" min="0" name="maxamount" required="required" placeholder="Maximum Amount">
	<?php if (isset($maxError)): ?>
	<span class="help-block"><?php echo $maxError?></span>
	<?php endif?>
  </div>
  
  <div class="form-group <?php if (isset($endtimeError)) { echo 'has-error'; }?>">
	<label class="control-label">Accept Pledges Until</label>
	<input class="form-control" data-date-format="YYYY/MM/DD" type="date" name="endtime">
	<?php if (isset($endtimeError)): ?>
	<span class="help-block"><?php echo $endtimeError?></span>
	<?php endif?>
  </div>
  
  <div class="form-group <?php if (isset($pctError)) { echo 'has-error'; }?>">
	<label class="control-label">Planned Completion Time</label>
	<input class="form-control" data-date-format="YYYY/MM/DD" type="date" name="plannedcompletiontime">
	<?php if (isset($pctError)): ?>
	<span class="help-block"><?php echo $pctError?></span>
	<?php endif?>
  </div>

  <div class="form-group">
    <button type="submit" role="button" class="btn btn-default btn-lg">Create</button>
  </div>
</form>
<?php endswitch ?>
</div>