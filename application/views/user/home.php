<style>
.history {
	padding-bottom: 5px;
}
</style>
<div class="container">

  <div class="row">
    <div class="page-header">
      <h2>Projects</h2>
    </div>
      <?php if (isset($followingProjects)):?>
      <?php foreach ($followingProjects as $project):?>
        <div class="row history">
        <p class="text-center">
        <a href="<?php echo APP_URL."/user/view/".$project['uname']; ?>">
        <?php echo $project['uname']?>
        </a> posted <a href="<?php echo APP_URL."/project/view/".$project['pid']; ?>">
        <?php echo $project['pname']?></a> on <?php echo date('Y-m-d', strtotime($project['posttime']))?>.
        </p>
        </div>
      <?php endforeach;?>
      <?php else:?>
        <p class="text-center">None of those you are following posted any project yet.
      <?php endif;?>
  </div>
  
  <div class="row">
    <div class="page-header">
      <h2>Likes</h2>
    </div>
      <?php if (isset($followingLikes)):?>
      <?php foreach ($followingLikes as $like):?>
        <div class="row history">
        <p class="text-center">
        <a href="<?php echo APP_URL."/user/view/".$like['uname']; ?>">
        <?php echo $like['uname']?>
        </a> liked <a href="<?php echo APP_URL."/project/view/".$like['pid']; ?>">
        <?php echo $like['pname']?></a> at <?php echo $like['time']?>.
        </p>
        </div>
      <?php endforeach;?>
      <?php else:?>
        <p class="text-center">None of those you are following liked any project yet.
      <?php endif;?>
  </div>
  
  <div class="row">
    <div class="page-header">
      <h2>Comments</h2>
    </div>
      <?php if (isset($followingComments)):?>
      <?php foreach ($followingComments as $comment):?>
        <div class="row center-block" style="padding-bottom:30px">
        <blockquote style="text-align:left;width:auto;display:table;margin:0 auto;background: #fbfbfb;">
        <p><?php echo $comment['content'];?></p>
        <footer>
        <a href="<?php echo APP_URL."/user/view/".$comment['uname']; ?>">
        <?php echo $comment['uname']?>
        </a> commented on 
        <a href="<?php echo APP_URL."/project/view/".$comment['pid']; ?>">
        <?php echo $comment['pname']?></a> at <?php echo $comment['time']?>.
        </footer>
        </blockquote>        
        </div>
        
      <?php endforeach;?>
      <?php else:?>
        <p class="text-center">None of those you are following commented any project yet.
      <?php endif;?>
  </div>

  <div class="row">
    <div class="page-header">
      <h2>Pledges</h2>
    </div>
      <?php if (isset($followingPledges)):?>
      <?php foreach ($followingPledges as $pledge):?>
        <div class="row history">
        <p class="text-center">
        <a href="<?php echo APP_URL."/user/view/".$pledge['uname']; ?>">
        <?php echo $pledge['uname']?>
        </a> funded <a href="<?php echo APP_URL."/project/view/".$pledge['pid']; ?>">
        <?php echo $pledge['pname']?></a> with <strong class="text-success">$<?php echo $pledge['amount'];?></strong> at <?php echo $pledge['time']?>.
        </p>
        </div>
      <?php endforeach;?>
      <?php else:?>
        <p class="text-center">None of those you are following funded any project yet.
      <?php endif;?>
  </div>
  
  <div class="row">
    <div class="page-header">
      <h2>Rates</h2>
    </div>
      <?php if (isset($followingRates)):?>
      <?php foreach ($followingRates as $rate):?>
        <div class="row history">
        <p class="text-center">
        <a href="<?php echo APP_URL."/user/view/".$rate['uname']; ?>">
        <?php echo $rate['uname']?>
        </a> rated <a href="<?php echo APP_URL."/project/view/".$rate['pid']; ?>">
        <?php echo $rate['pname']?></a> with <strong class="text-success"><?php echo $rate['score'];?></strong> score at <?php echo $rate['time']?>.
        </p>
        </div>
      <?php endforeach;?>
      <?php else:?>
        <p class="text-center">None of those you are following rated any project yet.
      <?php endif;?>
  </div>
</div>