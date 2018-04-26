<?php
require_once 'mechanic/functions.php';
require_once 'db.php';
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

        if (isset($result['gebruikersnaam'])) {
            // schrijf een foutmeldingstekst
            $_SESSION['error_registatrion'] = 'uw ingevoerde gebruikersnaam bestaat al';
            header("location: ./registratieScherm.php");
        }
        else {
            header("location: ./registratieScherm.php");
        }
    }
    else {
        $_SESSION['error_registatrion'] = 'gebruikersnaam of wachtwoord is niet ingevoerd';
        header("location: ./registratieScherm.php");
    }
}

