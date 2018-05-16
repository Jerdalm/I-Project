<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>ProductPage</title>

    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/business-frontpage.css" rel="stylesheet">


<body class="bg-secondary bg-light text-dark"<body onload="startTime()">
<?php require_once ('header.php');
$Vwnummer = $_GET['product'];
$productdata = handlequery("
SELECT V.voorwerpnummer, G.voornaam, G.achternaam, G.plaatsnaam,
V.titel, V.startprijs
from voorwerp V
inner join gebruiker G on V.verkoper = G.gebruikersnaam
inner join verkoper VK on V.verkoper = VK.gebruikersnaam
WHERE voorwerpnummer = $Vwnummer
");//voorwerpnummer moet meegegeven worden vanuit de site


foreach ($productdata as $item) {
?>

<body class="bg-secondary bg-light text-dark"
<body onload="startTime()">


<div class="container border-primary">

        <div class="row">
            <div class="col-lg-6 p-3 bg-secondary text-white">
                <figure class="figure" style="position: relative; text-align: center;">
                    <img src="media/WatchTestJEREMY.jpg" alt="..."
                         class="figure-img img-fluid rounded">
<!--                    afbeelding vanuit de webserver moet nog ingevoerd worden-->
                    <div class="row">
                    <img src="media/WatchTestJEREMY.jpg" alt="..." class="col-2 col-md-offset-1 rounded">
                    <img src="media/WatchTestJEREMY.jpg" alt="..." class="col-lg-2 col-md-offset-1 rounded">
                    <img src="media/WatchTestJEREMY.jpg" alt="..." class="col-lg-2 col-md-offset-1 rounded">
                    </div>
                </figure>
                <div class="col p-3 mb-2 bg-secondary text-white" style="text-align: center">
                    <p>Description:</p>
                </div>
            </div>
            <div class="col-lg-6 p-3 mb-2 bg-secondary text-white">
                <div class="alert alert-dark" role="alert">
                    <h4 class="alert-heading"><?= $item['titel']?></h4>
                    <p>Startprijs: <?= $item['startprijs']?>€</p>
                    <p>Voorwerpnummer: <?= $item['voorwerpnummer']?></p>
                    <div id="txt"></div>
                    <hr>
                    <p>Hoogste bod:</p>
                    <div class="card bg-light mb-4">
                        <div class="card-body">
                            <table class="table">

                                <?php
                                $bodData = handlequery("SELECT top 10 * 
FROM Bod
ORDER BY bodbedrag desc
");

                                foreach ($bodData as $Boditem) {
                                $bodHi= $Boditem['bodTijdstip'];
                                $bodTijdstip= date_create("$bodHi");

                                $boddcY= $Boditem['bodDag'];
                                $bodDag= date_create("$boddcY");
                                ?>
                                <thead class="thead-dark">
                                <tr class="table-danger">
                                    <th scope="col">€ <?= $Boditem['bodbedrag']?></th>
                                    <th scope="col"><?= $Boditem['gebruikersnaam']?></th>
                                    <th scope="col"><?= date_format($bodDag, "d-m-Y")?></th>
                                    <th scope="col"><?= date_format($bodTijdstip, "H:i")?></th>
<!--                                <th scope="col">--><?//= date_format($bodTijd, "H:i:s")?><!--</th>Secondenteller bij het bod-->
                                    <?php } ?>
                                </tr>
                                </thead>



                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <p style= "margin: auto">
                            Aangeboden door:
                            <?= $item['voornaam'] . " " . $item['achternaam'] . " uit " . $item['plaatsnaam']; ?>
                        </p>
                        <img src="media/WatchTestJEREMY.jpg" alt="..." width= 70px height= 70px class="rounded-circle float-right" style="margin: -15px 15px 0 0">
                    </div>
                </div>


                <form method="post" action="">
                    <div class="form-row align-items-center">
                        <div class="col-sm-9">
                            <input type="number" class="form-control form-control-lg" name="bidAmount" id="colFormLabelLg" placeholder="Geef uw gewenste bedrag in.">
                            <div class="col-auto">
                                <button type="submit" name="bidAmount-Submit" class="btn btn-primary mb-2">Bied!</button>
                            </div>
                    </div>
                </div>
                </form>
            <div>

            <?php
            if(isset($_POST['bidAmount-Submit'])){
                executequery("EXEC prc_hogerBod 30, 1, 'gebruiker'");
            }
//            if(isset($_POST['bidAmount-Submit']) && !empty($_POST['bidAmount'])) {
//                $HighestBid = handlequery("SELECT max(B.bodbedrag) as MaxBod from Bod B");
//echo 'taart';
//                if ($_POST['bidAmount'] > $HighestBid[0][0]) {
//                    echo 'taart2';
//                    $bidAmount = $_POST['bidAmount'];
//                    $username = "gebruiker";
//                    $bidDay = date('Y-m-d');
//                    $bidTime = date('H:i:s');
//
//                    handlequery("INSERT INTO Bod (voorwerpnummer, bodbedrag, gebruikersnaam, bodDag, bodTijdstip) VALUES ($Vwnummer, $bidAmount, $username, $bidDay,$bidTime");
//                } else {
//                    echo "Sorry, u moet een hoger bedrag invoeren.";
//                }
//            }
            ?>
            </div>
        </div>
        <section class="products">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <h2 class="mt-4">Nieuwe veilingen</h2>
                    </div>
                </div>
                <div id="myCarousel" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner row w-100 mx-auto">
                        <div class="carousel-item col-md-4 active">
                            <div class="product card">
                                <img class="card-img-top img-fluid" src="img/products/horloge_example.jpg" alt="">
                                <div class="card-body">
                                    <h4 class="card-title">
                                        Roma dresser 35mm
                                    </h4>
                                    <h5><span class="time">01:25:27</span>|<span class="price">$25.00</span></h5>
                                    <a href="#" class="btn cta-white">Bekijk nu</a>
                                </div>
                            </div>
                        </div>
                        <div class="carousel-item col-md-4">
                            <div class="product card">
                                <img class="card-img-top img-fluid" src="img/products/horloge_example.jpg" alt="">
                                <div class="card-body">
                                    <h4 class="card-title">
                                        Roma dresser 35mm
                                    </h4>
                                    <h5><span class="time">01:25:27</span>|<span class="price">$25.00</span></h5>
                                    <a href="#" class="btn cta-white">Bekijk nu</a>
                                </div>
                            </div>
                        </div>
                        <div class="carousel-item col-md-4">
                            <div class="product card">
                                <img class="card-img-top img-fluid" src="img/products/horloge_example.jpg" alt="">
                                <div class="card-body">
                                    <h4 class="card-title">
                                        Roma dresser 35mm
                                    </h4>
                                    <h5><span class="time">01:25:27</span>|<span class="price">$25.00</span></h5>
                                    <a href="#" class="btn cta-white">Bekijk nu</a>
                                </div>
                            </div>
                        </div>
                        <div class="carousel-item col-md-4">
                            <div class="product card">
                                <img class="card-img-top img-fluid" src="img/products/horloge_example.jpg" alt="">
                                <div class="card-body">
                                    <h4 class="card-title">
                                        Roma dresser 35mm
                                    </h4>
                                    <h5><span class="time">01:25:27</span>|<span class="price">$25.00</span></h5>
                                    <a href="#" class="btn cta-white">Bekijk nu</a>
                                </div>
                            </div>
                        </div>
                        <div class="carousel-item col-md-4">
                            <div class="product card">
                                <img class="card-img-top img-fluid" src="img/products/horloge_example.jpg" alt="">
                                <div class="card-body">
                                    <h4 class="card-title">
                                        Roma dresser 35mm
                                    </h4>
                                    <h5><span class="time">01:25:27</span>|<span class="price">$25.00</span></h5>
                                    <a href="#" class="btn cta-white">Bekijk nu</a>
                                </div>
                            </div>
                        </div>
                        <div class="carousel-item col-md-4">
                            <div class="product card">
                                <img class="card-img-top img-fluid" src="img/products/horloge_example.jpg" alt="">
                                <div class="card-body">
                                    <h4 class="card-title">
                                        Roma dresser 35mm
                                    </h4>
                                    <h5><span class="time">01:25:27</span>|<span class="price">$25.00</span></h5>
                                    <a href="#" class="btn cta-white">Bekijk nu</a>
                                </div>
                            </div>
                        </div>
                        <div class="carousel-item col-md-4">
                            <div class="product card">
                                <img class="card-img-top img-fluid" src="img/products/horloge_example.jpg" alt="">
                                <div class="card-body">
                                    <h4 class="card-title">
                                        Roma dresser 35mm
                                    </h4>
                                    <h5><span class="time">01:25:27</span>|<span class="price">$25.00</span></h5>
                                    <a href="#" class="btn cta-white">Bekijk nu</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix">
                        <div class="sliderbuttons">
                            <a class="carousel-control-prev" href="#myCarousel" role="button" data-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="carousel-control-next" href="#myCarousel" role="button" data-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="sr-only">Next</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>

<?php
}
require_once 'footer.php'; ?>

</body>
