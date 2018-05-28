<?php require_once ('header.php');
if(isset($_GET['product'])){
    $htmluploadFoto = ' ';
    $paramvoorwerpnummer = array(':voorwerpnummer' => $_GET['product']);

    $paramCheckPicture = array(':product' => $_GET['product']);
    $checkPictureAmount = handlequery("SELECT * FROM bestand WHERE voorwerpnummer = :product", $paramCheckPicture);

    $productdata = FetchAssocSelectData(
        "SELECT V.verkoper, G.gebruikersnaam,V.voorwerpnummer,V.verzendkosten,V.verzendinstructies, G.voornaam, G.achternaam, G.plaatsnaam,G.soortGebruiker,
        V.titel, V.startprijs, V.beschrijving , G.mailadres ,GT.telefoonnummer,V.looptijdBeginTijdstip,V.looptijdBeginDag
        FROM Voorwerp V
        JOIN gebruiker G on V.verkoper = G.gebruikersnaam
        LEFT JOIN gebruikerstelefoon GT on G.gebruikersnaam = GT.gebruikersnaam
        WHERE voorwerpnummer = :voorwerpnummer", $paramvoorwerpnummer);
        //voorwerpnummer moet meegegeven worden vanuit de site

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

            if(checkIfImage($_POST["submit-file"]) && checkAllowedFileTypes($imageFileType) && checkSizeFile(500000) && checkExistingFile($target_file)) {
                    // echo $bestandsnaam;
                    // die();
                if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                    echo "Het bestand ". basename( $_FILES["fileToUpload"]["name"]). " is geüpload.";
                    $bestandsnaam = $target_file;
                    $uploadParameters = array(':voorwerpnummer' => $productdata['voorwerpnummer'] , ':bestandsnaam' => $bestandsnaam);
                    handlequery("insert into Bestand values (:bestandsnaam, :voorwerpnummer)",$uploadParameters);
                    header("Refresh:0"); //Refresht de pagina zodat de foto's getoont worden 
                } else {
                    echo "Sorry, Er is iets fout gegaan tijdens het uploaden van uw bestand.";
                }
            }
        } else if(isset($_POST['bidAmount-submit'])){
            $paramBod = array(':voorwerpnummer' => $_GET['product'], ':bedrag' => (float)$_POST['bidAmount'], ':gebruiker' => $_SESSION['gebruikersnaam']);
            $plaatsBod =  executequery("EXEC prc_hogerBod :bedrag, :voorwerpnummer, :gebruiker", $paramBod); // functie in databse om het bod uit te brengen en te checken of het klopt

            if ($_SESSION['gebruikersnaam'] != $productdata['gebruikersnaam']) {            
                if($plaatsBod == "Opdracht kon niet worden volbracht."){
                    echo 'Bod kan niet worden geplaats';
                } else {
                    executequery("EXEC prc_hogerBod :bedrag, :voorwerpnummer, :gebruiker", $paramBod); 
                }
            } else {
                $message_bids = "U kunt niet bieden op uw eigen veilingen";
            }
        }
    }

    if (isset($_SESSION['gebruikersnaam'])){ 
        $htmluploadFoto = '<form method="post" action="">
        <div class="form-row align-items-center">
        <div class="col-sm-12">
        <input type="number" class="form-control" name="bidAmount" id="colFormLabelLg" placeholder="Geef uw gewenste bedrag in">
        <input type="submit" name="bidAmount-submit" Value="Bied!" class="biedenKnop cta-orange btn">
        ';
        if(isset($message_bids)){
            $htmluploadFoto .= '<p class="error error-warning">'.$message_bids.'</p>';
        };
        $htmluploadFoto .= '</div>
        </div>
        </form>';
    } else {
        $htmluploadFoto = '<a href="./user.php">Log in om te kunnen bieden!</a>';
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
                        } ?>
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
                        <p>Startprijs: € <?=$productdata['startprijs']?></p>
                        <?php if(isset($productdata['verzendkosten'])){ echo '<p>Verzendkosten: €' .$productdata['verzendkosten'];} ?></p>
                        <p>Productnummer: <?=$productdata['voorwerpnummer']?></p>
                        <hr>
					</div>

                        <div class="bids">
                            <table class="table table-responsive">
                                <?php
                                $bodInfo = handlequery("SELECT top 10 * FROM Bod WHERE voorwerpnummer = :voorwerpnummer ORDER BY bodbedrag DESC", $paramvoorwerpnummer);
                                if(count($bodInfo) == 0){
                                    echo "Er zijn nog geen biedingen.";
                                } else {
                                    echo '<thead>';
                                    foreach ($bodInfo as $bodkolom) {
                                        echo '<tr>';
                                        echo '<th scope="col">€' .$bodkolom['bodbedrag']. '</th>';
                                        echo '<th scope="col">' .$bodkolom['gebruikersnaam']. '</th>';
                                        echo '<th scope="col">' .date_format(date_create($bodkolom['bodDag']), "d-m-Y"). '</th>';
                                        echo '<th scope="col">' .date_format(date_create($bodkolom['bodTijdstip']), "H:i"). '</th>';  
                                        echo '</tr>';                                      
                                    }
                                    echo '</thead>';
                                }
                                ?>
                            </table>
                        </div>
                        <?='<p>'.$htmluploadFoto.'</p>'?>
                        <hr>
                        <div class="userInfo">
                            <div class="row">
                                <div class="col-lg-9">
                                    <p><b><?= $productdata['voornaam']. " " .$productdata['achternaam'] ?></b> te <?=$productdata['plaatsnaam']?></p><br>
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

