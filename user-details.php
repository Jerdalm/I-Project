<?php
require_once 'header.php'; 

$gebruikersnaam = $_SESSION['gebruikersnaam'];
$emailParameters = array(':gebruikersnaam' => "$gebruikersnaam");
$messageNewPassword = ' ';
$gebruiker = FetchAssocSelectData("SELECT * FROM Gebruiker join Gebruikerstelefoon on Gebruiker.gebruikersnaam = Gebruikerstelefoon.gebruikersnaam WHERE gebruiker.gebruikersnaam = :gebruikersnaam", $emailParameters);

$email = $gebruiker['mailadres'];
$subject = 'Wachtwoord wijzigen';
$message = 'U heeft aangegeven dat u het wachtwoord wilt wijzigen. Uw nieuwe code is =';

$nieuwePassword = ''; 
$messageCode = $message . $nieuwePassword;

$correct = false;
print_r($gebruiker);
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

<main class="user-details">
    <div class="container">

        <div id="profile-picture" class="row row-left">                
            <img src="img/geit.jpg" class="profile-pic">                
        </div>
        <div id="detailsForm" class="row row-right">
            <!-- alle gegevens van de gebruiker worden met een echo in een tabel gezet -->
             <?php if(!isset($_GET['changeInfo'])) {?>
            <table class="table"> 
                <tbody>
                    <?php foreach($gebruiker as $key => $info ){
                         if ($key == 'wachtwoord' || $key == 'gebruikersnaam' || $key == 'vraag' || $key == 'antwoordtekst' || $key == 'volgnr' ) continue;
                        echo "<tr>" . "<th scope='col'>" . $key . "</th" . "</tr>";
                        echo "<td>" . $info . "</td>";
                    } ?>
                    <td><a href="?&changeInfo=ok" <b>Info Bewerken</a></b></td>
                </tbody>
            </table>

            
        <form id="editUserInfo" method="GET" class="form-group">
            
            <?php } else if (isset($_GET['changeInfo'])){ 
                        foreach ($gebruiker as $key => $value) { 
                            if ($key == 'wachtwoord' || $key == 'gebruikersnaam' || $key == 'vraag' || $key == 'antwoordtekst' || $key == 'volgnr' ) continue;
                           
                            echo '<label><b>'. $key .'</b></label><input type="text" name="' . $key . '" value="'. $value .'">';
                            
             }

        }    ?>
                <input type="submit" class="cta-orange btn" name="bijwerken" value="Bijwerken"> 
                <input type="submit" class="cta-orange btn" value="Upgrade account">
        </form>

    

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
            
            <?php 
            } 
            echo '<p class="error error-warning">';
            if (isset($messageNewPass)){
                echo $messageNewPass;
            }
            echo '</p>';
            ?>
        </div>

</main>

<?php require_once 'footer.php'; ?>
