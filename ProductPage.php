<?php require_once ('header.php');
$Vwnummer = $_GET['product'];
$productdata = handlequery("
SELECT V.voorwerpnummer, G.voornaam, G.achternaam, G.plaatsnaam,
V.titel, V.startprijs, V.beschrijving
FROM Voorwerp V
JOIN gebruiker G on V.verkoper = G.gebruikersnaam
WHERE voorwerpnummer = $Vwnummer
");//voorwerpnummer moet meegegeven worden vanuit de site
$images = handlequery("
SELECT filenaam
FROM Bestand
WHERE voorwerpnummer = $Vwnummer
");


foreach ($productdata as $item) {
?>

<body class="bg-secondary bg-light text-dark"
<body onload="startTime()">

<section class="productpage">
<div class="container border-primary">
        <div class="row">
            <div class="col-lg-6 p-3 bg-secondary text-white">
                <figure class="figure" style="position: relative; text-align: center;">
                    <!-- <img src="media/WatchTestJEREMY.jpg" alt="..."
                         class="figure-img img-fluid rounded">
                   afbeelding vanuit de webserver moet nog ingevoerd worden
                    <div class="row">
                    <img src="media/WatchTestJEREMY.jpg" alt="..." class="col-2 col-md-offset-1 rounded">
                    <img src="media/WatchTestJEREMY.jpg" alt="..." class="col-lg-2 col-md-offset-1 rounded">
                    <img src="media/WatchTestJEREMY.jpg" alt="..." class="col-lg-2 col-md-offset-1 rounded">
                    </div> -->

                    <div class="preview col-md-6">

                      <div class="preview-pic tab-content">
                        <div class="tab-pane active" id="pic-1"><img src="http://placekitten.com/400/252" /></div>
                        <div class="tab-pane" id="pic-2"><img src="https://cdn-1.debijenkorf.nl/web_detail/hugo-boss-horloge-rafal-hb1513456/?reference=039/130/13_0391309001300000_pro_flt_frt_01_1108_1528_1669062.jpg" /></div>
                        <div class="tab-pane" id="pic-3"><img src="https://www.brandfield.nl/media/catalog/product/cache/21/image/9df78eab33525d08d6e5fb8d27136e95/m/k/mk8281_1.jpg" /></div>
                        <div class="tab-pane" id="pic-4"><img src="http://placekitten.com/400/252" /></div>
                      </div>
                      <ul class="preview-thumbnail nav nav-tabs">
                        <li class="active"><a data-target="#pic-1" data-toggle="tab"><img src="http://placekitten.com/200/126" /></a></li>
                        <li><a data-target="#pic-2" data-toggle="tab"><img src="http://placekitten.com/200/126" /></a></li>
                        <li><a data-target="#pic-3" data-toggle="tab"><img src="https://www.brandfield.nl/media/catalog/product/cache/21/image/9df78eab33525d08d6e5fb8d27136e95/m/k/mk8281_1.jpg" /></a></li>
                        <li><a data-target="#pic-4" data-toggle="tab"><img src="http://placekitten.com/200/126" /></a></li>
                      </ul>

                    </div>

                </figure>
                <div class="col p-3 mb-2 bg-secondary text-white" style="text-align: center">
                    <p>Description: <?= $productdata['beschrijving'] ?></p>
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
                        <!-- <img src="https://mb.lucardi-cdn.nl/zoom/64867/regal-mesh-horloge-met-zilverkleurige-band.jpg" alt="..." width= 70px height= 70px class="rounded-circle float-right" style="margin: -15px 15px 0 0"> -->
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
</section>

<?php
}
require_once 'footer.php'; ?>

</body>
