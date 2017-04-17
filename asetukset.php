<?php

if (isset ( $_POST ["muokkaa"] )) {
	
	$nimesi = $_POST ["nimesi"];
	
	setcookie ( "nimesi", $nimesi, (time () + 60 * 60 * 24 * 7) );
	
}

?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Asetukset</title>
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
			
			<fieldset>
				<form action="index.php" method="post">
					<label>Nimesi: </label><input type="text" name="nimesi" value="<?php print($_COOKIE["nimesi"]) ?>"> <input
						type="submit" name="muokkaa" value="Muuta nimeä">
				</form>
			</fieldset>
		</article>
		<footer>
			<p>Yhteystiedot</p>
		</footer>
	</div>
</body>
</html>