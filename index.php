<?php require_once 'header.php';
$_SESSION["step1"] = true;
$_SESSION["step2"] = false;
$_SESSION["step3"] = false;
?>
<!-- promotie header -->
<header class="promo-header">
   <div class="container">
      <div class="row text-center">
         <div class="col-lg-12 " >
            <img src="img/logo/logo.svg" alt="Logo" class="logo" > 
            <h1 class="display-3 text-center text-white"> <b>Eenmaal</b> andermaal</h1>
            <form action="filmoverzicht.php" method="get">
               <input list="films" name="search" placeholder="Uw gewenste film" maxlength="50" type="search">
               <input value="zoeken" type="submit">
            </form>
         </div>
      </div>
   </div>
</header>
<!-- Pagina content -->
<section class="homepage">
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
</section>
<!-- /.container -->
<?php require_once 'footer.php'; ?>

