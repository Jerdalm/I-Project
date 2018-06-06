<?php
$gebruikersnaam = $_SESSION['gebruikersnaam'];
$emailParameters = array(':gebruikersnaam' => $gebruikersnaam);
$messageNewPassword = ' ';
// fetch alle data van de gebruiker inclusief de telefoonnummer
$gebruiker = FetchAssocSelectData("SELECT Gebruiker.gebruikersnaam,voornaam,achternaam,adresregel1,adresregel2,postcode,plaatsnaam,land,geboortedag,mailadres,telefoonnummer FROM Gebruiker 
   left join Gebruikerstelefoon on Gebruiker.gebruikersnaam = Gebruikerstelefoon.gebruikersnaam
   WHERE Gebruiker.gebruikersnaam = :gebruikersnaam", $emailParameters);

$telefoonPara = array(':gebruikersnaam' => $gebruikersnaam);
$telefoonnummers = handlequery("SELECT telefoonnummer,volgnr FROM Gebruikerstelefoon WHERE gebruikersnaam = :gebruikersnaam",$telefoonPara);
$aantalTelefoonNummers = count($telefoonnummers);


$email = $gebruiker['mailadres'];
$subject = 'Wachtwoord wijzigen';
$message = 'U heeft aangegeven dat u het wachtwoord wilt wijzigen. Uw nieuwe code is =';

$nieuwePassword = ''; 
$messageCode = $message . $nieuwePassword;
$correct = false;
// checkt de input van de nieuwe wachtwoord en checkt ook of de nieuwe wachtwoord voldoet aan de eisen. Ook checkt dit gedeelte of het huidige wachtwoord juist is.
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

<div class="tab-pane show col-lg-9 float-left active" id="content-user-details" role="tabpanel" aria-labelledby="list-user-details">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center"><h3>Gebruikersgegevens</h3></div>
		<div class="row justify-content-md-center">
        
		<!-- alle gegevens van de gebruiker worden met een echo in een tabel gezet -->
		
		<div id="detailsTabel" class=" text-center col-lg-8 col-md-12 col-sm-12 col-xs-12 table-responsive">	
            <table class="table-striped table table-user-details"> 
                <tbody>
                    <?php foreach($gebruiker as $key => $info ){
                   if($key == 'telefoonnummer'){
                    
                    continue;
                   }
                        echo "<tr>" . "<th scope='col'>" . $key . "</th" . "</tr>";
                        echo "<td>" . $info . "</td>";
                     } 
                     if($telefoonnummers != null){
                        foreach($telefoonnummers as $nummer){
                       
                        echo "<tr>" . "<th scope='col'>" . 'telefoonnummer'. "</th" . "</tr>";
                        echo "<td>" . $nummer[0] . "</td>";

                          }
                          } else {
                        echo "<tr>" . "<th scope='col'>" . 'telefoonnummer' . "</th" . "</tr>";
                        echo "<td>"  . "</td>";
                     } ?>
                </tbody>
            </table>
           
            <!-- Button trigger modal -->
		</div>
		<div class="col-lg-8 col-md-12 col-sm-12 col-xs-12 text-center">
		<button type="button" class="btn btn-orange" data-toggle="modal" data-target="#changePass">Wachtwoord wijzigen</button>
		<button type="button" class="btn btn btn-success" data-toggle="modal" data-target="#changeInfo">Info bewerken</button>
		
		<?php
		if (isset($messageNewPass)){
			echo '<p class="error error-warning">';
            echo $messageNewPass;
			echo '</p>';	
        }
		?>
		
		</div>
		<?php require 'changepassModal.php'; ?>
		<?php require 'changeinfoModal.php'; ?>
		</div>
        <?php 		
		  

		
       if (isset($_GET['bijwerken'])) {

           UpdateInfoUser($_GET, $gebruikersnaam,$gebruiker,$telefoonnummers);
       }?> 
	   </div>
	   
		<!-- offset-lg-2 -->