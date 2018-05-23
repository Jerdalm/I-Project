<?php 
	require 'header.php'; 
	require 'mechanic/productfilter.php';
?>
<header class="header content-header" 
style="background: linear-gradient( rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.4) ),
url('./img/header/horloge_header.jpg') center center no-repeat scroll;">
   <div class="container">
      <div class="row text-center">
         <div class="col-lg-12 " >
            <h1 class="display-3 text-center text-white"><?= $titel ?></h1>
			<p></p>
         </div>
      </div>
   </div>
</header>
<section class="products text-center">
<div class="row no-margin">
<div class="col-lg-3"></div>
<div class="col-lg-9 col-md-12 col-sm-12 col-xs-12" style=" display: flex; flex-wrap: wrap;">
<ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="index.php">Home</a></li>
  
  <?php if(!isset($rubriekBreadcrumb)){ ?>
  <li class="breadcrumb-item active"><?=$zoekfilter ?></li>
  <?php }else{
	  echo createRubriekBreadcrumb($rubriekBreadcrumb);
  } ?>

</ol>
</div>
</div>

<div class="container">
<div class="wrapper" style="margin-left:-15px; margin-right:-15px";>
<div class="col-lg-3 col-md-12 col-sm-12 col-xs-12 sidebar float-left" style="">
<h4 class="text-center"> Rubrieken </h4>
<?= showRubriekenlist();
require 'layout/distancefilter.php'; 
require 'layout/pricefilter.php'; 
?>
 
</div>
<div class="col-lg-9 col-md-12 col-sm-12 col-xs-12 no-margin float-left" style=" display: flex; flex-wrap: wrap;">
<?= showProducts(false,$query,$parameters); ?>
</div>

<div class="clearfix"></div>
</div>
</div>
</section>
<script>
setInterval(function()
{	
	$('.product-data').each(function() {
	$('#'+ this.id).load('overview.php #' + this.id);
});
}, 1000);

  
</script>
<?php require 'footer.php'; ?>