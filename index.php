<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Kierrätä luurisi!</title>
<meta name="author" content="Janne Jäppinen">
<link rel="stylesheet" href="tyyli.css">
<link href='https://fonts.googleapis.com/css?family=Raleway'
	rel='stylesheet' type='text/css'>
</head>
<body>
	<div id="wrapper">
		<header>
			<a href="index.php"><img src="/OmaWebSovellus/kuvat/logo.png"
				alt="Logo"></a>
			<nav>
				<ul>
					<li><a href="index.php">Etusivu</a></li>
					<li><a href="laitteet.php">Laitteet</a></li>
					<li><a href="hae.php">Hae (JSON)</a></li>
					<li><a href="lisaa.php">Kierrätä laitteesi</a></li>
					<li><a href="asetukset.php">Asetukset</a></li>					
				</ul>
			</nav>
		</header>
		<article>
			<?php
			if (isset ( $_COOKIE ["nimesi"] )) {
				print ("<h1>Tervetuloa, " . $_COOKIE["nimesi"] . "!</h1>");
			} else {
				print ("<h1>Tervetuloa!</h1>");
			}
			?>
			<p>Olemme $yrityksenNimi ja olemme erikoistuneet puhelinten ja muiden
				älylaitteiden kierrätykseen.</p>
			<p>Lähetä meille täysin tai lähes käyttökelpoinen vanha älylaitteesi
				ja me laitamme sen kuntoon ja myymme sen. Tuotoista lahjoitamme 5%
				hyväntekeväisyyteen.</p>
			<p>Auta siis maailmaa kierrättämällä ja osallistumalla samalla
				hyväntekeväisyyteen!</p>
			<p>Have a nice day!</p>
		</article>
		<footer>
			<p>$yrityksenNimi</p>
			<p>$osoite</p>
		</footer>
	</div>
</body>
</html>