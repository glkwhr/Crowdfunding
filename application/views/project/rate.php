<div class="container">
<div class="center-block jumbotron text-center" style="max-width: 600px;">
<?php switch($mode):?>
<?php case 'failed':?>
  <h4>Failed to rate <a href="<?php echo APP_URL . "/project/view/" . $data['pid'];?>">the project</a></h4>
<?php break;?>
<?php case 'denied':?>
  <h4>You have either rated this project already, or not backed this project. <a href="<?php echo APP_URL . "/project/view/" . $data['pid'];?>">Return</a></h4>
<?php break;?>
<?php case 'succeeded':?>
  <h4>Just rated <a href="<?php echo APP_URL . "/project/view/" . $data['pid'];?>">the project</a></h4>
<?php break;?>
<?php endswitch;?>
</div>
</div>