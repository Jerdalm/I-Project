<?php require_once 'header.php'; 
$emailAdres='';
$_SESSION['mailAdres'] = '';
if (isset($_POST['check'])) {
	$_SESSION['mailAdres'] = $_POST['mailadres'];
	$emailAdres = $_POST['mailadres'];

}

?>
<main>



 <?php 

 

$emailParameters = array(':mailadres' => "$emailAdres");

$gebruiker = handlequery("SELECT *
 FROM Gebruiker JOIN Vraag
 on Gebruiker.vraag = Vraag.vraagnummer
 where mailadres = :mailadres 
 and
 Gebruiker.vraag = Vraag.vraagnummer", $emailParameters);


// $_SESSION['mailadres'] = $gebruiker['mailadres']; 




$email = $emailAdres;
$subject = 'Wachtwoord wijzigen';
$message = 'U heeft aangegeven dat u het wachtwoord wilt wijzigen. Uw nieuwe code is =';

$randomPassword = createRandomPassword(); 
$messageCode = $message . $randomPassword;
?>












<form method="POST" class="form-group">
    <label for="E-mailadres"> Voer hier uw E-mailadres in: </label>
        <input type="text" name="mailadres" class="form-control" id="mailadres" placeholder="E-mailadres" value="<?php echo $_SESSION['mailAdres'] ?>" >
        <input class="cta-orange btn" type="submit" name="check" value="Controlleer">

 

<?php if( isset($_POST['mailadres']) && count($gebruiker) == 1 ) { ?>

<form method="POST" class="form-group">
    <label for="testvoorvraag">  <?php echo $gebruiker[0]['vraag']?> </label>
        <input type="text" name="antwoord" class="form-control" id="testAntwoordvakje" placeholder="Antwoord">
        <input class="cta-orange btn" type="submit" name="verzenden" value="Verzenden">
</form>

<?php }  ?>




 <?php     if (isset ($_POST['verzenden'])){

$antwoordtekst = $_POST['antwoord'];
$emailAdres = $_POST['mailadres'];

$answerParameters = array(':antwoord' => "$antwoordtekst" , 
                          ':mailadres' => "$emailAdres" );

$antwoord = handlequery("SELECT antwoordtekst
                         FROM Gebruiker
                         WHERE antwoordtekst = :antwoord
                         AND mailadres = :mailadres" , $answerParameters);



if (count($antwoord) == 1) {

    sendMail($email,$subject,$messageCode);

handlequery("UPDATE Gebruiker SET wachtwoord = '$randomPassword' WHERE mailadres = '$emailAdres' ");

} else {
  echo 'shit';}
}

    






?>
</main>
<?php require_once 'footer.php'; ?>