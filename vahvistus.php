<?php
require_once "laite.php";

session_start ();

if (isset ( $_SESSION ["laite"] )) {
	$laite = $_SESSION ["laite"];
} else {
	header ( "location: index.php" );
	exit ();
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
			<h3>Kiitos!</h3>
			<p>Laitteesi on lisätty id:llä <?php
			
print ($laite->getId ()) ;
			unset ( $_SESSION ["laite"] );
			?>.</p>

			<a href="index.php">Etusivulle</a>
		</article>
		<footer>
			<p>Yhteystiedot</p>
		</footer>
	</div>
</body>
</html>