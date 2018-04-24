<?php 
require_once 'head.php';
require_once 'header-content.php'; 
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['login'])) {
    	require_once 'login.php';
    }
}
?>

<main>
	<div class="container">
		<div class="row row-right">
			 
    	<form>
	    	<div class="form-group col-md-6">
	      		<label for="inputEmail4">Email</label>
	      		<input type="email" class="form-control" id="email" placeholder="Email">
	    	</div>
	    	<div class="form-group col-md-6">
	      		<label for="inputPassword4">Password</label>
	      		<input type="password" class="form-control" id="wachtwoord" placeholder="Wachtwoord">
	    	</div>
		  	
		 	<button type="submit" class="btn btn-primary">Login</button>
		</form>

		</div>
	</div>
</main>


<?php require_once 'footer.php'; ?>