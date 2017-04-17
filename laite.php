<?php
class Laite implements JsonSerializable {
	
	// Virhekoodit
	private static $virhelista = array (
			- 1 => "Tuntematon virhe",
			0 => "",
			11 => "Valitse laitteen tyyppi",
			21 => "Valmistaja ei voi olla tyhjä",
			22 => "Valmistajan nimi sisältää kiellettyjä merkkejä",
			23 => "Valmistajan nimi pitää olla vähintään 2 merkkiä pitkä",
			24 => "Valmistajan nimi ei saa sisältää yli 20 merkkiä",
			31 => "Malli ei voi olla tyhjä",
			32 => "Malli sisältää kiellettyjä merkkejä",
			33 => "Mallin nimi pitää olla vähintään 2 merkkiä pitkä",
			34 => "Malli ei saa sisältää yli 20 merkkiä",
			41 => "Hankinta-ajankohta pitää olla muotoa k/vvvv tai kk/vvvv",
			42 => "Kuukausi ei ole kelvollinen",
			43 => "Vuosi ei ole kelvollinen",
			44 => "Valitsemasi ajankohta on tulevaisuudessa",
			51 => "Kuvaus ei saa olla tyhjä",
			52 => "Kuvaus saa olla korkeintaan 500 merkkiä pitkä",
			53 => "Kuvauksessa on kiellettyjä merkkejä",
			61 => "Valitse takuun voimassaolo",
			71 => "Hinta on virheellinen",
			72 => "Hinta on liian pieni",
			73 => "Hinta on liian suuri" 
	);
	
	// Kertoo virhekoodia vastaavan virhetekstin
	public static function getError($virhekoodi) {
		if (isset ( self::$virhelista [$virhekoodi] ))
			return self::$virhelista [$virhekoodi];
		
		return self::$virhelista [- 1];
	}
	
	// Attribuutit
	private $tyyppi;
	private $merkki;
	private $malli;
	private $hankintaAjankohta;
	private $kuvaus;
	private $takuu;
	private $hinta;
	private $id;
	
	public function jsonSerialize() {
		return array (
				"id" => $this->id,
				"tyyppi" => $this->tyyppi,
				"merkki" => $this->merkki,
				"malli" => $this->malli,
				"hankintaAjankohta" => $this->hankintaAjankohta,
				"kuvaus" => $this->kuvaus,
				"takuu" => $this->takuu,
				"hintaArvio" => $this->hinta
		);
	}
	
	// Konstruktori
	function __construct($tyyppi = "", $merkki = "", $malli = "", $hankintaAjankohta = "", $kuvaus = "", $takuu = "", $hinta = "", $id = 0) {
		$this->tyyppi = $tyyppi;
		$this->merkki = trim ( mb_convert_case ( $merkki, MB_CASE_TITLE, "UTF-8" ) );
		$this->malli = trim ( mb_convert_case ( $malli, MB_CASE_TITLE, "UTF-8" ) );
		$this->hankintaAjankohta = trim ( $hankintaAjankohta );
		$this->kuvaus = trim ( $kuvaus, "UTF-8" );
		$this->takuu = $takuu;
		$this->hinta = trim ( $hinta );
		$this->id = $id;
	}
	
