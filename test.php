<script>
	setInterval(function()
	{
		$('.product-data').load(document.URL +  ' .product-data');

	}, 1000); 
</script>

<?php
require_once './header.php';
$resttijd = calculateTimeDiffrence('2013-01-01 15:03:01', date('Y-m-d h:i:s'));
?>

<div class="product-data">
	<p><?=$resttijd?></p>
</div>