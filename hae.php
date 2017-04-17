<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Yhteystiedot</title>
<meta name="author" content="Janne Jäppinen">
<link rel="stylesheet" href="tyyli.css">
<link href='https://fonts.googleapis.com/css?family=Raleway'
	rel='stylesheet' type='text/css'>
<script src="http://code.jquery.com/jquery-2.2.4.min.js"
	integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44="
	crossorigin="anonymous"></script>
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
			<h3>Hae tietynmerkkisiä laitteita</h3>

			<form action="" method="post">
				<input type="text" id="merkki" name="merkki"> <input type="button"
					id="hae" name="hae" value="hae">
			</form>
			<br>
			<div style="margin-bottom: 0.5cm" id="lista"></div>
			<p>
				<a href="index.php">Etusivulle</a>
			</p>

		</article>
		<footer>
			<p>Yhteystiedot</p>
		</footer>
	</div>

	<script type="text/javascript">

		$(document).on("ready", function() {
			
			// Kun painiketta id="hae" painetaan
			$("#hae").on("click", function() {
				$.ajax({
					url: "laitteetJSON.php",  // PHP-sivu, jota haetaan AJAX:lla
					method: "get",
					data: {merkki: $("#merkki").val()},  // Hakukriteeri on merkki
					dataType: "json",
					timeout: 5000
				})
				// AJAX haku onnistui
				.done(function(data) {
					// Tyhjennetään elementti, johon vastaus laitetaan
					$("#lista").html("");

					// Käydään taulukko läpi
					for(var i = 0; i < data.length; i++) {
						// Laitetaan info lista-diviin
						$("#lista").append("<p>Id: " + data[i].id +
						"<br>Merkki: " + data[i].merkki +
						"<br>Malli: " + data[i].malli +
						"<br>Kuvaus: " + data[i].kuvaus + "</p>");
					}
					// Jos vastauksena  oli tyhjä taulukko
					if (data.length == 0) {
						$("#lista").append("<p>Haulla ei löytynyt yhtään laitetta</p>")
					}
				})
				// AJAX haku ei onnistunut
				.fail(function() {
					$("#lista").html("<p>Listausta ei voida tehdä</p>");
				});
				
			});
		});
	</script>

</body>
</html>