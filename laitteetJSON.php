<?php
try {
	require_once "laitePDO.php";
	
	// Luodaan tietokanta-luokan olio
	$laitePDO = new laitePDO ();
	
	if (isset ( $_GET ["merkki"] )) {
		
		// Haetaan kannasta
		$tulos = $laitePDO->haeMerkilla ( $_GET ["merkki"] );
		
		// Palautetaan vastaus JSON-tekstina
		print (json_encode ( $tulos )) ;
	} 	// Jos getissä ei ollut mitään palautetaan kaikki kannasta löytyneet
	else {
		$tulos = $laitePDO->kaikkiLaitteet ();
		
		// Palautetaan vastaus JSON-tekstina
		print (json_encode ( $tulos )) ;
	}
} catch ( Exception $error ) {
}
?>