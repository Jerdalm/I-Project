<?php
require_once 'header.php'; 

$gebruikersnaam = $_SESSION['gebruikersnaam'];
$emailParameters = array(':gebruikersnaam' => "$gebruikersnaam");

$gebruiker = handlequery("SELECT * FROM Gebruiker JOIN Vraag ON Gebruiker.vraag = Vraag.vraagnummer WHERE gebruikersnaam = :gebruikersnaam AND Gebruiker.vraag = Vraag.vraagnummer", $emailParameters);

$email = $gebruiker[0]['mailadres'];
$subject = 'Wachtwoord wijzigen';
$message = 'U heeft aangegeven dat u het wachtwoord wilt wijzigen. Uw nieuwe code is =';

$nieuwePassword = ''; 
$messageCode = $message . $nieuwePassword;

$correct = false;


?>

<main class="user-details">
    <div class="container">

        <div class="row row-left">                
            <img src="" class="profile-pic">                
        </div>
        <div class="row row-right">
            <!-- alle gegevens van de gebruiker worden met een echo in een tabel gezet -->
            <table class="table"> 
                <thead>
                    <tr>
                     <th scope="col">Gebruikersnaam </th>
                     <td> <?= $gebruikersnaam ?> </td>
                 </tr>
             </thead>
             <tbody>
                <tr>
                    <th scope="row">Land</th>
                    <td><?= $gebruiker[0]['land'] ?> </td>
                </tr>
                <tr>
                    <th scope="row">Woonplaats</th>
                    <td><?php echo $gebruiker[0]['plaatsnaam'] ?> </td>
                </tr>
                <tr>
                    <th scope="row">Geboortedatum</th>
                    <td><?php echo $gebruiker[0]['geboortedag'] ?> </td>
                </tr>    

                <tr>
                    <th scope="row">E-mailadres</th>
                    <td><?php echo $gebruiker[0]['mailadres'] ?> </td>
                </tr>
                <tr>
                    <th scope="row">Voornaam</th>
                    <td><?php echo $gebruiker[0]['voornaam'] ?> </td>
                </tr>
                <tr>
                    <th scope="row">Achternaam</th>
                    <td><?php echo $gebruiker[0]['achternaam'] ?> </td>
                </tr>
                <tr>
                    <th scope="row">Telefoonnummer</th>

                </tr>
                <tr>
                    <th scope="row">Postcode</th>
                    <td><?php echo $gebruiker[0]['postcode'] ?> </td>
                </tr>
                <tr>
                    <th scope="row">Wachtwoord</th>
                    <td>  <a  href= <?="?changePass=ok" ?>  > <b><i>Wachtwoord wijzigen</i></b> </a></td>
                </tr>
            </tbody>    
        </table>
        <form class="form-group" action="upgrade-user.php">
            <input type="submit" class="cta-orange btn" value="Upgrade account"><br>
        </form>
    </div>
    <div class="formWachtwoordHuidig col-md-4 row">
        <?php if(isset($_GET['changePass'])){ ?>

        <form method="POST" class="form-steps" action="">

         <div class="form-group">

            <label for="testvoorvraag"> Huidig Wachtwoord </label>
            <input type="password" name="huidigWachtwoord" class="form-control" id="testAntwoordvakje" placeholder="Voer hier uw huidige wachtwoord in">
        </div>


        <div class="form-group">
            <label for="registration-password">Wachtwoord</label>
            <input type="password" placeholder="Voer uw nieuwe wachtwoord in" class="form-control" name="password" id="registration-password">
        </div>
        <div class="form-group">
            <label for="password-repeat">Herhaal wachtwoord</label>
            <input type="password" class="form-control" placeholder="Herhaal uw nieuwe wachtwoord" name="password-repeat" id="password-repeat">
        </div>

        <button type="submit" name="submit-new-password" value="Register" class="btn btn-primary btn-sm">Verzenden</button>
    </form>
   

    <!--    als er op de knop word geklikt van wachtwoord wijzigen dan komt er een form met de geheime vraag erin daarvoor is de code hieronder. -->

    <?php }
                // de query om de geheime vraag op te halen en te checken of het antwoord klopt. Ook om de mail te verzenden met de nieuwe wachtwoord. 
 

if(isset($_POST['submit-new-password'])){

    if ($_POST['password'] != $_POST['password-repeat']){

    echo 'wachtwoorden komen niet overeen!';
    die();
}

  $huidigWachtwoord = $_POST['huidigWachtwoord'];
       $wachtwoordParameters = array(':wachtwoord' => "$huidigWachtwoord" , 
          ':gebruiker' => "$gebruikersnaam" );
       $antwoord = handlequery("SELECT wachtwoord
         FROM Gebruiker
         WHERE wachtwoord = :wachtwoord
         AND gebruikersnaam = :gebruiker" , $wachtwoordParameters);

       if (count($antwoord) == 1 && $_POST['password'] == $_POST['password-repeat']){

        $correct = true;
    } elseif ($correct!=true) {
        
        echo 'Wachtwoord is onjuist!';
         die();
    }
if($correct){
    $nieuwePassword = $_POST['password'];
   echo 'Uw wachtwoord is gewijzigd!';
    handlequery("UPDATE Gebruiker SET wachtwoord = '$nieuwePassword' WHERE gebruikersnaam = '$gebruikersnaam'");
}

}






?>       
</div>
</div>

</main>

<?php require_once 'footer.php'; ?>

