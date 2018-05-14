<?php require 'header.php'; 
?>
<header class="header content-header" 
style="background: linear-gradient( rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.4) ),
url('./img/header/horloge_header.jpg') center center no-repeat scroll;">
   <div class="container">
      <div class="row text-center">
         <div class="col-lg-12 " >
            <h1 class="display-3 text-center text-white">Horloges</h1>
			<p></p>
         </div>
      </div>
   </div>
</header>
<section class="products">
<div class="container">
<div class = "row">
<div class="col-md-3 sidebar" style="">
<h4 class="text-center"> Rubrieken </h4>
 <?= showRubriekenlist(); ?>
</div>
<div class="col-md-9" style=" display: flex; flex-wrap: wrap;">
<?= showProducts(); ?>
</div>
</div>
</div>
</section>
<?php require 'footer.php'; ?>
