<?php 
if(isset($_SESSION['gebruikersnaam'])){
 ?>

<h4 class="text-center"> Afstand </h4>
<form method="get" action="">
<div class="form-group">
  <label for="sel1">afstand in KM:</label>
  <select class="form-control"name="dis" id="distanceFilter"  onchange="this.form.submit()">
	<option></option>
    <option value="3">< 3 km</option>
    <option value="5">< 5 km</option>
    <option value="10">< 10 km</option>
    <option value="15">< 15 km</option>
	<option value="25">< 25 km</option>
	<option value="50">< 50 km</option>
	<option value="75">< 75 km</option>
  </select>
 </div>
 <?php foreach($_GET as $key => $value){ 
if($key == 'dis'){
}else{
?> 
<input type='hidden' name='<?= $key; ?>' value='<?= $value; ?>' />
<?php }}} ?>
</form>