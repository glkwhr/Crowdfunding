<div class="container">
<div class="center-block jumbotron text-center" style="max-width: 600px;">
<?php switch ($mode): ?>
<?php case 'succeeded': ?>
  <h4>Unliked <a href="<?php echo APP_URL . "/project/view/" . $pid;?>"><?php echo $pname;?></a></h4>
<?php break; ?>
<?php case 'notfollowed': ?>
  <h4>You have not followed <a href="<?php echo APP_URL . "/project/view/" . $pid;?>"><?php echo $pname;?></a> yet</h4>
<?php break; ?>
<?php endswitch;?>
</div>
</div>