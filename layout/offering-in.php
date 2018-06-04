<?php
$gebruiker = $_SESSION['gebruikersnaam'];

$query = "SELECT top 1 Voorwerp.voorwerpnummer, max(Bestand.filenaam) AS bestand,
	Voorwerp.titel, max(Bod.bodbedrag) AS 'bodbedrag',
	max(voorwerp.looptijdEindeDag) AS 'einddag',
	max(voorwerp.looptijdEindeTijdstip) AS 'eindtijdstip',
	max(Gebruiker.plaatsnaam) AS 'plaats',
	Voorwerp.veilingGesloten
	FROM Voorwerp
	INNER join Gebruiker ON gebruiker.gebruikersnaam = Voorwerp.verkoper
	LEFT JOIN Bod on Bod.voorwerpnummer = Voorwerp.voorwerpnummer
	LEFT JOIN Bestand on Bestand.voorwerpnummer = voorwerp.voorwerpnummer
	WHERE Bod.gebruikersnaam = '$gebruiker'
	GROUP BY voorwerp.voorwerpnummer, voorwerp.titel, voorwerp.veilingGesloten, bod.bodbedrag
    ORDER BY bod.bodbedrag DESC";
?>

<div class="tab-pane fade col-lg-9 float-left" id="content-offering-in" role="tabpanel" aria-labelledby="list-offering-in">
    <div class="tab-pane fade show active" id="content-user-details" role="tabpanel" aria-labelledby="list-user-details">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center"><h3>Geboden op</h3></div>

        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 no-margin float-left" style=" display: flex; flex-wrap: wrap;">
            <?= showProducts(false, $query, false, true); ?>
        </div>

    </div>
</div>
