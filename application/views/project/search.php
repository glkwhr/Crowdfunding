<div class="container">
<?php if (empty($result)):?>
<div class="jumbotron" style="text-align: center;">
  <h1>Cannot find the project.</h1>
  <a href="<?php echo APP_URL . "/project/search"?>" class="btn btn-primary btn-lg" role="button">Explore</a>
</div>
<?php else:?>
<div class="row">
<?php foreach ($result as $row): ?>
  <div class="col-xs-12 col-md-6">
    <div class="thumbnail">
      <a href="<?php echo APP_URL . "/project/view/" . $row['pid']; ?>">
        <img style="height: 300px" src="<?php echo APP_URL . IMG_PROJ_URL . "profile/" . (empty($row['profpic']) ? "default.png" : $row['profpic'])?>" alt="Project Profile Picture">
      </a>
      <div class="caption">
        <h3><?php echo $row['pname']?></h3>
        <p><?php echo "(" . $row['status'] . ")"?>
        <p>by <a href="<?php echo APP_URL . "/user/view/" . $row['uname'];?>"><?php echo $row['uname'];?></a></p>
        <p><a href="<?php echo APP_URL . "/project/view/" . $row['pid']?>" class="btn btn-primary" role="button">View</a> 
        <?php if (isset($likeModel) && $likeModel->hasLiked($user, $row['pid'])):?>
        <a href="<?php echo APP_URL?>/project/unlike/<?php echo $row['pid']?>" class="btn btn-md btn-default active" role="button">Liked</a>
        <?php else:?>
        <a href="<?php echo APP_URL?>/project/like/<?php echo $row['pid']?>" class="btn btn-md btn-success" role="button">Like</a>
        <?php endif;?>
        </p>
      </div>
    </div>
  </div>
<?php endforeach ?>
</div>
<?php endif;?>
</div>