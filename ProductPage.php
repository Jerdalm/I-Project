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
V.titel, V.startprijs, V.beschrijving
from voorwerp V
inner join gebruiker G on V.verkoper = G.gebruikersnaam
WHERE voorwerpnummer = $Vwnummer
");//voorwerpnummer moet meegegeven worden vanuit de site


foreach ($productdata as $item) {
?>



        <div class="row">
            <div class="col-lg-6 p-3 bg-secondary text-white">
              <body class="bg-secondary bg-light text-dark"
              <body onload="startTime()">

                <div id="myCarousel" class="carousel slide" data-ride="carousel">
                  <!-- Indicators -->
                  <ol class="carousel-indicators">
                    <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                    <li data-target="#myCarousel" data-slide-to="1"></li>
                    <li data-target="#myCarousel" data-slide-to="2"></li>
                  </ol>

                  <!-- Wrapper for slides -->
                  <div class="carousel-inner">
                    <div class="item active">
                      <img src="https://mb.lucardi-cdn.nl/zoom/64867/regal-mesh-horloge-met-zilverkleurige-band.jpg" alt="Los Angeles">
                    </div>

                    <div class="item">
                      <img src="https://www.brandfield.nl/media/catalog/product/cache/21/image/9df78eab33525d08d6e5fb8d27136e95/m/k/mk8281_1.jpg" alt="Chicago">
                    </div>

                    <div class="item">
                      <img src="https://cdn-1.debijenkorf.nl/web_detail/hugo-boss-horloge-rafal-hb1513456/?reference=039/130/13_0391309001300000_pro_flt_frt_01_1108_1528_1669062.jpg" alt="New York">
                    </div>
                  </div>

                  <!-- Left and right controls -->
                  <a class="left carousel-control" href="#myCarousel" data-slide="prev">
                    <span class="glyphicon glyphicon-chevron-left"></span>
                    <span class="sr-only">Previous</span>
                  </a>
                  <a class="right carousel-control" href="#myCarousel" data-slide="next">
                    <span class="glyphicon glyphicon-chevron-right"></span>
                    <span class="sr-only">Next</span>
                  </a>
                </div>
              <div class="container border-primary">
                <!-- <figure class="figure" style="position: relative; text-align: center;">
                    <img src="https://www.brandfield.nl/media/catalog/product/cache/21/image/9df78eab33525d08d6e5fb8d27136e95/S/K/SKW6216.jpg" alt="..."
                         class="figure-img img-fluid rounded"> -->
<!--                    afbeelding vanuit de webserver moet nog ingevoerd worden-->
                    <!-- <div class="row">
                    <img src="https://mb.lucardi-cdn.nl/zoom/64867/regal-mesh-horloge-met-zilverkleurige-band.jpg" alt="..." class="col-2 col-md-offset-1 rounded">
                    <img src="https://www.brandfield.nl/media/catalog/product/cache/21/image/9df78eab33525d08d6e5fb8d27136e95/m/k/mk8281_1.jpg" alt="..." class="col-lg-2 col-md-offset-1 rounded">
                    <img src="https://cdn-1.debijenkorf.nl/web_detail/hugo-boss-horloge-rafal-hb1513456/?reference=039/130/13_0391309001300000_pro_flt_frt_01_1108_1528_1669062.jpg" alt="..." class="col-lg-2 col-md-offset-1 rounded">
                    </div>
                </figure> -->
                <div class="col p-3 mb-2 bg-secondary text-white" style="text-align: center">
                    <p>Description:
                    <?= $item['beschrijving'] ?>
                    </p>
                </div>
            </div>
            <div class="col-lg-6 p-3 mb-2 bg-secondary text-white">
                <div class="alert alert-dark" role="alert">
                    <h4 class="alert-heading"><?= $item['titel']?></h4>
                    <p>Startprijs: € <?= $item['startprijs']?></p>
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
                                WHERE voorwerpnummer = $Vwnummer
                                ORDER BY bodbedrag DESC
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
                        <!-- Dit moet de eerste afbeelding uti de rij worden -->
                        <img src="https://mb.lucardi-cdn.nl/zoom/64867/regal-mesh-horloge-met-zilverkleurige-band.jpg" alt="..." width= 70px height= 70px class="rounded-circle float-right" style="margin: -15px 15px 0 0">
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
                $bidAmount = $_POST['bidAmount'];
                executequery("EXEC prc_hogerBod $bidAmount, $Vwnummer, 'gebruiker'"); // functie in databse om het bod uit te brengen en te checken of het klopt
            }

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
            <div class="product-container">
              <div id="myCarousel" class="carousel slide" data-ride="carousel" data-interval="false">
                <div class="carousel-inner row w-100 mx-auto">
                  <?= showProducts(true); ?>
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
          </div>
        </section>
    </div>
</div>

<?php
}
require_once 'footer.php'; ?>

</body>
