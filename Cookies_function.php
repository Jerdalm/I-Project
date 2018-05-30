<!DOCTYPE html>
<?php
$username;
$vwarray[];
$month_in_sec = 2592000;
setcookie($username, $vwarray[], time() + $month_in_sec); // 86400 = 1 day


$Resultaten ="";
?>
<html>
<body>

<?php
if (!isset($_COOKIE[$cookie_name])) {


    function showProducts($carrousel = false, $query = false, $parameters = false, $lg = 4, $md = 6, $sm = 6, $xs = 12)
    {
        if (is_array($query)) {
            $producten = $query;
        } else {

            if ($query == false) {
                if (isset($vwarray[])) {
                if (isset($_SESSION[$username])) {

}
                }
            } else {
                $query = "SELECT * from currentAuction";
            }

            if ($parameters) {
                $producten = handlequery($query, $parameters);

            } else {
                $producten = handlequery($query);

            }
        }

        $beforeInput = '';
        $afterInput = '';
        $html = '';
        $itemcount = 0;

        if ($carrousel) {
            $beforeFirstInput = '<div class="carousel-item col-lg-' . $lg . ' col-md-' . $md . ' col-sm-' . $sm . ' col-xs-' . $xs . ' active">';
            $beforeInput = '<div class="carousel-item col-lg-' . $lg . ' col-md-' . $md . ' col-sm-' . $sm . ' col-xs-' . $xs . '">';
            $afterInput = '</div>';
        } else {
            $beforeInput = '<div class="col-lg-' . $lg . ' col-md-' . $md . ' col-sm-' . $sm . ' col-xs-' . $xs . '">';
            $afterInput = '</div>';
        }

        foreach ($producten as $product) {

            $itemcount++;
            if (!$product['bodbedrag']) {
                $product['bodbedrag'] = 0;
            }

            if ($carrousel) {
                if ($itemcount == 1) {
                    $html .= $beforeFirstInput;
                } else {
                    $html .= $beforeInput;
                }
            } else {
                $html .= $beforeInput;
            }

            $timediff = calculateTimeDiffrence(date('Y-m-d h:i:s'),
                $product['einddag'] . ' ' . $product['eindtijdstip']
            );

            $html .= '
    <div class="product card">
        <img class="card-img-top img-fluid" src="img/products/' . $product['bestand'] . '" alt="">
        <div class="card-body">
            <h4 class="card-title">
                ' . $product['titel'] . '
            </h4>
            <h5 class="product-data" id="' . $product['voorwerpnummer'] . '"><span class="time">' . $timediff . '</span>|<span class="price">&euro;' . $product['bodbedrag'] . '</span></h5>
            <a href="productpage.php?product=' . $product['voorwerpnummer'] . '" class="btn cta-white">Bekijk nu</a>
        </div>
    </div>
    ';
            $html .= $afterInput;
        }
        /* Returns product cards html */
        return $html;
    }
}
?>
