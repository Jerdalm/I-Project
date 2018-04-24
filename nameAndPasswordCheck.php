<?php
require_once "db.php";
var_dump($_SESSION);
if (isset($_POST['registrate'])) {
    // zijn de velden gebruiker en wachtwoord ingevuld?
    if (!empty($_POST['name']) && !empty($_POST['password'])) {
        // de ingevoerde gegevens opslaan in variabelen
        $username = $_POST['naam'];
        $password = $_POST['wachtwoord'];//hash('sha1', $_POST['wachtwoord']);

        // voer query uit in de database voor tabel gebruikers
        $sql1 = "SELECT Naam FROM Gebruikers WHERE Naam = ?";

        $opdracht1 = $dbh->prepare($sql1);
        $opdracht1->execute(array($username));
        $result = $opdracht1->fetch();


        if (!isset($result['Naam'])) {
            $sql2 = "INSERT INTO Gebruikers VALUES(?, ?)";

            $opdracht2 = $dbh->prepare($sql2);
            $opdracht2->execute(array($username, $password));
            header('Refresh:0; url=../inlogScherm.php');

        } else {
            // schrijf een foutmeldingstekst
            $fout = "<p class='alert'>* Gebruikersnaam bestaat al </p>";
            echo $fout;
            header('Refresh:2; url=../registreerScherm.php');
        }
    }
}
?>