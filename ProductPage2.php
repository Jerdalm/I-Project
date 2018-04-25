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

    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.0.1/js/bootstrap.min.js"></script>
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>



<body class="bg-secondary bg-light text-dark"<body onload="startTime()">
<?php require_once ('header.php');
$productdata = handlequery("SELECT plaatsnaam, voornaam, achternaam from gebruiker ");
print_r($productdata);

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

                    <img src="media/WatchTestJEREMY.jpg" alt="..." class="col-lg-2 rounded">
                    <img src="media/WatchTestJEREMY.jpg" alt="..." class="col-lg-2 col-md-offset-1 rounded">
                    <img src="media/WatchTestJEREMY.jpg" alt="..." class="col-lg-2 col-md-offset-1 rounded">

                </figure>
            </div>
            <div class="col-lg-6 p-3 mb-2 bg-secondary text-white">
                <div class="alert alert-dark" role="alert">
                    <h4 class="alert-heading">Omega Horloge(Breu-0282)</h4>
                    <p>Startprijs: 15€</p>
                    <p id="demo"></p>
                    <div id="txt"></div>
                    <hr>
                    <p>Hoogste bod:</p>
                    <div class="card bg-light mb-4">
                        <div class="card-body">
                            <table class="table">
                                <thead class="thead-dark">
                                <tr class="table-danger">
                                    <th scope="col">45€</th>
                                    <th scope="col">Schevin van Kaijk</th>
                                    <th scope="col">15-04-2018</th>
                                </tr>
                                </thead>
                                <tr>
                                    <th scope="col">40€</th>
                                    <th scope="col">Part Bolman</th>
                                    <th scope="col">14-04-2018</th>
                                </tr>
                                <thead class="thead-light">
                                <tr>
                                    <th scope="col">35€</th>
                                    <th scope="col">Vonathan Jandionant</th>
                                    <th scope="col">14-04-2018</th>
                                </tr>
                                </thead>
                                <tr>
                                    <th scope="col">30€</th>
                                    <th scope="col">Buard Edakouev</th>
                                    <th scope="col">13-04-2018</th>
                                </tr>
                                <thead class="thead-light">
                                <tr>
                                    <th scope="col">25€</th>
                                    <th scope="col">Limo Tintsen</th>
                                    <th scope="col">13-04-2018</th>
                                </tr>
                                </thead>
                                <tr>
                                    <th scope="col">20€</th>
                                    <th scope="col">Deremy Jalm</th>
                                    <th scope="col">12-04-2018</th>
                                </tr>
                                </tbody>
                            </table>

                        </div>
                    </div>
                    <div class="row">
                        <p style="margin: auto">Aangeboden
                            door: <?= $item['voornaam'] . " " . $item['achternaam'] . " uit " . $item['plaatsnaam']; ?> </p>
                        <img src="media/WatchTestJEREMY.jpg" alt="..." height="40px"
                             class="col-lg-2 rounded-circle float-right">
                    </div>
                </div>
            </div>
            <hr class="my-4">
            <p>Dit is een stukje text onder het bodenoverzicht en de foto</p>
        </div>
        <div class="row">
            <div class="col">
                <img src="media/WatchTestJEREMY.jpg" width="400px" height="200px" alt="..."
                     class="figure-img img-fluid rounded" style="position: relative">
            </div>
            <div class="col">
                <img src="media/WatchTestJEREMY.jpg" width="400px" height="200px" alt="..."
                     class="figure-img img-fluid rounded" style="position: relative">
            </div>
            <div class="col">
                <img src="media/WatchTestJEREMY.jpg" width="400px" height="200px" alt="..."
                     class="figure-img img-fluid rounded" style="position: relative">
            </div>
        </div>
    </div>
</div>

<?php
}
require_once 'footer.php'; ?>
</body>
