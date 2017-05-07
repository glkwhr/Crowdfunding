<div class="container">
<div class="row">
<?php foreach ($result as $row): ?>
  <div class="col-xs-12 col-md-6">
    <div class="thumbnail">
      <a href="<?php echo APP_URL . "/project/view/" . $row['pid']; ?>">
        <img style="height: 300px" src="<?php echo APP_URL . IMG_PROJ_URL . "profile/" . (empty($row['profpic']) ? "default.png" : $row['profpic'])?>" alt="Project Profile Picture">
      </a>
      <div class="caption">
        <h3><?php echo $row['pname'] ?></h3>
        <p>by <?php echo $row['uname'];?></p>
        <p><a href="<?php echo APP_URL . "/project/view/" . $row['pid']?>" class="btn btn-primary" role="button">View</a> <a href="#" class="btn btn-success" role="button">Like</a></p>
      </div>
    </div>
  </div>
<?php endforeach ?>
</div>
</div>