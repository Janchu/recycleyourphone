<?php
if (isset ( $_GET ["id"] )) {
	try {
		require_once 'laitePDO.php';
		$id = $_GET ["id"];
		$laitePDO = new laitePDO ();
		$laite = $laitePDO->haeTiettyId ( $id );
	} catch ( Exception $error ) {
		header ( "location: index.php" );
	}
}

?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Kiitos!</title>
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
			<h3></h3>
			<?php
			
print ("<p>Id: " . $laite->getId () . "<br>
						Tyyppi: " . $laite->getTyyppi () . "<br>
						Merkki: " . $laite->getMerkki () . "<br>
						Malli: " . $laite->getMalli () . "<br>
						Hankinta-ajankohta: " . $laite->getHankintaAjankohta () . "<br>
						Kuvaus: " . $laite->getKuvaus () . "<br>
						Takuu: " . $laite->getTakuu () . "<br>
						Hinta-arvio: " . $laite->getHinta () . "<br>") ;
			
			?>
			
			
			<br>
			<a href="laitteet.php"><input type="button" value="Takaisin"></a>
		</article>
		<footer>
			<p>Yhteystiedot</p>
		</footer>
	</div>
</body>
</html>