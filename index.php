<?php
require_once 'header.php';
$_SESSION['login-attempts'] = 0;
$_SESSION['fifthloginattempt_time'] = 0;
$_SESSION['email-registration'] = ' ';
?>
<!-- promotie header -->
<header class="header promo-header">
   <div class="container">
      <div class="row text-center">
         <div class="col-lg-12 " >
            <img src="img/logo/logo.svg" alt="Logo" class="logo" >
            <h1 class="display-3 text-center text-white"> <b>Eenmaal</b> Andermaal</h1>
            <form action="overview.php" method="get">
               <input list="films" name="search" placeholder="Het gewenste product" maxlength="50" type="search" required>
               <input value="zoeken" type="submit">
            </form>
         </div>
      </div>
   </div>
</header>
<!-- Pagina content -->
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
             <?php
             if(isset($_SESSION['gebruikersnaam']) && isset($_GET['product'])) {
                 $data = unserialize($_COOKIE[$_SESSION['gebruikersnaam']]);

                 echo showProducts(true, Setquery($_SESSION['gebruikersnaam'], $_GET['product']));
             } else {
                 echo showProducts(true,"
					SELECT TOP 10 *, Vo.startprijs from currentAuction C
					INNER JOIN voorwerp Vo
					ON C.voorwerpnummer = Vo.voorwerpnummer
					ORDER BY NEWID()");
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
</section>
<section class="attention text-center">
    <?= showButtonIndex();?>
</section>
<section class="userExperience">
  <div class="container">
    <div class="row text-center">
      <div class="col-lg-1">
      </div>
      <div class="col-lg-3">
        <img  class="rounded-circle" src="https://media.licdn.com/dms/image/C5603AQEw87fpxGbWxg/profile-displayphoto-shrink_200_200/0?e=1533772800&v=beta&t=r9OJ4eFVUOsFzktAPy054Us6l7BZTqdraWBySWvzZBg">
      </div>
      <div class="col-lg-5">
        <h2> "Het is erg eenvoudig om je gewenste product te vinden"</h2>
      </div>
      <div class="col-lg-3">
      </div>
    </div>
  </div>
</section>
<!--
<script>
setInterval(function()
{
	$('.product-data').each(function() {
	$('#'+ this.id).load('index.php #' + this.id);
});
}, 1000);
</script>
-->
<script src="vendor/bootstrap/js/popup.header.js"></script>
<!-- /.container -->
<?php require_once './footer.php'; ?>
