<?php 
	require 'header.php'; 
	
	if(isset($_GET['min']) && isset($_GET['max'])){
	$pricecheck = checkPriceFilter($_GET['min'],$_GET['max']);
	}
	else{
	$pricecheck = checkPriceFilter(null,null);
	}
	
	if(isset($_GET['rub'])){ 
	$rubriek = $_GET['rub'];
	
	if(is_numeric($rubriek)){
	$rubriekdata = getSubRubriek($rubriek);
	
	
	$parameters = false;
	
	$query = "SELECT * from currentAuction 
	INNER JOIN VoorwerpinRubriek
	ON VoorwerpinRubriek.voorwerpnummer = currentAuction.voorwerpnummer
	Where rubriekOpLaagsteNiveau IN ".$rubriekdata. " AND ".$pricecheck."
	";
	
	$rubrieken = FetchSelectData("EXEC SHOW_RUBRIEK_TREE");
	
	$rubriekparameters = array(':rubriek' => $rubriek);
	$rubriekgegevens = handlequery("SELECT rubrieknaam from Rubriek WHERE rubrieknummer = :rubriek ",$rubriekparameters);
	if($rubriekgegevens){
	
	$titel = $rubrieknaam = $rubriekgegevens[0][0];
	$key = array_search(''.$rubrieknaam.'', array_column($rubrieken, 'rubrieknaam'));
	$rubriekBreadcrumb = getRubriekPath($rubrieken,$key);
	
	
	}
	else{
	header("Location:overview.php");
	}
	}else{
	header("Location:overview.php");}
	
	$zoekfilter = '';
	
	
	}
	
	else if(isset($_GET['search'])){ 
	$zoekfilter = $_GET['search'];
	
		$titel = "Zoekresultaten";
		$parameters = array(":search" => "%" . $zoekfilter . "%");
		$query = "SELECT * FROM currentAuction WHERE currentAuction.titel LIKE :search AND ".$pricecheck;
	
	}
	
	else{
	$titel = $zoekfilter = "Alle veilingen";
	$parameters = false;
	$query = "SELECT * from currentAuction WHERE ".$pricecheck;
	}
?>
<header class="header content-header" 
style="background: linear-gradient( rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.4) ),
url('./img/header/horloge_header.jpg') center center no-repeat scroll;">
   <div class="container">
      <div class="row text-center">
         <div class="col-lg-12 " >
            <h1 class="display-3 text-center text-white"><?= $titel ?></h1>
			<p></p>
         </div>
      </div>
   </div>
</header>
<section class="products text-center">
<div class="row no-margin">
<div class="col-lg-3"></div>
<div class="col-lg-9 col-md-12 col-sm-12 col-xs-12" style=" display: flex; flex-wrap: wrap;">
<ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="index.php">Home</a></li>
  
  <?php if(!isset($rubriekBreadcrumb)){ ?>
  <li class="breadcrumb-item active"><?=$zoekfilter ?></li>
  <?php }else{
	  echo createRubriekBreadcrumb($rubriekBreadcrumb);
  } ?>

</ol>
</div>
</div>

<div class="container">
<div class = "row">
<div class="col-lg-3 col-md-12 col-sm-12 col-xs-12 sidebar" style="">
<h4 class="text-center"> Rubrieken </h4>
 <?= showRubriekenlist(); ?>
 <h4 class="text-center"> Prijs </h4>
<form method="get" action="">
<div class="form-group">
<label for="minamount" class="col-form-label">Prijs van/tot</label>
<input min="0" class="form-control" name="min" id="minamount" type="number" required="required">
</div>
<div class="form-group">
<input min="0" class="form-control" name="max" id="maxamount" type="number" required="required">
<?php foreach($_GET as $key => $value){ 
if($key == 'min' || $key == 'max'){
}else{
?> 
<input type='hidden' name='<?= $key; ?>' value='<?= $value; ?>' />
<?php }} ?>
</div>
<button class="btn btn-success" type="submit"><i class="fas fa-sync-alt"></i></button>
</form>
</div>
<div class="col-lg-9 col-md-12 col-sm-12 col-xs-12" style=" display: flex; flex-wrap: wrap;">
<?= showProducts(false,$query,$parameters); ?>
</div>
</div>
</div>
</section>
<?php require 'footer.php'; ?>


<?php 
// returnt parameter array
function checkPriceFilter($min, $max){
	
$returnwaarde = '1 = 1';
   
        if(!empty($min) && !empty($max)){
			if(is_numeric($min) && is_numeric($max)){
			$returnwaarde = "bodbedrag between $min AND $max";
			}
		}

	
return $returnwaarde;
}