<?php require_once 'head.php'; ?>
<?php require_once 'db.php'; ?>
  <body>

    <!-- Navigation -->
    <header>
      <nav class="black navbar navbar-expand-lg navbar-dark fixed-top">
        <div class="container">
          <a class="navbar-brand" href="index.php"><b>Eenmaal</b> andermaal</a>
          <button class="navbar-toggler navbar-toggler-right collapsed" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ml-auto">
  			
                   <li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					  Alle veilingen
					</a>
					<div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
					<?= showMenuRubrieken(); ?>
					</div>
				  </li>
              <li class="nav-item">
                <a class="nav-link" href="
                <?php if($_SESSION['logged-in'] == false){ 
                  echo './registratieScherm.php';
                } else {
                  echo './logout.php';
                }
                ?>">
                  <?php if($_SESSION['logged-in'] == false){
                    echo 'Inloggen|Registreren';
                  } else {
                    echo 'Uitloggen';
                  }
                  ?>
                  </a>
              </li>
  			<li class="no_hover">
  				<form action="overview.php" method="get">
  					<input list="producten" name="search" placeholder="Uw product" maxlength="50" type="search">
  					<input value="zoeken" type="submit">
  				</form>
  			</li>
			
			</li>
            </ul>
          </div>
        </div>
      </nav>
    </header>

