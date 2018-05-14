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

$productdata = handlequery("
SELECT V.voorwerpnummer, G.voornaam, G.achternaam, G.plaatsnaam, 
V.titel, V.startprijs
from voorwerp V 
inner join gebruiker G on V.verkoper = G.gebruikersnaam
inner join verkoper VK on V.verkoper = VK.gebruikersnaam
");


foreach ($productdata as $item) {
?>

<body class="bg-secondary bg-light text-dark"
<body onload="startTime()">


<div class="container border-primary">

    <div>
        <div class="row">
            <div class="col-lg-6 p-3 mb-2 bg-secondary text-white" style="text-align: center">
                <figure class="figure" style="position: relative;
                        text-align: center;
                        ">
                    <img src="media/WatchTestJEREMY.jpg" width="400px" height="200px" alt="..."
                         class="figure-img img-fluid rounded">

                    <img src="media/WatchTestJEREMY.jpg" alt="..." class="col-lg-2 col-md-offset-1 rounded">   //afbeelding vanuit de webserver moet nog ingevoerd worden
                    <img src="media/WatchTestJEREMY.jpg" alt="..." class="col-lg-2 col-md-offset-1 rounded">
                    <img src="media/WatchTestJEREMY.jpg" alt="..." class="col-lg-2 col-md-offset-1 rounded">

                </figure>
            </div>
            <div class="col-lg-6 p-3 mb-2 bg-secondary text-white">
                <div class="alert alert-dark" role="alert">
                    <h4 class="alert-heading"><?= $item['titel']?></h4>
                    <p>Startprijs: <?= $item['startprijs']?>€</p>
                    <p id="demo"></p>
                    <div id="txt"></div>
                    <hr>
                    <p>Hoogste bod:</p>
                    <div class="card bg-light mb-4">
                        <div class="card-body">
                            <table class="table">
                    <?php 
                    $bodData = handlequery("SELECT *
from Bod
Order By 2 desc
");

                    foreach ($bodData as $Boditem) {
                    ?>
                                <thead class="thead-dark">
                                <tr class="table-danger">
                                    <th scope="col"><?= $Boditem['bodbedrag']?>€</th>
                                    <th scope="col"><?= $Boditem['gebruikersnaam']?></th>
                                    <th scope="col"><?= $Boditem['bodDag']?></th>
                                </tr>
                                </thead>

                                <?php } ?>

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
                                <button type="submit" name="submit-bidamount" class="btn btn-primary mb-2">Bied!</button>
                            </div>
                    </div>
                </div>
                </form>
            <div>

            <?php
            $bidAmount = "";
           $HighestBid = handlequery("select max(B.bodbedrag) from Bod B");

            if(isset($_POST['submit-bidamount']) && !empty($_POST['bidAmount'])) {
                if($_POST['bidAmount']>$HighestBid){

                    $bidAmount = $_POST['bidAmount'];
                    $username = "gebruiker";
                    $bidDay = date('Y-d-m');
                    $bidTime = date('H:i:s');


                    $Parameters = array
                   (":productID" => 1, ':bidAmount' => "$bidAmount", ":username" => $username, ":bidDay" => $bidDay, ":bidTime" => $bidTime);
                    
                    handlequery("INSERT INTO Bod (voorwerpnummer,bodbedrag,gebruikersnaam,bodDag,bodTijdstip) VALUES(:productID,:bidAmount, :username,:bidDay,:bidTime)",$Parameters);
                }
                else{
                    echo "Sorry, u moet een hoger bedrag invoeren.";
                }
            }
            ?>
            </div>
        </div>
<!--        <div class="col-lg-6 p-3 mb-2 bg-secondary text-white" style="text-align: center">-->
<!--                <p>Dit is een stukje text onder het bodenoverzicht en de foto</p>-->
<!--            </div>-->
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
