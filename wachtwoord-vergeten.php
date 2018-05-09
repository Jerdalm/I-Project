<?php require_once 'header.php'; 
$emailAdres='';
$_SESSION['mailAdres'] = '';
if (isset($_POST['check'])) {
	$_SESSION['mailAdres'] = $_POST['mailadres'];
	$emailAdres = $_POST['mailadres'];
}
$emailParameters = array(':mailadres' => "$emailAdres");
$gebruiker = handlequery("SELECT * FROM Gebruiker JOIN Vraag ON Gebruiker.vraag = Vraag.vraagnummer WHERE mailadres = :mailadres 
   AND Gebruiker.vraag = Vraag.vraagnummer", $emailParameters);

// $_SESSION['mailadres'] = $gebruiker['mailadres']; 

$email = $emailAdres;
$subject = 'Wachtwoord wijzigen';
$message = 'U heeft aangegeven dat u het wachtwoord wilt wijzigen. Uw nieuwe code is =';

$randomPassword = createRandomPassword(); 
$messageCode = $message . $randomPassword;
?>

<main>
  <div class="container">
    <div class="inputMailadres col-md-6">
    <form id="formMail" method="POST" class="form-group">
        <label for="E-mailadres">Voer hier uw E-mailadres in: </label>
        <input type="text" name="mailadres" class="form-control" id="mailadres" placeholder="E-mailadres" value="<?= $_SESSION['mailAdres'] ?>" >
        <input class="cta-orange btn" type="submit" name="check" value="Controlleer">
 </div>
        <?php 
        if( isset($_POST['mailadres']) && count($gebruiker) == 1 ) { 
            ?>
             <div class="inputAntwoord col-md-6">

            <form id="formAntwoord" method="POST" class="form-group">
                <label for="testvoorvraag">  <?= $gebruiker[0]['vraag']?> </label>
                <input type="text" name="antwoord" class="form-control" id="testAntwoordvakje" placeholder="Antwoord">
                <input class="cta-orange btn" type="submit" name="verzenden" value="Verzenden">
            </form>
          </div>
            <?php 
        }  
        if (isset ($_POST['verzenden'])){
            $antwoordtekst = $_POST['antwoord'];
            $emailAdres = $_POST['mailadres'];
            $answerParameters = array(':antwoord' => "$antwoordtekst", ':mailadres' => "$emailAdres" );
            $antwoord = handlequery("SELECT antwoordtekst FROM Gebruiker WHERE antwoordtekst = :antwoord AND mailadres = :mailadres", $answerParameters);

            if (count($antwoord) == 1) {
                sendMail($email,$subject,$messageCode);
                handlequery("UPDATE Gebruiker SET wachtwoord = '$randomPassword' WHERE mailadres = '$emailAdres' ");

            } else {
                echo 'foutmelding';
            }
        }
        ?>
    </form>
  </div>
 
</main>
<?php require_once 'footer.php'; ?>