<?php
require_once 'header.php';
if(isset($_SESSION['gebruikersnaam'])){
?>
<header id="account" class="header content-header">
   <div class="container">
      <div class="row text-center">
         <div class="col-lg-12 " >
            <h1 class="display-3 text-center text-white">Account</h1>
         </div>
      </div>
   </div>
</header>
<section class="user-details">
    <div class="container">
	<div class="col-lg-3 sidebar float-left">
    <div class="list-group" id="list-tab" role="tablist">

	
  <a class="list-group-item list-group-item-action active" id="list-user-details" data-toggle="list" href="#content-user-details" role="tab" aria-controls="user-details">Gebruikersgegevens</a>
  
    
        <?php
        if($_SESSION['soortGebruiker'] > 1){ ?>
    <a class="list-group-item list-group-item-action" id="list-my-auctions" data-toggle="list" href="#content-my-auctions" role="tab" aria-controls="my-auctions">Mijn veilingen</a>
    <a class="list-group-item list-group-item-action" id="list-upload-article" data-toggle="list" href="#content-upload-article" role="tab" aria-controls="upload-article">Verkoop voorwerp</a>
        <?php } ?>
    <a class="list-group-item list-group-item-action" id="list-offering-in" data-toggle="list" href="#content-offering-in" role="tab" aria-controls="offering-in">Geboden op</a>
    <a class="list-group-item list-group-item-action" id="list-auctions-won" data-toggle="list" href="#content-auctions-won" role="tab" aria-controls="auctions-won">Gewonnen veilingen</a>

	<input type="button" onclick="frames['frame1'].print()" value="print!">

	<?php
	if($_SESSION['soortGebruiker'] < 2){ ?>
	<a class="list-group-item list-group-item-action" id="list-seller-registration" data-toggle="list" href="#content-seller-registration" role="tab" aria-controls="seller-registration">Verkoper registratie</a>
	<?php } ?>
    </div>
</div>
	<div class="tab-content" id="nav-tabContent">
     <?php
   require 'layout/user-details.php';
   require 'layout/auctionswon.php';
   require 'layout/upload-article-tab.php';
     require 'layout/my-auctions.php';
     require 'layout/offering-in.php';
   require 'layout/seller-registration.php';

	 ?>
    </div>
	<div class="clearfix"></div>
   </div>
</section>

<?php

}else{redirectJS('user.php');}
require_once 'footer.php';

?>
