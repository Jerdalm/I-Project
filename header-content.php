<?php

$header_content = <<<HEAD
	<body>
	<header id="header-content">
		<div class="container">
  			<div class="row">
  				<div class="col align-middle">
					<div class="logo">
						<p><a href="/"><strong>Eenmaal</strong> Andermaal</a></p>
					</div>
				</div>

				<div class="col align-middle">
					<a href="/">Alle veilingen</a>
				</div>
								

				<div class="col align-middle">
					<a href="/">Inloggen|Registreren</a>
				</div>

				<div class="col align-middle">
					<form>
			      		<input type="text" class="" id="your-product" placeholder="Uw product">
			      		<button>Zoeken</button>
			      	</form>
			    </div>
			</div>
		</div>
	</header>	
HEAD;

echo $header_content;
?>
