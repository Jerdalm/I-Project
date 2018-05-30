<?php require_once('header.php'); ?>
<br>
<br>
<br>
<br>
<br>
<?php
$vwarray[] = [9, 6, 3, 2, 7, 4];
$username = $_SESSION['username'];
$vwNummer = $_SESSION['vwnummer'];
AddCookie($username, $vwarray);
GetSimilarItems($username, $vwNummer);
function AddCookie($CookieName, $ItemArray)
{
foreach($vwarray as $voorwerp){

}
    $month_in_sec = 2592000;
    setcookie($CookieName, serialize($ItemArray), time() + $month_in_sec);

}

function GetSimilarItems($username, $vwNummer)
{
    $data = unserialize($_COOKIE[$username]);

    $datalist = ($data[0][0] . ',' . $data[0][1] . ',' . $data[0][2] . ',' . $data[0][3] . ',' . $data[0][4] . ',' . $data[0][5]);
print_r($datalist);

    $Arrayquery = "SELECT C.*
                  FROM currentAuction C
                  INNER JOIN VoorwerpInRubriek V
                  ON V.voorwerpnummer = C.voorwerpnummer
                  INNER JOIN rubriek R
                  ON R.rubrieknummer = V.rubriekOpLaagsteNiveau
                  WHERE C.voorwerpnummer IN ($datalist)/* cookie voorwerpen */
                  AND C.voorwerpnummer != $vwNummer";/* Waarde huidig nummer */

    $Resultaten = handlequery($Arrayquery);
    print_r($Resultaten);
}

?>

