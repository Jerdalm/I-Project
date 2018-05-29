<?php
$gebruiker = $_SESSION['gebruikersnaam'];

$query = "SELECT TOP 1 Bod.voorwerpnummer, bestand, titel, bod.bodbedrag, einddag, eindtijdstip, plaats
FROM currentAuction
INNER JOIN Bod ON currentAuction.voorwerpnummer = Bod.voorwerpnummer
WHERE Bod.gebruikersnaam = 'gebruiker'
ORDER BY bod.bodbedrag DESC"
?>

<div class="tab-pane fade show active col-lg-9 float-left" id="content-offering-in" role="tabpanel" aria-labelledby="list-offering-in">
    <div class="tab-pane fade show active" id="content-user-details" role="tabpanel" aria-labelledby="list-user-details">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center"><h3>Gewonnen veilingen</h3></div>

        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 no-margin float-left" style=" display: flex; flex-wrap: wrap;">
            <?= showProducts(false,$query,false); ?>
        </div>
    </div>
</div>