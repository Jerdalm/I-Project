<?php require_once 'header.php'; 
$mailAdres='';
$_SESSION['mailAdres'] = '';
if (isset($_POST['check'])) {
	$_SESSION['mailAdres'] = $_POST['mailadres'];
	$emailAdres = $_POST['mailadres'];
<<<<<<< HEAD:wachtwoordVergeten.php


=======
}

?>
<main>

<form method="POST" class="form-group">
    <label for="E-mailadres"> Voer hier uw E-mailadres in: </label>
        <input type="text" name="mailadres" class="form-control" id="mailadres" placeholder="E-mailadres" value="<?php echo $_SESSION['mailAdres'] ?>" >
        <input class="cta-orange btn" type="submit" name="check" value="Controlleer">

 <?php 

 
>>>>>>> db145cdc80013c9de57cdf5da85a2602359ff9ef:wachtwoord-vergeten.php
$emailParameters = array(':mailadres' => "$emailAdres");

$gebruiker = handlequery("SELECT *
 FROM Gebruiker JOIN GeheimeVraag
 on Gebruiker.vraag = GeheimeVraag.ID
 where mailadres = :mailadres 
 and
 Gebruiker.vraag = GeheimeVraag.ID", $emailParameters);
<<<<<<< HEAD:wachtwoordVergeten.php
}
// $_SESSION['mailadres'] = $gebruiker['mailadres']; 


=======
>>>>>>> db145cdc80013c9de57cdf5da85a2602359ff9ef:wachtwoord-vergeten.php

$email = $mailAdres;
$subject = 'Wachtwoord wijzigen';
$message = 'U heeft aangegeven dat u het wachtwoord wilt wijzigen. Uw nieuwe code is =';

$randomPassword = createRandomPassword(); 
$messageCode = $message . $randomPassword;
?>

<<<<<<< HEAD:wachtwoordVergeten.php







<main>


<form method="POST" class="form-group">
    <label for="E-mailadres"> Voer hier uw E-mailadres in: </label>
        <input type="text" name="mailadres" class="form-control" id="mailadres" placeholder="E-mailadres" value="<?php echo $_SESSION['mailAdres'] ?>" >
        <input class="cta-orange btn" type="submit" name="check" value="Controlleer">

 <?php  if( isset($_POST['mailadres']) && count($gebruiker) == 1 ) { ?>
=======
<?php if( isset($_POST['mailadres']) && count($gebruiker) == 1 ) { ?>
>>>>>>> db145cdc80013c9de57cdf5da85a2602359ff9ef:wachtwoord-vergeten.php
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