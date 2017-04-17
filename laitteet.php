<?php
if (isset ( $_POST ["nayta"] )) {
	header ( "location: nayta.php?id=" . $_POST ["id"] );
	exit ();
} elseif (isset ( $_POST ["poista"] )) {
	$id = $_POST["id"];
	try {
		require_once 'laitePDO.php';
		$laitePDO = new laitePDO ();
		$laite = $laitePDO->poistaLaite( $id );
	} catch ( Exception $error ) {
		header ( "location: index.php" );
	}
}

?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Laitteet</title>
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

			<h3>Laitteet</h3>
			<table>
			<?php
			try {
				require_once 'laitePDO.php';
				
				$laitePDO = new laitePDO ();
				
				$rivit = $laitePDO->kaikkiLaitteet ();
				
				foreach ( $rivit as $laite ) {
					print ("<tr><td>" . $laite->getMerkki () . " " . $laite->getMalli () . "</td>
							<td>
							<form method=\"post\">
							<input type=\"hidden\" name=\"id\" value=\"" . $laite->getId () . "\">
							<input type=\"submit\" name=\"nayta\" value=\"Näytä\">
							<input type=\"submit\" name=\"poista\" value=\"Poista\">
							</form>
							</td>
							<tr><td><br></td></tr>
							") ;
				}
			} catch ( Exception $error ) {
				header ( "location: index.php" );
			}
			
			?>
			</table>
		</article>
		<footer>
			<p>Yhteystiedot</p>
		</footer>
	</div>
</body>
</html>