<div class="container">
<div class="center-block jumbotron text-center" style="max-width: 600px;">
<?php switch ($mode): ?>
<?php case 'succeeded': ?>
  <h4>Just liked <a href="<?php echo APP_URL . "/project/view/" . $pid;?>"><?php echo $pname;?></a></h4>
<?php break; ?>
<?php case 'liked': ?>
  <h4>You have liked <a href="<?php echo APP_URL . "/project/view/" . $pid;?>"><?php echo $pname;?></a></h4>
  <h2><a href="<?php echo APP_URL?>/project/unlike/<?php echo $pid?>" class="btn btn-md btn-danger" role="button">Unlike</a></h2>
<?php break; ?>
<?php endswitch;?>
</div>
</div>