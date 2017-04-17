<?php
require_once "laite.php";

session_start ();

if (isset ( $_POST ["laheta"] )) {
	// Luodaan olio lomakekenttien tiedoista
	$laite = new Laite ( $_POST ["tyyppi"], $_POST ["merkki"], $_POST ["malli"], $_POST ["hankintaAjankohta"], $_POST ["kuvaus"], $_POST ["takuu"], $_POST ["hinta"] );
	
	// Laitetaan luotu olio sessioon
	$_SESSION ["laite"] = $laite;
	session_write_close ();
	
	$tyyppiVirhe = $laite->checkTyyppi ();
	$merkkiVirhe = $laite->checkMerkki ();
	$malliVirhe = $laite->checkMalli ();
	$hankintaAjankohtaVirhe = $laite->checkHankintaAjankohta ();
	$kuvausVirhe = $laite->checkKuvaus ();
	$takuuVirhe = $laite->checkTakuu ();
	$hintaVirhe = $laite->checkHinta ();
	
	if ($tyyppiVirhe == 0 && $merkkiVirhe == 0 && $malliVirhe == 0 && $hankintaAjankohtaVirhe == 0 && $kuvausVirhe == 0 && $takuuVirhe == 0 && $hintaVirhe == 0) {
		header ( "location: vahvista.php" );
		exit ();
	}
} elseif (isset ( $_POST ["peruuta"] )) {
	unset ( $_SESSION ["laite"] );
	header ( "location: index.php" );
	exit ();
} else {
	// Luodaan tyhjä olio ekaa kertata sivulle tulevalle
	
	if (isset ( $_SESSION ["laite"] )) {
		$laite = $_SESSION["laite"];
		$tyyppiVirhe = $laite->checkTyyppi ();
		$merkkiVirhe = $laite->checkMerkki ();
		$malliVirhe = $laite->checkMalli ();
		$hankintaAjankohtaVirhe = $laite->checkHankintaAjankohta ();
		$kuvausVirhe = $laite->checkKuvaus ();
		$takuuVirhe = $laite->checkTakuu ();
		$hintaVirhe = $laite->checkHinta ();
	} else {
		$laite = new Laite ();
		$tyyppiVirhe = 0;
		$merkkiVirhe = 0;
		$malliVirhe = 0;
		$hankintaAjankohtaVirhe = 0;
		$kuvausVirhe = 0;
		$takuuVirhe = 0;
		$hintaVirhe = 0;
	}
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Lahjoita laite</title>
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

			<h2>Lahjoita käytetty älylaitteesi</h2>

			<form action="lisaa.php" method="post">
				<fieldset>
					<legend>Laitteen tiedot</legend>

					<p>
						<label>Laitteen tyyppi <span class="punainen">*</span></label> <select
							name="tyyppi">
							<option value="0"
								<?php if($laite->getTyyppi() == '0' || $laite->getTyyppi() == "") { ?>
								selected <?php } ?>>Valitse</option>
							<option value="1" <?php if($laite->getTyyppi() == '1') { ?>
								selected <?php } ?>>Puhelin</option>
							<option value="2" <?php if($laite->getTyyppi() == '2') { ?>
								selected <?php } ?>>Tabletti</option>
						</select> <span class="error"><?php print($laite->getError($tyyppiVirhe));?></span>
					</p>
					<p>
						<label>Merkki <span class="punainen">*</span></label> <input
							type="text" name="merkki"
							value="<?php print(htmlentities($laite->getMerkki(), ENT_QUOTES, "UTF-8"));?>">
						<span class="error"><?php print($laite->getError($merkkiVirhe));?></span>
					</p>
					<p>
						<label>Malli <span class="punainen">*</span></label> <input
							type="text" name="malli"
							value="<?php print(htmlentities($laite->getMalli(), ENT_QUOTES, "UTF-8"));?>">
						<span class="error"><?php print($laite->getError($malliVirhe));?></span>
					</p>
					<p>
						<label>Hankinta-ajankohta </label> <input type="text"
							placeholder="kk/vvvv" name="hankintaAjankohta"
							value="<?php print(htmlentities($laite->getHankintaAjankohta(), ENT_QUOTES, "UTF-8"));?>">
						<span class="error"><?php print($laite->getError($hankintaAjankohtaVirhe));?></span>
					</p>

					<p>
						<label>Kuvaus <span class="punainen">*</span></label>
						<textarea class="kuvaus" rows="15" name="kuvaus"><?php print(htmlentities($laite->getKuvaus(), ENT_QUOTES, "UTF-8"));?></textarea>
						<span class="error"><?php print($laite->getError($kuvausVirhe));?></span>
					</p>

					<p>
						<label>Takuu voimassa <span class="punainen">*</span></label> <select
							name="takuu">
							<option value="0"
								<?php if($laite->getTakuu() == '0' || $laite->getTakuu() == "") { ?>
								selected <?php } ?>>Valitse</option>
							<option value="1" <?php if($laite->getTakuu() == '1') { ?> selected
								<?php } ?>>Kyllä</option>
							<option value="2" <?php if($laite->getTakuu() == '2') { ?> selected
								<?php } ?>>Ei</option>
						</select> <span class="error"><?php print($laite->getError($takuuVirhe));?></span>
					</p>
					<p>
						<label>Oma hinta-arvio </label> <input type="text" name="hinta"
							value="<?php print(htmlentities($laite->getHinta(), ENT_QUOTES, "UTF-8"));?>">
						<span class="error"><?php print($laite->getError($hintaVirhe));?></span>
					</p>

					<p>
						<input class="sininen" type="submit" name="laheta" value="Talleta">
						<input class="sininen" type="submit" name="peruuta"
							value="Peruuta">
					</p>
				</fieldset>
			</form>
		</article>
		<footer>
			<p>Kukkuu</p>
		</footer>
	</div>
</body>
</html>