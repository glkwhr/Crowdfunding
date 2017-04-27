<div class="container">
<?php 
$count = 0;
foreach ($result as $row): 
	if ($count % 4 == 0): echo "<div class=\"row\">"; endif;
?>
  <div class="col-md-3">
    <div class="thumbnail">
      <img src="<?php echo APP_URL . "/assets/img/project/profile/" . (empty($row['profpic']) ? "default.png" : $row['profpic'])?>" alt="Project Profile Picture">
      <div class="caption">
        <h3><?php echo $row['pname'] ?></h3>
        <p><?php echo $row['description'] ?></p>
        <p><a href="#" class="btn btn-primary" role="button">View</a> <a href="#" class="btn btn-success" role="button">Like</a></p>
      </div>
    </div>
  </div>
<?php
$count += 1;
if ($count % 4 == 0): echo "</div>"; endif; ?>
<?php endforeach ?>
</div>