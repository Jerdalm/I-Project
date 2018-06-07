<?php require_once 'header.php'; 
$emailAdres = '';
$_SESSION['mailAdres'] = $emailAdres;

if (isset($_POST['check'])) {
    $emailAdres = $_POST['mailadres'];
    $_SESSION['mailAdres'] = $emailAdres;
}
$emailParameters = array(':mailadres' => "$emailAdres");
$gebruiker = handlequery("SELECT * FROM Gebruiker JOIN Vraag ON Gebruiker.vraag = Vraag.vraagnummer WHERE mailadres = :mailadres 
 AND Gebruiker.vraag = Vraag.vraagnummer", $emailParameters);

// $_SESSION['mailadres'] = $gebruiker['mailadres']; 

$wachtwoordGereset = false;
$subject = 'Wachtwoord wijzigen';
$message = 'U heeft aangegeven dat u het wachtwoord bent vergeten. U krijgt van ons een nieuw wachtwoord waarmee u kunt inloggen en vervolgens kunt u deze op uw accountgegevenspagina weer wijzigen. 
Uw nieuwe wachtwoord is = ';

$randomPassword = createRandomPassword(); 
$messageCode = $message . $randomPassword;
?>

<main id="wachtwoordVergeten">
   <section class="forgotpass">
      <div class="container">
        <div class="row justify-content-md-center">
            <div class="col-md-4">
                <div class="card">
                    <article class="card-body">

                        <h4 class="card-title mb-4 mt-1">Wachtwoord vergeten</h4>
                        <form method="post">
                            <div class="form-group">
                                <label>E-mail</label>
                                <?php if(isset($errormessage)) echo $errormessage ?>
                                <input  value=<?= '"' .$_SESSION['mailAdres'].'"' ?> class="form-control" placeholder="Voer uw emailadres in..." type="text"  id="email-check" name="mailadres">
                            </div>
                            <div class="form-group">
                                <button type="submit" name="check" class="btn btn-primary btn-block"> Controlleer </button>
                            </div> 
                            <?php if( isset($_POST['mailadres']) && count($gebruiker) == 1 ) { ?>
                            <div class="form-group">
                                <label for="testvoorvraag">  <?= $gebruiker[0]['vraag']?> </label>
                                <input type="text" name="antwoord" placeholder="Typ hier uw antwoord" class="form-control">
                            </div>
                            <div>
                             <button name="verzenden" class="btn btn-primary btn-block"> Verzenden</button>
                            </div>  
                         <?php } else{ 
                            $errormessage = 'E-mail adres is onjuist!';
                        }
                            ?>
                     </form>
                 </article>
             </div>
         </div>
     <?php 
        // als op de knop verzenden word geklikt dan word de onderstaande query uitgevoerd

     if (isset ($_POST['verzenden'])){
        $antwoordtekst = $_POST['antwoord'];
        $emailAdres = $_POST['mailadres'];
        $answerParameters = array(':antwoord' => "$antwoordtekst", ':mailadres' => "$emailAdres" );
        $antwoord = handlequery("SELECT antwoordtekst FROM Gebruiker WHERE antwoordtekst = :antwoord AND mailadres = :mailadres", $answerParameters);
        // hier word gecheckt of het antwoord klopt
        if (count($antwoord) == 1) {
            $wachtwoordGereset = true;
            $newPassword = trim($randomPassword);
            sendMail($emailAdres,$subject,$messageCode);
            $updatePasswordParameters = array(':mailadres' => $emailAdres,':wachtwoord' => $newPassword);
            handlequery("UPDATE Gebruiker SET wachtwoord = :wachtwoord WHERE mailadres = :mailadres",$updatePasswordParameters);
        } else {
          $errormessage = 'Antwoord is onjuist!';
        }
    }

    ?>
        <?php if($wachtwoordGereset){ 
            echo '<div class="row">
            <div class="col-lg-12 text-center"><H4>Uw wachtwoord is gereset! Er is een mail gestuurd naar uw E-mail adres.</H4></div>
            <div class="col-lg-12 text-center"><a class="btn btn-primary btn-small" href="user.php">Klik hier om naar het inlogscherm te gaan.</a></div></div>';
        } ?>
     </div>
</form>
</div>



</section>
</main>
<?php require_once 'footer.php'; ?>