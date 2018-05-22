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

<main class="user-details">
    <div class="container">
        <?php if(!isset($_GET['changeInfo'])) {?>
        <div id="detailsTabel" class="row row-right">
            <!-- alle gegevens van de gebruiker worden met een echo in een tabel gezet -->
            <table class="table table-user-details"> 
                <tbody>
                    <?php foreach($gebruiker as $key => $info ){
                   
                        echo "<tr>" . "<th scope='col'>" . $key . "</th" . "</tr>";
                        echo "<td>" . $info . "</td>";
                     } ?>
                     <tr>
                        <th>Wachtwoord</th>
                        <td><a href="?&changePass=ok"> <b><i>Wachtwoord Wijzigen</a></i></b></td>
                    </tr>
                    <tr> 
                        <td><a href="?&changeInfo=ok"> <b>Info Bewerken</a></b></td>   
                    </tr>
                </tbody>
            </table>
            <A href="upgrade-user.php" class="cta-orange btn">Upgrade account</A>
        </div>

        <?php } if(isset($_GET['changePass'])){ ?>
        <div class="formWachtwoordHuidig col-md-4 row">
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
        </div>
        <?php 
            echo '<p class="error error-warning">';
            if (isset($messageNewPass)){
                echo $messageNewPass;
            }
            echo '</p>';
        } else if (isset($_GET['changeInfo'])){ ?>
            <form method="get" class="form-group edit-user-info">  
                <?php  foreach ($gebruiker as $key => $value) { 
                    if ($key == 'geboortedag') {
                        echo '<label><b>'. $key .'</b></label><input type="date" name="' . $key . '" value="'. $value .'">';
                        echo '<br>';
                        continue;
                    } else if ($key == 'gebruikersnaam') {
                        echo '<label><b>'. $key .'</b></label><input type="text" name="' . $key . '" value="'. $value .'" readonly>';
                        echo '<br>';
                        continue;
                    } else if ($key == 'telefoonnummer') {
                        echo '<label><b>'. $key .'</b></label><input type="number" name="' . $key . '" value="'. $value .'">';
                        echo '<br>';
                        continue;
                    }
                    echo '<label><b>'. $key .'</b></label><input type="text" name="' . $key . '" value="'. $value .'">';
                    echo '<br>';
                } ?>
                <button type="submit" class="btn btn-primary btn-sm" name="bijwerken">Bijwerken</button>
            </form>
        <?php
        }
            if (isset($_GET['bijwerken'])) {
                
                $telefoonnummerPara = array(':telefoonnummer' => $_GET['telefoonnummer'] , ':gebruikersnaam' => $gebruikersnaam);
                $birthdate = $_GET['geboortedag'];
                $myDateTime = DateTime::createFromFormat('Y-m-d', $birthdate);
                $geboortedag = $myDateTime->format('Y-m-d');

                $infoParameters = array(':gebruikersnaam' => $gebruikersnaam , 
                                        ':voornaam' => $_GET['voornaam'], 
                                        ':achternaam' => $_GET['achternaam'] , 
                                        ':adresregel1' => $_GET['adresregel1'] , 
                                        ':adresregel2' => $_GET['adresregel2'] , 
                                        ':postcode' => $_GET['postcode'], 
                                        ':plaatsnaam' => $_GET['plaatsnaam'] , 
                                        ':land' =>  $_GET['land'] , 
                                        ':geboortedag' => $geboortedag , 
                                        ':mailadres' => $_GET['mailadres']);
            
                 handlequery("UPDATE Gebruiker
                              SET voornaam = :voornaam , 
                                  achternaam = :achternaam, 
                                  adresregel1 = :adresregel1 ,
                                  adresregel2 = :adresregel2 ,
                                  postcode = :postcode,
                                  plaatsnaam = :plaatsnaam ,
                                  land = :land,
                                  geboortedag = :geboortedag,
                                  mailadres = :mailadres
                              WHERE gebruikersnaam = :gebruikersnaam", 
                              $infoParameters);
                
                 handlequery("UPDATE Gebruikerstelefoon 
                              SET telefoonnummer = :telefoonnummer 
                              WHERE gebruikersnaam = :gebruikersnaam" , $telefoonnummerPara);

  
            }

           ?> 
        }

    </div>    

</main>
<?php require_once 'footer.php'; ?>
