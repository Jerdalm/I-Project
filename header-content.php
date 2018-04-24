<?php

$header_content = <<<HEAD
	<body>
	<header id="header-content">
		<div class="logo">
			<img src="../I-Project/img/logo/logo.svg" class="">
		</div>

		<nav>
			<ul>
				<li>
					<a href="/">Alle veilingen</a>
				</li>
				<li>
					<a href="/">Inloggen|Registeren</a>
				</li>
			</ul>
		</nav>

		<form>
      		<input type="text" class="" id="your-product" placeholder="Uw product">
      		<button>Zoeken</button>
      	</form>
	</header>	
HEAD;

echo $header_content;
?>
