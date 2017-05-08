<div class="container">
<div class="center-block jumbotron text-center" style="max-width: 600px;">
<?php switch ($mode): ?>
<?php case 'succeeded': ?>
  <h4>Now following <a href="<?php echo APP_URL . "/user/view/" . $uname2;?>"><?php echo $uname2;?></a></h4>
<?php break; ?>
<?php case 'followed': ?>
  <h4>You have followed <a href="<?php echo APP_URL . "/user/view/" . $uname2;?>"><?php echo $uname2;?></a></h4>
  <h2><a href="<?php echo APP_URL?>/user/unfollow/<?php echo $uname2?>" class="btn btn-md btn-danger" role="button">Unfollow</a></h2>
<?php break; ?>
<?php endswitch;?>
</div>
</div>