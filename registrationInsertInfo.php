<?php
var_dump($_SESSION);
if (isset($_POST['registrate'])) {
    // zijn de velden ingevuld?
    if (!empty($_POST['firstname']) && !empty($_POST['lastname']) && !empty($_POST['adres']) && !empty($_POST['postalcode']) &&
        !empty($_POST['residence']) && !empty($_POST['country']) && !empty($_POST['phonenumber']) && !empty($_POST['birthdate']) &&
        !empty($_POST['secretquestion']) && !empty($_POST['secretanswer'])) {
        // de ingevoerde gegevens opslaan in variabelen
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $adres = $_POST['adres'];
        $postalcode = $_POST['postalcode'];
        $residence = $_POST['residence'];
        $country = $_POST['country'];
        $phonenumber = $_POST['phonenumber'];
        $birthdate = $_POST['birthdate'];
        $secretquestion = $_POST['secretquestion'];
        $secretanswer = $_POST['secretanswer'];

        // voer query uit in de database voor tabel gebruikers
        $sql1 = "SELECT username FROM Gebruikers WHERE username = ?";

        $opdracht1 = $pdo->prepare($sql1);
        $opdracht1->execute(array($gebruiker));
        $result = $opdracht1->fetch();


        if (!isset($result['name'])) {
            $sql2 = "update gebruikers set voornaam = ?, achternaam = ?, adresregel1 = ?, postcode = ?,
            plaats = ?, land = ?, GeboorteDag = ?, Vraag = ?, antwoordtekst = ?, Verkoper = 0 
            WHERE gebruikersnaam = ?";

            $opdracht2 = $pdo->prepare($sql2);
            $opdracht2->execute(array($firstname, $lastname, $adres, $postalcode, $residence, $country, $birthdate, $secretquestion,
                $secretanswer, $username));
            header('Refresh:0; url=../inlogScherm.php');

        } else {
            // schrijf een foutmeldingstekst
            $_Session['error_registration'] = 'een van de invoervelden is niet correct ingevoerd';
            header('Refresh:2; url=../registreerScherm.php');
        }
    } else{

    }
}