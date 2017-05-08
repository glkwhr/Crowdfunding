<style>
.container .jumbotron {
    background-color: transparent;
    padding-bottom: 0;
    padding-top: 0;
    padding-left: 30px;
}
.jumbotron p{
	margin-bottom: 0;
}
.profimg {
    max-width: 650px;
    max-height: 450px;
}
.comment {
	padding-top: 30px;
	padding-bottom: 30px;
    border-top: 1px solid #e5e9ef;
    border-radius: 4px;
}
</style>
<?php
switch ($mode):
case 'notfound'
?>
<div class="center-block alert alert-warning fade in alert-dismissable" style="max-width: 600px;" role="alert">
  <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">x</a>
  <strong>Failed</strong>
  " project doesn't exist "
</div>
<?php header("location:" . APP_URL . "/project/search"); break;?>
<?php default:?>
<div class="container">

  <div class="row">
    <div class="col-md-12 jumbotron">
      <div class="row" id="pname">
        <h1><?php echo $row['pname'];?></h1>
      </div>
      <div class="row" id="uname">
        <p class="text-muted">By <a href="<?php echo APP_URL . "/user/view/" . $row['uname'];?>"><?php echo $row['uname']?></a><?php echo " on " . date('Y-m-d', strtotime($row['posttime']));?></p>
      </div>
      <div class="row" id="tags">
        <?php if (!empty($row['tag'])):?>
        <table><tr>
        <?php foreach (explode(",", $row['tag']) as $tag):?>
        <td>
          <form name="<?php echo $tag;?>" action="<?php echo APP_URL ?>/project/search/tag" method='post'>
            <input type="hidden" name="keyword" value="<?php echo $tag; ?>"/>
            <p><a href="javascript:document.<?php echo $tag;?>.submit();" class="label label-default"><?php echo $tag;?></a></p>
          </form>
        </td>
        <?php endforeach;?>
        </tr></table>
        <?php endif; ?>
      </div>
    </div>
  </div>
  
  <div class="row">  
    <div class="col-md-8" id="profpic">
      <img class="profimg" src="<?php echo APP_URL . IMG_PROJ_URL . "profile/" . (empty($row['profpic']) ? "default.png" : $row['profpic'])?>" alt="Project Profile Picture">
    </div>
  
    <div class="col-md-4" id="projinfo">      
      <div class="row">
        <div class="progress">
        <?php 
        if ($row['status']=='crowdfunding') {
        	$progress = (int)$row['curamount'] * 100 / (int)$row['minamount'];
        	if ($progress > 100) $progress = 100;
        	$msg = "$" . $row['curamount'] . " pledged of $" . $row['minamount'] . " goal";
        } else if ($row['status']=='progressing' || $row['status']=='completed') {
        	$progress = (int)$row['progress'];
        	$msg = $row['progress'] . "% finished";
        } else {
        	$progress = 100;
        	$msg = "failed";
        	$failed = true;
        }
        ?>
          <div class="progress-bar progress-bar-<?php if (isset($failed)) { echo "danger"; } else { echo "success"; }?>" role="progressbar" aria-valuenow="<?php echo $progress; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $progress; ?>%">
          </div>
        </div>
      </div>
      
      <div class="row">
      <?php if ($row['status']=='crowdfunding'):?>
        <h2 class="text-success">$<?php echo $row['curamount'];?></h2>
        <p class="text-muted">pledged of $<?php echo $row['minamount'];?> goal</p>
      <?php elseif ($row['status']=='progressing'):?>
        <h2 class="text-success"><?php echo $row['progress'];?>%</h2>
        <p class="text-muted">of the project is completed</p>
      <?php elseif ($row['status']=='completed'):?>
        <h2 class="text-success">Completed</h2>
        <p class="text-muted">this project is completed on <?php echo date('Y-m-d', strtotime($row['actualcompletiontime']));?></p>
      <?php elseif ($row['status']=='failed'):?>
        <h2 class="text-danger">Failed</h2>
        <p class="text-muted">this project failed</p>
      <?php endif;?>
      </div>
      <div class="row">
        <h2 class="text-primary"><?php echo date('Y-m-d',strtotime($row['endtime']));?></h2>
        <p class="text-muted">pledge deadline</p>
      </div>
      <div class="row">
        <h2 class="text-primary"><?php echo date('Y-m-d',strtotime($row['plannedcompletiontime']));?></h2>
        <p class="text-muted">planned completion deadline</p>
      </div>
      <div class="row">
        <p class="text-muted" style="font-size: 12px; padding-top: 20px;">This project will only be funded if it reaches its goal by <?php echo date('Y-m-d',strtotime($row['endtime']));?></p>
      </div>
      <div class="row">
