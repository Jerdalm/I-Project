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
<button class="btn btn-success" type="submit">Zoeken <i class="fas fa-sync-alt"></i></button>
</form>