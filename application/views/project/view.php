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
p {
	font-size: 21px;
}
</style>
<?php

?>
<div class="container">

  <div class="row">
    <div class="col-md-12 jumbotron">
      <div class="row" id="pname">
        <h1><?php echo $row['pname'];?></h1>
      </div>
      <div class="row" id="uname">
        <p class="text-muted">By <?php echo $row['uname'] . " on " . date('Y-m-d', strtotime($row['posttime']));?></p>
        
        <?php if (!empty($row['tag'])):?>
        <?php foreach (explode(",", $row['tag']) as $tag):?>
          <form name="tagsearch" action="<?php echo APP_URL ?>/project/search/tag" method='post'>
            <input type="hidden" name="keyword" value="<?php echo $tag; ?>"/>
            <a href="javascript:document.tagsearch.submit();" class="label label-default"><?php echo $tag;?></a>
          </form>
        <?php endforeach;?>
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
        <a href="#" class="btn btn-lg btn-primary btn-block" role="button">Like this project</a>
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
  </div>
</div>