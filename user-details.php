<?php
require_once 'header.php'; 

$gebruikersnaam = $_SESSION['gebruikersnaam'];
$emailParameters = array(':gebruikersnaam' => "$gebruikersnaam");

$gebruiker = handlequery("SELECT * FROM Gebruiker JOIN Vraag ON Gebruiker.vraag = Vraag.vraagnummer WHERE gebruikersnaam = :gebruikersnaam AND Gebruiker.vraag = Vraag.vraagnummer", $emailParameters);

$email = $gebruiker[0]['mailadres'];
$subject = 'Wachtwoord wijzigen';
$message = 'U heeft aangegeven dat u het wachtwoord wilt wijzigen. Uw nieuwe code is =';

$randomPassword = createRandomPassword(); 
$messageCode = $message . $randomPassword;

?>


<main class="user-details">
    <div class="container">
        
            <div class="row row-left">                
                <img src="img/geit.jpg" class="profile-pic">                
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

            <?php if(isset($_GET['changePass'])){?>
          <!--    als er op de knop word geklikt van wachtwoord wijzigen dan komt er een form met de geheime vraag erin daarvoor is de code hieronder. -->
                <form method="POST" class="form-group">
                    <label for="testvoorvraag">  <?php echo $gebruiker[0]['vraag']?> </label>
                    <input type="text" name="antwoord" class="form-control" id="testAntwoordvakje" placeholder="Antwoord">
                    <input class="cta-orange btn" type="submit" name="verzenden" value="Verzenden">
                </form>

                <?php }
                // de query om de geheime vraag op te halen en te checken of het antwoord klopt. Ook om de mail te verzenden met de nieuwe wachtwoord. 
                if (isset ($_POST['verzenden'])){
                    $antwoordtekst = $_POST['antwoord'];
                    $answerParameters = array(':antwoord' => "$antwoordtekst" , 
                      ':gebruiker' => "$gebruikersnaam" );
                    $antwoord = handlequery("SELECT antwoordtekst
                     FROM Gebruiker
                     WHERE antwoordtekst = :antwoord
                     AND gebruikersnaam = :gebruiker" , $answerParameters);
                    if (count($antwoord) == 1){
                        $correct = true;
                    } else {
                        $correct = false;
                    }
                    if ($correct == true){
                        sendMail($email,$subject,$messageCode);
                        handlequery("UPDATE Gebruiker SET wachtwoord = '$randomPassword' WHERE gebruikersnaam = '$gebruikersnaam' ");
                    } else {
                        echo 'er is wat fout gegaan';
                    }
                }
                ?>       
            </div>

    </div>
</main>

<?php require_once 'footer.php'; ?>

