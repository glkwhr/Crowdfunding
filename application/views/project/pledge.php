<div class="container">
<div class="center-block jumbotron text-center" style="max-width: 600px;">
<?php switch($mode):?>
<?php case 'failed':?>
  <h4>Failed to back <a href="<?php echo APP_URL . "/project/view/" . $data['pid'];?>">the project</a></h4>
<?php break;?>
<?php case 'noccn':?>
  <h4>Please update your CCN info first. <a href="<?php echo APP_URL . "/user/profile";?>">GO</a></h4>
<?php break;?>
<?php case 'succeeded':?>
  <h4>Just backed <a href="<?php echo APP_URL . "/project/view/" . $data['pid'];?>">the project</a></h4>
<?php break;?>
<?php endswitch;?>
</div>
</div>