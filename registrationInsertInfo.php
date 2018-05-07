<?php
require_once 'mechanic/functions.php';
require_once 'db.php';
$username = "testtest";
$password = "wachtwoordje";
$emailCheck = "testmailtje";
$verkoper = 1;
if (isset($_POST['registrate'])) {
    // zijn de velden ingevuld?
    if (!empty($_POST['firstname']) && !empty($_POST['lastname']) && !empty($_POST['adres1']) && !empty($_POST['postalcode']) &&
        !empty($_POST['residence']) && !empty($_POST['country']) && !empty($_POST['phonenumber']) && !empty($_POST['birthdate']) &&
        !empty($_POST['secretquestion']) && !empty($_POST['secretanswer'])) {
        // de ingevoerde gegevens opslaan in variabelen
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $adres1 = $_POST['adres1'];
        $adres2 = $_POST['adres2'];
        $postalcode = $_POST['postalcode'];
        $residence = $_POST['residence'];
        $country = $_POST['country'];
        $phonenumber = $_POST['phonenumber'];
        $birthdate = $_POST['birthdate'];

        $date = $_POST['birthdate'];
        //$date = DateTime::createFromFormat('j-M-Y', $_POST['birthdate']);
        //$birthdate = date_format($date,'Y-m-d');

        $myDateTime = DateTime::createFromFormat('Y-m-d', $birthdate);
        $birthdate = $myDateTime->format('Y-m-d');

        echo $birthdate;

        $secretquestion = $_POST['secretquestion'];
        $secretanswer = $_POST['secretanswer'];

        // voer query uit in de database voor tabel gebruikers
        $sql1 = "SELECT gebruikersnaam FROM Gebruiker WHERE gebruikersnaam = ?";

        $opdracht1 = $pdo->prepare($sql1);
        $opdracht1->execute(array($username));
        $result = $opdracht1->fetch();

            $sql2 = "INSERT INTO Gebruiker VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";


            $opdracht2 = $pdo->prepare($sql2);
            $opdracht2->execute(array($_SESSION['username'],
                $firstname,
                $lastname,
                $adres1,
                $adres2,
                $postalcode,
                $residence,
                $country,
                $birthdate,
                $emailCheck,
                $_SESSION['password'],
                $secretquestion,
                $secretanswer,
                $verkoper));

            $sql3 = "INSERT INTO gebruikerstelefoon VALUES(?, ?)";

            $opdracht3 = $pdo->prepare($sql3);
            $opdracht3->execute(array($_SESSION['username'], $phonenumber));

            $_SESSION['step4'] = false;
            $_SESSION['step1'] = true;
            session_destroy();
            header('Refresh:0; url=./registratieScherm.php');
            $_SESSION["error_registration"] = '';

        header('Refresh:0; url=./registratieScherm.php');
    } else{
        // schrijf een foutmeldingstekst
        $_SESSION['error_registration'] = "een van de invoervelden is niet correct ingevoerd";
        header('Refresh:2; url=./registratieScherm.php');

    }
}
