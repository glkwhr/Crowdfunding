<div class="center-block jumbotron" style="max-width: 600px;">
  <div class="container">
    <div class="row">
      <h4 class="col-md-6 text-right">Username</h4><h4 class="col-md-6 text-muted text-left"><?php echo $row['uname'];?></h4>
    </div>
    <div class="row">
      <h4 class="col-md-6 text-right">Email</h4><h4 class="col-md-6 text-muted text-left"><?php echo $row['email'];?></h4>
    </div>
    <div class="row">
      <h4 class="col-md-6 text-right">Interests</h4>
        <?php if (!empty($row['interest'])):?>
        <div class="col-md-6 text-left">
        <table><tr>
        <?php foreach (explode(",", $row['interest']) as $tag):?>
        <td>
          <form name="<?php echo $tag;?>" action="<?php echo APP_URL ?>/project/search/tag" method='post'>
            <input type="hidden" name="keyword" value="<?php echo $tag; ?>"/>
            <h5><a href="javascript:document.<?php echo $tag;?>.submit();" class="label label-info label-sm"><?php echo $tag;?></a></h5>
          </form>
        </td>
        <?php endforeach;?>
        </tr></table></div>
        <?php endif; ?>
    </div>
    
    <div class="row">
      <h2 class="col-md-12 text-center">
        <?php if ($mode == "user"):?>
        <?php if ($hasFollowed):?>
        <a href="<?php echo APP_URL?>/user/unfollow/<?php echo $row['uname']?>" class="btn btn-md btn-danger" role="button">Unfollow</a>
        <?php else:?>
        <a href="<?php echo APP_URL?>/user/follow/<?php echo $row['uname']?>" class="btn btn-md btn-success" role="button">Follow</a>
        <?php endif;?>
        <?php endif;?>
        <a href="<?php echo APP_URL?>/project/user/<?php echo $row['uname']?>" class="btn btn-md btn-success" role="button">Projects</a>
      </h2>
    </div>
  </div>
</div>