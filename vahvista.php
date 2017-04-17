<?php
require_once "laite.php";

session_start ();

if (isset ( $_SESSION ["laite"] )) {
	$laite = $_SESSION ["laite"];
} else {
	header ( "location: index.php" );
	exit ();
}

if (isset ( $_POST ["peruuta"] )) {
	unset ( $_SESSION ["laite"] );
	header ( "location: index.php" );
	exit ();
} elseif (isset ( $_POST ["korjaa"] )) {
	header ( "location: lisaa.php" );
	exit ();
} elseif (isset ( $_POST ["laheta"] )) {
	try {
		require_once 'laitePDO.php';

		$laitePDO = new laitePDO ();
		
		$id = $laitePDO->lisaaLaite ( $laite );
		
		// Pyydetään uusi annettu id session oliolle
		$_SESSION ["laite"]->setId ( $id );
	} catch ( Exception $error ) {
		session_write_close ();
		header ( "location: index.php?virhe=" . $error->getMessage () );
		exit ();
	}
	
	session_write_close ();
	header ( "location: vahvistus.php" );
	exit ();
}

?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Vahvista lisäys</title>
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
			<h3>Syöttämäsi tiedot</h3>
					<?php
					if ($laite->getTyyppi () == 1) {
						$tyyppi = "Puhelin";
					} elseif ($laite->getTyyppi () == 2) {
						$tyyppi = "Tabletti";
					}
					
					if ($laite->getTakuu () == 1) {
						$takuu = "Kyllä";
					} elseif ($laite->getTakuu () == 2) {
						$takuu = "Ei";
					}
					
					if ($laite->getHankintaAjankohta () == "") {
						$hankintaAjankohta = "-";
					} else {
						$hankintaAjankohta = $laite->getHankintaAjankohta ();
					}
					
					if ($laite->getHinta () == "") {
						$hinta = "-";
					} else {
						$hinta = $laite->getHinta ();
					}
					
					print ("<p>Tyyppi: " . $tyyppi) ;
					print ("<br>Merkki: " . $laite->getMerkki ()) ;
					print ("<br>Malli: " . $laite->getMalli ()) ;
					print ("<br>Hankinta-ajankohta: " . $hankintaAjankohta) ;
					print ("<br>Kuvaus: " . $laite->getKuvaus ()) ;
					print ("<br>Takuu: " . $takuu) ;
					print ("<br>Hinta-arvio: " . $hinta . "</p>") ;
					?>
			<form action="vahvista.php" method="post">
				<input type="submit" name="peruuta" value="Peruuta"> <input
					type="submit" name="korjaa" value="Korjaa"> <input type="submit"
					name="laheta" value="Lähetä">
			</form>
		</article>
		<footer>
			<p>Yhteystiedot</p>
		</footer>
	</div>
</body>
</html>