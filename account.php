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
	<a class="list-group-item list-group-item-action" id="list-auctions-won" data-toggle="list" href="#content-auctions-won" role="tab" aria-controls="auctions-won">Gewonnen veilingen</a>
    <a class="list-group-item list-group-item-action active" id="list-auctions-won" data-toggle="list" href="#content-user-details" role="tab" aria-controls="user-details">Gebruikersgegevens</a>
    </div>
</div>
	<div class="tab-content" id="nav-tabContent">
     <?php
	 require 'layout/user-details.php'; 
	 require 'layout/auctionswon.php';
	 ?>
    </div>
	

	<div class="clearfix"></div>
   </div>  
</section>   

<?php 

}else{header('Location:user.php');}
require_once 'footer.php'; 

?>
