<?php require_once 'head.php'; ?>
<?php require_once 'db.php'; ?>
<body>
  <!-- Navigation -->
  <header>
    <nav class="black navbar navbar-expand-lg navbar-dark fixed-top">
      <div class="container">
        <a class="navbar-brand" href="./index.php"><b>Eenmaal</b> andermaal</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav ml-auto">

            <li class="nav-item">
              <a class="nav-link" href="#">Alle veilingen</a>
            </li>
            <?=showLoginMenu()?>
            <li class="no_hover">
              <form action="filmoverzicht.php" method="get">
               <input list="films" name="search" placeholder="Uw gewenste film" maxlength="50" type="search">
               <input value="zoeken" type="submit">
             </form>
           </li>
         </ul>
       </div>
     </div>
   </nav>
 </header>