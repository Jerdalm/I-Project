<?php require_once ('header.php');
if(isset($_GET['product'])){

if (isset($_SESSION['gebruikersnaam'])) {
    if (isset($_COOKIE[$_SESSION['gebruikersnaam']])) {
        if (CheckCookieLengthSmallerThanSix($_SESSION['gebruikersnaam']) == false) {
            AlterCookie($_SESSION['gebruikersnaam'], $_GET['product'], true);
        } else if (CheckCookieLengthSmallerThanSix($_SESSION['gebruikersnaam'])) {
            AlterCookie($_SESSION['gebruikersnaam'], $_GET['product']);
        }
    } else {
            MakeCookie($_SESSION['gebruikersnaam']);
    }
    }

  $htmluploadFoto = ' ';
  $paramvoorwerpnummer = array(':voorwerpnummer' => $_GET['product']);

  $paramCheckPicture = array(':product' => $_GET['product']);
  $checkPictureAmount = handlequery("SELECT * FROM bestand WHERE voorwerpnummer = :product", $paramCheckPicture);

  $highestBid = handlequery("SELECT TOP(1) bodbedrag FROM Bod WHERE voorwerpnummer = :voorwerpnummer ORDER BY bodbedrag DESC", $paramvoorwerpnummer);
  if (!empty($highestBid)) {
    if($highestBid[0]['bodbedrag'] < 1) {
      $minimunraise = 0;
    } elseif ($highestBid[0]['bodbedrag'] >= 1 && $highestBid[0]['bodbedrag'] < 50) {
      $minimunraise = 0.50;
    } elseif ($highestBid[0]['bodbedrag'] >= 50 && $highestBid[0]['bodbedrag'] < 500) {
      $minimunraise = 1;
    } elseif ($highestBid[0]['bodbedrag'] >= 500 && $highestBid[0]['bodbedrag'] < 1000) {
      $minimunraise = 5;
    } elseif ($highestBid[0]['bodbedrag'] >= 1000 && $highestBid[0]['bodbedrag'] < 5000) {
      $minimunraise = 10;
    } else {
      $minimunraise = 50;
    }
    $minimumbid = ($minimunraise + $highestBid[0]['bodbedrag']);
  }

  $boddata = FetchAssocSelectData(
    "SELECT MAX(bodbedrag) as hoogstebod
    from bod
    where voorwerpnummer = :voorwerpnummer", $paramvoorwerpnummer);

    $productdata = FetchAssocSelectData(
      "SELECT V.verkoper, G.gebruikersnaam, V.voorwerpnummer, V.verzendkosten, V.verzendinstructies, G.voornaam, G.achternaam, G.plaatsnaam, G.soortGebruiker,
      V.titel, V.startprijs, V.beschrijving, G.mailadres , GT.telefoonnummer, V.looptijdBeginTijdstip, V.looptijdBeginDag, V.veilingGesloten, V.koper
      FROM Voorwerp V
      JOIN gebruiker G on V.verkoper = G.gebruikersnaam
      LEFT JOIN gebruikerstelefoon GT on G.gebruikersnaam = GT.gebruikersnaam
      WHERE voorwerpnummer = :voorwerpnummer", $paramvoorwerpnummer);

      $paramkoperdata = array(':gebruikersnaam' => $productdata['koper']);
      $koperdata = FetchAssocSelectData(
        "SELECT voornaam, achternaam, plaatsnaam, mailadres
        FROM gebruiker
        WHERE gebruikersnaam = :gebruikersnaam", $paramkoperdata);

        $images = handlequery("SELECT filenaam FROM Bestand WHERE voorwerpnummer = :voorwerpnummer", $paramvoorwerpnummer);
        $aangebodenDag = date("d-m-Y", strtotime($productdata['looptijdBeginDag']));

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
          if(isset($_POST['submit-file'])){
            $target_dir = "./uploads/user/" . $productdata['verkoper'] . '/' . $productdata['voorwerpnummer']. '/';
            if (!file_exists($target_dir)){
              mkdir('uploads/user/'. $productdata['verkoper'] . '/' . $productdata['voorwerpnummer'] , 02202, true);
            }
            $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
              if(!empty($_FILES["fileToUpload"]["name"])) {
                  if (checkIfImage($_POST["submit-file"])) {
                      if (checkAllowedFileTypes($imageFileType)) {
                          if (checkSizeFile(500000)) {
                              if (checkExistingFile($target_file)) {
                                  if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                                      $bestandmelding = "Het bestand " . basename($_FILES["fileToUpload"]["name"]) . " is geüpload.";
                                      $bestandsnaam = $target_file;
                                      $uploadParameters = array(':voorwerpnummer' => $productdata['voorwerpnummer'], ':bestandsnaam' => $bestandsnaam);
                                      handlequery("insert into Bestand values (:bestandsnaam, :voorwerpnummer)", $uploadParameters);
                                      redirectJS('productpage.php?product=' . $productdata['voorwerpnummer']); //Refresht de pagina zodat de foto's getoont worden
                                  } else {
                                      $bestandmelding = "Sorry, Er is iets fout gegaan tijdens het uploaden van uw bestand.";
                                  }
                              } else {
                                  $bestandmelding = "Sorry, Het bestand bestaat al.";
                              }
                          } else {
                              $bestandmelding = "Sorry, Uw bestand is te groot.";
                          }
                      } else {
                          $bestandmelding = "Sorry, alleen JPG, JPEG & PNG files zijn toegestaan.";
                      }
                  } else {
                      $besetandmelding = "File is not an image.";
                  }
              }
          } else if(isset($_POST['bidAmount-submit'])){
            $paramBod = array(':voorwerpnummer' => $_GET['product'], ':bedrag' => (float)$_POST['bidAmount'], ':gebruiker' => $_SESSION['gebruikersnaam']);
            //$plaatsBod =  executequery("EXEC prc_hogerBod :bedrag, :voorwerpnummer, :gebruiker", $paramBod); // functie in databse om het bod uit te brengen en te checken of het klopt
            if ($_SESSION['gebruikersnaam'] != $productdata['verkoper']) {
              if (!empty($highestBid)) {
                if ($_POST['bidAmount'] >= $minimumbid) {
                  executequery("EXEC prc_hogerBod :bedrag, :voorwerpnummer, :gebruiker", $paramBod);
                  redirectJS('productpage.php?product=' . $productdata['voorwerpnummer']);
                } else {
                  $message_bids = "Uw bod is te laag, probeer hoger te bieden";
                }
              } elseif ($_POST['bidAmount'] >= $productdata['startprijs']) {
                executequery("EXEC prc_hogerBod :bedrag, :voorwerpnummer, :gebruiker", $paramBod);
                redirectJS('productpage.php?product=' . $productdata['voorwerpnummer']);
              } else {
                $message_bids = "Uw bod is te laag, probeer hoger te bieden";
              }
            } else {
              $message_bids = "U kunt niet bieden op uw eigen veilingen";
            }
          }
        }

        if($productdata['veilingGesloten'] == 0) {
          if (isset($_SESSION['gebruikersnaam'])) {
            if (!isset($minimumbid)) {
              $minimumbid = $productdata['startprijs'];
            }
            $htmluploadFoto = '<form method="post" action="">
            <div class="form-row align-items-center">
            <div class="col-sm-12">
            <input type="number" step="0.01" class="form-control" name="bidAmount" id="colFormLabelLg" placeholder="Minimum bieding: €'. number_format($minimumbid, 2, ",", ".") .'">
            <input type="submit" name="bidAmount-submit" Value="Bied!" class="biedenKnop cta-orange btn">
            ';
            if (isset($message_bids)) {
              $htmluploadFoto .= '<p class="error error-warning">' . $message_bids . '</p>';
            };
            $htmluploadFoto .= '</div>
            </div>
            </form>';
          } else {
            $htmluploadFoto = '<a href="./user.php">Log in om te kunnen bieden!</a>';
          }
        }
        ?>

<main>
    <section class="productpage">
        <div class="container border-primary">
            <div class="row">
                <div class="col-lg-7 p-3 bg-secondary text-white">
                    <figure class="figure col-md-12">
                        <div class="preview">
                            <div class="preview-pic tab-content">
                                <?php
                                $teller = 1;
                                $skipFirst = true;
                                foreach ($images as $image){
                                    if ($skipFirst) {
                                        echo '<div class="tab-pane active" id="pic-'.$teller .'"><img src="' .$image['filenaam'] . '"/></div>';
                                        $teller++;
                                        $skipFirst = false;
                                        continue;
                                    }
                                    echo '<div class="tab-pane" id="pic-'.$teller.'"><img src="' .$image['filenaam']. '" /></div>';
                                    $teller++;
                                } ?>
                            </div>
                            <ul class="preview-thumbnail nav nav-tabs">
                                <?php
                                $teller = 1;
                                $skipFirst = true;
                                foreach ($images as $image){
                                    if ($skipFirst) {
                                        echo '<li class="active"><a data-target="#pic-'. $teller . '" data-toggle="tab"><img src=" '. $images[0]['filenaam'] .'"/></a></li>';
                                        $skipFirst = false;
                                        $teller++;
                                        continue;
                                    }
                                    echo '<li><a data-target="#pic-'.$teller . '"data-toggle="tab"><img onerror="this.style.display=\'none\'"src="'.$image['filenaam'] . '" /></a></li>';
                                    $teller++;
                                } ?>
                            </ul>
                        </div>
                    </figure>
                    <div class="col p-3 mb-2 bg-secondary text-white" style="text-align: left">
                        <?php if(isset($_SESSION['gebruikersnaam'])){
                            if(count($checkPictureAmount) < 4){
                                if ($_SESSION['gebruikersnaam'] == $productdata['verkoper']) {
                                    echo '<form action="" method="post" enctype="multipart/form-data">
                                    <div class="custom-file">
                                    <label class="custom-file-label" for="customFile">Selecteer een foto</label>
                                    <input type="file" class="custom-file-input" id="customFile" name="fileToUpload">
                                    </div>

                                    <input type="submit" class="btn upload-file btn-primary" value="Upload foto" name="submit-file">
                                    </form>';
                                }
                            }
                        }
                        if (isset($bestandmelding)){
                            echo '<p class="error error-warning">' . $bestandmelding . '</p>';
                        }
                        ?>
                        <dl class="dl-horizontal">
                            <dt>Beschrijving:</dt>
                            <br>
                            <dd><?= $productdata['beschrijving'] ?></dd>
                        </dl>
                    </div>
                </div>

                <div class="col-lg-5 p-3 bg-secondary text-white">
                    <div class="alert alert-dark" role="alert">
					<div class="product-info">
                        <p class="beginTijdstip"><i>Aangeboden op: <?= $aangebodenDag  ?> </i></p>
                        <h2 class="alert-heading"> <strong> <?= $productdata['titel']?></strong></h2>

                        <?php if($productdata['startprijs'] != 0) { ?>
                            <p>Startprijs: €<?=number_format($productdata['startprijs'], 2, ",", ".")?></p>
                        <?php } else { ?>
                            <p>Startprijs: € 0,00</p>
                        <?php } if(isset($productdata['verzendkosten'])){ echo '<p>Verzendkosten: €' .number_format($productdata['verzendkosten'], 2, ",", ".");} ?></p>
                        <p>Productnummer: <?=$productdata['voorwerpnummer']?></p>
                        <?php if($productdata['veilingGesloten'] == 1) {
                            echo "Veiling status: gesloten";
                        } else {
                            echo "Veiling status: open";
                        }?>
                        <hr>
					</div>
                        <div class="bids">
                            <table class="table table-responsive">
                                <?php
                                if($productdata['veilingGesloten'] == 0) {
                                    $bodInfo = handlequery("SELECT top 10 * FROM Bod WHERE voorwerpnummer = :voorwerpnummer ORDER BY bodbedrag DESC", $paramvoorwerpnummer);
                                    if(count($bodInfo) == 0){
                                        echo "Er zijn nog geen biedingen.";
                                    } else {
                                        echo '<thead>';
                                        foreach ($bodInfo as $bodkolom) {
                                            echo '<tr>';
                                            echo '<th scope="col">€' .number_format($bodkolom['bodbedrag'], 2, ",", "."). '</th>';
                                            echo '<th scope="col">' .$bodkolom['gebruikersnaam']. '</th>';
                                            echo '<th scope="col">' .date_format(date_create($bodkolom['bodDag']), "d-m-Y"). '</th>';
                                            echo '<th scope="col">' .date_format(date_create($bodkolom['bodTijdstip']), "H:i"). '</th>';
                                            echo '</tr>';
                                        }
                                        echo '</thead>';
                                    }
                                } elseif($boddata['hoogstebod'] != NULL) {
                                    echo "Gewonnen door:";
                                 ?>
                                    <p><b><?= $koperdata['voornaam']. " " .$koperdata['achternaam'] ?></b> te <?=$koperdata['plaatsnaam']?></p><br>
                                    <p><a href=<?='"mailto:' .$koperdata['mailadres']. '?SUBJECT=' . $productdata['titel'] . '"'?>> <i class="fas fa-envelope"></i> &nbsp;&nbsp;&nbsp;<?=$koperdata['mailadres']?></a></p>
                                <?php
                                echo " met een bod van €" .$boddata['hoogstebod'];
                                } else {
                                    echo "helaas, niemand heeft binnen de tijd geboden op dit product.";
                                }
                                ?>
                            </table>
                        </div>
                        <?='<p>'.$htmluploadFoto.'</p>'?>
                        <hr>
                        <div class="userInfo">
                            <div class="row">
                                <div class="col-lg-9">
                                    <p> Aangeboden door:</p>
                                    <p><b><?= $productdata['verkoper'] ?></b> te <?=$productdata['plaatsnaam']?></p><br>
                                    <p><a href=<?='"mailto:' .$productdata['mailadres']. '?SUBJECT=' . $productdata['titel'] . '"'?>> <i class="fas fa-envelope"></i> &nbsp;&nbsp;&nbsp;<?=$productdata['mailadres']?></a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="products">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <h2 class="mt-4">Nieuwe veilingen</h2>
                </div>
                <div class="col-lg-12 product-container">
                    <div id="myCarousel" class="carousel slide" data-ride="carousel" data-interval="false">
                        <div class="carousel-inner row w-100 mx-auto">
                            <?php
                            if (isset($_SESSION['gebruikersnaam'])) {
                                showProducts(true, Setquery($_SESSION['gebruikersnaam'], $_GET['product']));
                            } else {
                                showProducts();
                            }
                            ?>
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
       </div>
   </section>
</main>
<script>
setInterval(function()
{
$('.preview-thumbnail').load(document.URL +  ' .preview-thumbnail');
$('.product-info').load(document.URL +  ' .product-info');
$('.bids').load(document.URL +  ' .bids');
$('.userInfo').load(document.URL +  ' .userInfo');

}, 1000);
</script>

<style>

</style>
<?php } else {

    echo  '<main>
             <div class="container">
                 <h1>Product niet gevonden!</h1>
               </div>
           </main>';
}
require_once 'footer.php'; ?>
