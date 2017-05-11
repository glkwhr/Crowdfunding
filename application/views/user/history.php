<style>
.history {
	padding-bottom: 5px;
}
</style>
<div class="container">

  <div class="row">
    <div class="page-header">
      <h2>Search History <small><a href="<?php echo APP_URL."/user/clearSearch"?>">clear</a></small></h2>
    </div>
      <?php if (isset($searchHistory)):?>
      <?php foreach ($searchHistory as $search):?>
        <div class="row history text-center">
        <form name="<?php echo $search['keyword'];?>" action="<?php echo APP_URL ?>/project/search" method='post'>
            <input type="hidden" name="keyword" value="<?php echo $search['keyword']; ?>"/>
            <p class="history"> You searched <a href="javascript:document.<?php echo $search['keyword'];?>.submit();"><?php echo $search['keyword'];?></a> at <?php echo $search['time']?>.
        </form>
        </div>
      <?php endforeach;?>
      <?php else:?>
        <p class="text-center">You have not searched any project yet.
      <?php endif;?>
  </div>
  
  <div class="row">
    <div class="page-header">
      <h2>Like History</h2>
    </div>
      <?php if (isset($likeHistory)):?>
      <?php foreach ($likeHistory as $like):?>
        <div class="row history">
        <p class="text-center">
        You liked <a href="<?php echo APP_URL."/project/view/".$like['pid']; ?>">
        <?php echo $like['pname']?></a> at <?php echo $like['time']?>.
        </p>
        </div>
      <?php endforeach;?>
      <?php else:?>
        <p class="text-center">You have not liked any project yet.
      <?php endif;?>
  </div> 
  
  <div class="row">
    <div class="page-header">
      <h2>Pledge History</h2>
    </div>
      <?php if (isset($pledgeHistory)):?>
      <?php foreach ($pledgeHistory as $pledge):?>
        <div class="row history">
        <p class="text-center">
        You funded <a href="<?php echo APP_URL."/project/view/".$pledge['pid']; ?>">
        <?php echo $pledge['pname']?></a> with <strong class="text-success">$<?php echo $pledge['amount'];?></strong> at <?php echo $pledge['time']?>.
        </p>
        </div>
      <?php endforeach;?>
      <?php else:?>
        <p class="text-center">You have not funded any project yet.
      <?php endif;?>
  </div>  

  <div class="row">
    <div class="page-header">
      <h2>Rate History</h2>
    </div>
      <?php if (isset($rateHistory)):?>
      <?php foreach ($rateHistory as $rate):?>
        <div class="row history">
        <p class="text-center">
        You rated <a href="<?php echo APP_URL."/project/view/".$rate['pid']; ?>">
        <?php echo $rate['pname']?></a> with <strong class="text-info"><?php echo $rate['score'];?></strong> scores at <?php echo $rate['time']?>.
        </p>
        </div>
      <?php endforeach;?>
      <?php else:?>
        <p class="text-center">You have not rated any project yet.
      <?php endif;?>
  </div>  

</div>