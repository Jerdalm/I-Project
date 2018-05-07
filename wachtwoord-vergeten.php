<?php require_once 'header.php'; 
$mailAdres='';
$_SESSION['mailAdres'] = '';
if (isset($_POST['check'])) {
	$_SESSION['mailAdres'] = $_POST['mailadres'];
	$emailAdres = $_POST['mailadres'];
}

?>
<main>

<form method="POST" class="form-group">
    <label for="E-mailadres"> Voer hier uw E-mailadres in: </label>
        <input type="text" name="mailadres" class="form-control" id="mailadres" placeholder="E-mailadres" value="<?php echo $_SESSION['mailAdres'] ?>" >
        <input class="cta-orange btn" type="submit" name="check" value="Controlleer">

 <?php 

 
$emailParameters = array(':mailadres' => "$emailAdres");

$gebruiker = handlequery("SELECT *
 FROM Gebruiker JOIN GeheimeVraag
 on Gebruiker.vraag = GeheimeVraag.ID
 where mailadres = :mailadres 
 and
 Gebruiker.vraag = GeheimeVraag.ID", $emailParameters);

$email = $mailAdres;
$subject = 'Wachtwoord wijzigen';
$message = 'U heeft aangegeven dat u het wachtwoord wilt wijzigen. Uw nieuwe code is =';

$randomPassword = createRandomPassword(); 
$messageCode = $message . $randomPassword;
?>

<?php if( isset($_POST['mailadres']) && count($gebruiker) == 1 ) { ?>
<form method="POST" class="form-group">
    <label for="testvoorvraag">  <?php echo $gebruiker[0]['vraag']?> </label>
        <input type="text" name="antwoord" class="form-control" id="testAntwoordvakje" placeholder="Antwoord">
        <input class="cta-orange btn" type="submit" name="verzenden" value="Verzenden">
</form>

<?php }  ?>


</main>

 <?php     if (isset ($_POST['verzenden'])){

$antwoordtekst = $_POST['antwoord'];

$answerParameters = array(':antwoord' => "$antwoordtekst" , 
                          ':mailadres' => "$mailAdres" );

$antwoord = handlequery("SELECT antwoordtekst
                         FROM Gebruiker
                         WHERE antwoordtekst = :antwoord
                         AND mailadres = :mailadres" , $answerParameters);



if (count($antwoord) == 1) {

    $correct = true;

} else {

    $correct = false;

    }

if ($correct == true){

sendMail($email,$subject,$messageCode);

handlequery("UPDATE Gebruiker SET wachtwoord = '$randomPassword' WHERE mailadres = '$mailAdres' ");




} else {echo 'shit';}
}



?>
<?php require_once 'footer.php'; ?>