	// Setit, getit ja checkit
	public function setTyyppi($tyyppi) {
		$this->tyyppi = trim ( $tyyppi );
	}
	public function getTyyppi() {
		return $this->tyyppi;
	}
	public function checkTyyppi($required = true) {
		
		// Jos jättää valitsematta eli tulee eka option, jonka arvo on 0
		if ($this->tyyppi == 0) {
			return 11;
		}
		
		// Jos ok
		return 0;
	}
	public function setMerkki($merkki) {
		$this->merkki = trim ( $merkki );
	}
	public function getMerkki() {
		return $this->merkki;
	}
	public function checkMerkki($required = true, $min = 2, $max = 20) {
		
		// Merkki on pakollinen, jos on tyhjä:
		if ($required == true && strlen ( $this->merkki ) == 0) {
			return 21;
		}
		
		// Merkin muoto:
		if (preg_match ( "/[^1-9a-zA-ZÅÄÖåäö\+\- ]/", $this->merkki )) {
			return 22;
		}
		
		// Lyhin laitevalmistajan nimi on 2-kirjaiminen, joten merkin pituus ei saa olla alle 2:
		if (strlen ( $this->merkki ) < $min) {
			return 23;
		}
		
		// Merkin ylärajaksi varmuuden vuoksi 20:
		if (strlen ( $this->merkki ) > $max) {
			return 24;
		}
		
		// Jos merkki kelpaa:
		return 0;
	}
	public function setMalli($malli) {
		$this->malli = trim ( $malli );
	}
	public function getMalli() {
		return $this->malli;
	}
	public function checkMalli($required = true, $min = 1, $max = 20) {
		
		// Malli on pakollinen, jos on tyhjä:
		if ($required == true && strlen ( $this->malli ) == 0) {
			return 31;
		}
		
		// Mallin muoto:
		if (preg_match ( "/[^1-9a-zA-ZÅÄÖåäö–\- ]/", $this->malli )) {
			return 32;
		}
		
		// Mallin nimi pitää olla vähintään yksi merkki:
		if (strlen ( $this->malli ) < $min) {
			return 33;
		}
		
		// Mallin ylärajaksi varmuuden vuoksi 20:
		if (strlen ( $this->malli ) > $max) {
			return 34;
		}
		
		// Jos malli kelpaa:
		return 0;
	}
	public function setHankintaAjankohta($hankintaAjankohta) {
		$this->hankintaAjankohta = trim ( $hankintaAjankohta );
	}
	public function getHankintaAjankohta() {
		return $this->hankintaAjankohta;
	}
	public function checkHankintaAjankohta($required = false, $min = 6, $max = 7) {
		
		// Jos tyhjä niin ok
		if (strlen ( $this->hankintaAjankohta ) == 0) {
			return 0;
		}
		
		// Jos liian pitkä:
		if (strlen ( $this->hankintaAjankohta ) > $max && $empty = false) {
			return 41;
		}
		
		// Jos liian lyhyt:
		if (strlen ( $this->hankintaAjankohta ) < $min && $empty = false) {
			return 41;
		}
		
		// Pitää olla muotoa:
		if (! preg_match ( "/[0-9]{1,2}\/[0-9]{4}/", $this->hankintaAjankohta )) {
			return 41;
		}
		
		// Räjäytetään päivämäärä kauttaviivan kohdalta
		list ( $kk, $vvvv ) = explode ( "/", $this->hankintaAjankohta );
		
		// Tarkistetaan onko kk sallittu
		if ($kk > 12 || $kk < 1) {
			return 42;
		}
		
		// Tarkistetaan onko vuosi tämän vuosituhannen puolella
		if ($vvvv < 2000) {
			return 43;
		}
		
		// Tarkastetaan onko ajankohta tulevaisuudessa 
		// (päivää ei oteta huomioon koska hankinta-ajankohtaa kysyttiin kuukauden tarkkuudella)
		
		$nyt = time();
		
		
		list ( $kknyt, $ppnyt, $vvvvnyt ) = explode ( "-", date("d-m-Y", $nyt));
		
		if ( $vvvv > $vvvvnyt) {
			return 44;
		} elseif ($vvvv == $vvvvnyt && $kk > $kknyt) {
			return 44;
		}
		
		
		// Jos ok:
		return 0;
	}
	public function setKuvaus($kuvaus) {
		$this->kuvaus = trim ( $kuvaus );
	}
	public function getKuvaus() {
		return $this->kuvaus;
	}
	public function checkKuvaus($required = true, $min = 1, $max = 500) {
		
		// Kuvaus on pakollinen:
		if ($required == true && strlen ( $this->kuvaus ) == 0) {
			return 51;
		}
		
		// Kuvaus saa olla korkeintaan 500 merkkiä
		if (strlen ( $this->kuvaus ) > 500) {
			return 52;
		}
		
		// Kuvauksessa saa olla vain tiettyjä merkkejä
		if (preg_match ( "/[^1-9a-zA-ZÅÄÖåäö\-\.\, ]/", $this->kuvaus )) {
			return 53;
		}
		
		// Jos ok
		return 0;
	}
	public function setTakuu($takuu) {
		$this->takuu = trim ( $takuu );
	}
	public function getTakuu() {
		return $this->takuu;
	}
	public function checkTakuu($required = true) {
		
		// Jos jättää valitsematta eli tulee eka option, jonka arvo on 0
		if ($this->takuu == 0) {
			return 61;
		}
		
		// Jos ok
		return 0;
	}
	public function setHinta($hinta) {
		$this->hinta = trim ( $hinta );
	}
	public function getHinta() {
		return $this->hinta;
	}
	public function checkHinta($required = false, $min = 0.0, $max = 2000.0) {
		
		// Hinta-arvion saa jättää tyhjäksi
		if ($required == false && strlen ( $this->hinta ) == 0) {
			return 0;
		}
		
		// Jos hinnan muoto ei ole oikea
		if (! preg_match ( "/^[0-9]{1,}([,.][0-9]{1,2})?/", $this->hinta )) {
			return 71;
		}
		
		// Jos hinta on liian pieni
		if ($this->hinta < $min) {
			return 72;
		}
		
		// Jos hinta on liian suuri
		if ($this->hinta > $max) {
			return 73;
		}
		
		// Jos kaikki ok
		return 0;
	}
	public function setId($id) {
		$this->id = trim ( $id );
	}
	public function getId() {
		return $this->id;
	}
}