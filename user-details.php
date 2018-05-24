<?php
require_once 'header.php'; 

$gebruikersnaam = $_SESSION['gebruikersnaam'];
$emailParameters = array(':gebruikersnaam' => $gebruikersnaam);
$messageNewPassword = ' ';
$gebruiker = FetchAssocSelectData("SELECT TOP 1 Gebruiker.gebruikersnaam,voornaam,achternaam,adresregel1,adresregel2,postcode,plaatsnaam,land,geboortedag,mailadres,telefoonnummer FROM Gebruiker 
   LEFT join Gebruikerstelefoon on Gebruiker.gebruikersnaam = Gebruikerstelefoon.gebruikersnaam
   WHERE Gebruiker.gebruikersnaam = :gebruikersnaam", $emailParameters);

$email = $gebruiker['mailadres'];
$subject = 'Wachtwoord wijzigen';
$message = 'U heeft aangegeven dat u het wachtwoord wilt wijzigen. Uw nieuwe code is =';

$nieuwePassword = ''; 
$messageCode = $message . $nieuwePassword;

$correct = false;

if(isset($_POST['submit-new-password'])){

    $huidigWachtwoord = $_POST['huidigWachtwoord'];
    $wachtwoordParameters = array(':wachtwoord' => "$huidigWachtwoord", ':gebruiker' => "$gebruikersnaam" );
    $antwoord = handlequery("SELECT wachtwoord FROM Gebruiker WHERE wachtwoord = :wachtwoord AND gebruikersnaam = :gebruiker" , $wachtwoordParameters);

    if (count($antwoord) == 1){
        if (checkNewPassword($_POST['password'], $_POST['password-repeat']) == "Wachtwoord zit in de database") {
            $nieuwePassword = $_POST['password'];
            handlequery("UPDATE Gebruiker SET wachtwoord = '$nieuwePassword' WHERE gebruikersnaam = '$gebruikersnaam'");
            $messageNewPass = checkNewPassword($_POST['password'], $_POST['password-repeat']);
        } else {
            $messageNewPass = checkNewPassword($_POST['password'], $_POST['password-repeat']);
        }
    } else {
        $messageNewPass = "Het huidige wachtwoord klopt niet";
    }
}

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

<?php require_once 'footer.php'; ?>
