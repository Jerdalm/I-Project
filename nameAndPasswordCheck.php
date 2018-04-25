<?php
require_once 'mechanic/functions.php';
ConnectToDatabase();
//var_dump($_SESSION);
if (isset($_POST['submitNaam'])) {
    // zijn de velden gebruiker en wachtwoord ingevuld?
    if (!empty($_POST['name']) && !empty($_POST['password'])) {
        // de ingevoerde gegevens opslaan in variabelen
        $username = $_POST['name'];
        $password = $_POST['password'];//hash('sha1', $_POST['wachtwoord']);

        // voer query uit in de database voor tabel gebruikers
        $sql1 = "SELECT gebruikersnaam FROM Gebruiker WHERE gebruikersnaam = ?";

        $opdracht1 = $pdo->prepare($sql1);
        $opdracht1->execute(array($username));
        $result = $opdracht1->fetch();


        if (!isset($result['gebruikersnaam'])) {
            $sql2 = "INSERT INTO Gebruikers VALUES(?, ?)";

            $opdracht2 = $pdo->prepare($sql2);
            $opdracht2->execute(array($username, $password));
            header('Refresh:0; url=registratieScherm.php');

        }
        if (isset($result['gebruikersnaam'])) {
            // schrijf een foutmeldingstekst
            $_SESSION['error_registatrion'] = 'uw ingevoerde gebruikersnaam bestaat al';
            header('Refresh:0; url=registratieScherm.php');
        }
        if (isset($result['wachtwoord'])) {
            $_Session['error_registration'] = 'uw ingevoerde wachtwoord bestaat al';
            header('Refresh:0; url=registratieScherm.php');
        }
    }
}
?>