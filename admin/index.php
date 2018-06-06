<?php 
require_once './header.php'; 
if (isset($_SESSION['gebruikersnaam'])){
	redirectJS("./change-article.php");
} else {
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		if (isset($_POST['login-submit-admin'])) {
			if(($_POST['email-login'] === "admin@root.com" || $_POST['email-login'] === "admin") && $_POST['wachtwoord'] == "iproject34"){
				$_SESSION['gebruikersnaam'] = "admin";
				redirectJS("./admin-pagina.php");
			} else {
				$errorLoginAdmin = "Wachtwoord of email/gebruikersnaam klopt niet";
			}
		}
	}
}

?>

<main>
	<div class="container">
		<form method="post" id="login-form">
			<div class="form-group">
				<label for="inputEmail">Email</label>
				<input type="text" class="form-control" id="email-login" name="email-login">
			</div>
			<div class="form-group">
				<label for="inputPassword">Wachtwoord</label>
				<input type="password" class="form-control" id="wachtwoord" name="wachtwoord">
			</div>
			<a href= "wachtwoord-vergeten.php"> Wachtwoord Vergeten? </a><br><br>
			<button type="submit" name="login-submit-admin" class="btn btn-primary">Login</button>
		</form>
		<p class="error error-warning"><?php if(isset($errorLoginAdmin)){echo $errorLoginAdmin;}?></p>
	</div>
</main>

<?php 
require_once './footer.php'; 
?>