<?php switch ($row['status']):?>
<?php case 'crowdfunding': ?>
        <h2><a href="#" class="btn btn-lg btn-success btn-block" role="button">Back this project</a></h2>
<?php break;?>
<?php case 'progressing': ?>
        <h2><a href="#" class="btn btn-lg btn-success btn-block disabled" role="button">Back this project</a></h2>
<?php break;?>
<?php case 'completed':?>
        <h2><a href="#" class="btn btn-lg btn-warning btn-block" role="button">Rate this project</a></h2>
<?php endswitch;?>
<?php if ($mode == 'user'):?>
	<?php if (isset($hasLiked) && $hasLiked):?>
		<a href="<?php echo APP_URL?>/project/unlike/<?php echo $row['pid']?>" class="btn btn-lg btn-default btn-block active" role="button">Liked</a>
	<?php else: ?>
	    <a href="<?php echo APP_URL?>/project/like/<?php echo $row['pid']?>" class="btn btn-lg btn-info btn-block" role="button">Like this project</a>
	<?php endif;?>
<?php elseif ($mode == 'owner'):?>
        <a href="<?php echo APP_URL . "/project/edit/" . $row['pid'];?>" class="btn btn-lg btn-default btn-block" role="button">Edit this project</a>
        <?php if (isset($hasLiked) && $hasLiked):?>
		<a href="<?php echo APP_URL?>/project/unlike/<?php echo $row['pid']?>" class="btn btn-lg btn-default btn-block active" role="button">Liked</a>
	    <?php else: ?>
	    <a href="<?php echo APP_URL?>/project/like/<?php echo $row['pid']?>" class="btn btn-lg btn-info btn-block" role="button">Like this project</a>
	    <?php endif;?> 
<?php endif;?>
		<p class="text-muted" style="font-size: 12px; padding-top: 20px;"><?php echo $likeCount;?> people likes this project</p>
      </div>
      
    </div>
  </div>
  
  <div class="row" id="description">
    <div class="page-header">
      <h2>Detail</h2>	
    </div>
    <p><?php echo $row['description'];?></p>
  </div>
  
  <div class="row" id="comment">
    <div class="page-header">
      <h2>Comment</h2>
    </div>
    <form class="center-block" action="<?php echo APP_URL ?>/project/comment/<?php echo $row['pid']; ?>" method="post">
      <textarea class="form-control" style="resize: vertical;" rows="3" name="comment" required="required" placeholder="New comment"></textarea>
      <div class="form-group">
	    <br>
	    <button type="submit" role="button" class="btn btn-default btn-lg">Post</button>
	    <button type="reset" role="button" class="btn btn-default btn-lg">Cancel</button>
	  </div>
    </form>
    
  </div>
  
  <div class="row" style="padding-top:20px">
      <?php if (isset($comments)):?>
      <?php foreach ($comments as $comment):?>
        <div class="row comment">
        <h4 class="col-md-2"><strong><a href="<?php echo APP_URL . "/user/view/" . $comment['uname'];?>"><?php echo $comment['uname'];?></a></strong>
        <span class="help-block" style="font-size:14px"><?php echo $comment['time'];?></span></h4>
        
        <p class="col-md-10" style="font-size:14px;padding-top: 9px;"><?php echo $comment['content'];?></p>
        </div>
      <?php endforeach;?>
      <?php else:?>
        <p class="text-center">No comment yet
      <?php endif;?>
    </div>
  
</div>
<?php endswitch;?>