<?php
require_once 'laite.php';
class laitePDO {
	private $db;
	private $lkm;
	function __construct($dsn = "mysql:host=localhost;dbname=recycleyourphone", $user = "recycleyourphone", $password = "wwUhCqVJ5FPkYqasEKUC") {
		// Yhteys kantaan
		$this->db = new PDO ( $dsn, $user, $password );
		
		// Virheiden jäljitys kehitysaikana
		$this->db->setAttribute ( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );
		
		// Estetään SQL injektio
		$this->db->setAttribute ( PDO::ATTR_EMULATE_PREPARES, false );
		
		// Tulosrivit
		$this->lkm = 0;
	}
	function getLkm() {
		return $this->lkm;
	}
	public function kaikkiLaitteet() {
		$sql = "SELECT id, tyyppi, merkki, malli, hankintaAjankohta, kuvaus, takuu, hintaArvio FROM laitteet";
		
		// Valmistellaan lause
		if (! $stmt = $this->db->prepare ( $sql )) {
			$virhe = $this->db->errorInfo ();
			
			throw new PDOException ( $virhe [2], $virhe [1] );
		}
		
		// Suoritetaan lause
		if (! $stmt->execute ()) {
			$virhe = $stmt->errorInfo ();
			
			throw new PDOException ( $virhe [2], $virhe [1] );
		}
		
		// Luodaan haun tulosta varten lista
		$tulos = array ();
		
		// Käydään tulokset riveittän läpi
		while ( $row = $stmt->fetchObject () ) {
			// Luodaan laite-luokan olio
			$laite = new Laite ();
			
			$laite->setId ( $row->id );
			$laite->setTyyppi ( $row->tyyppi );
			$laite->setMerkki ( utf8_encode ( $row->merkki ) );
			$laite->setMalli ( utf8_encode ( $row->malli ) );
			$laite->setHankintaAjankohta ( utf8_encode ( $row->hankintaAjankohta ) );
			$laite->setKuvaus ( utf8_encode ( $row->kuvaus ) );
			$laite->setTakuu ( $row->takuu );
			$laite->setHinta ( $row->hintaArvio );
			
			$tulos [] = $laite;
		}
		
		$this->lkm = $stmt->rowCount ();
		
		return $tulos;
	}
	public function haeMerkilla($merkki) {
		$sql = "SELECT * FROM laitteet WHERE merkki like :merkki";
		
		// Valmistellaan lause
		if (! $stmt = $this->db->prepare ( $sql )) {
			$virhe = $this->db->errorInfo ();
			throw new PDOException ( $virhe [2], $virhe [1] );
		}
		
		// Sidotaan parametrit
		$haettava = "%" . utf8_decode ( $merkki ) . "%";
		$stmt->bindValue ( ":merkki", $haettava, PDO::PARAM_STR );
		
		// Suoritetaan lause
		if (! $stmt->execute ()) {
			$virhe = $stmt->errorInfo ();
			
			if ($virhe [0] == "HY093") {
				$virhe [2] = "Invalid parameter";
			}
			
			throw new PDOException ( $virhe [2], $virhe [1] );
		}
		
		// Luodaan haun tulosta varten lista
		$tulos = array ();
		
		// Käydään tulokset riveittän läpi
		while ( $row = $stmt->fetchObject () ) {
			// Luodaan laite-luokan olio
			$laite = new Laite ();
			
			$laite->setId ( $row->id );
			$laite->setTyyppi ( $row->tyyppi );
			$laite->setMerkki ( utf8_encode ( $row->merkki ) );
			$laite->setMalli ( utf8_encode ( $row->malli ) );
			$laite->setHankintaAjankohta ( utf8_encode ( $row->hankintaAjankohta ) );
			$laite->setKuvaus ( utf8_encode ( $row->kuvaus ) );
			$laite->setTakuu ( $row->takuu );
			$laite->setHinta ( $row->hintaArvio );
			
			$tulos [] = $laite;
		}
		
		$this->lkm = $stmt->rowCount ();
		
		return $tulos;
	}
	function haeTiettyId($id) {
		$sql = "SELECT * 
				FROM laitteet
				WHERE id like :id";
		
		// Valmistellaan select
		if (! $stmt = $this->db->prepare ( $sql )) {
			$virhe = $this->db->errorInfo ();
			throw new PDOException ( $virhe [2], $virhe [1] );
		}
		
		// Sidotaan parametri
		$stmt->bindValue ( ":id", $id, PDO::PARAM_INT );
		
		// Suoritetaan
		if (! $stmt->execute ()) {
			$virhe = $stmt->errorInfo ();
			
			if ($virhe [0] == "HY093") {
				$virhe [2] = "Invalid parameter";
			}
			
			throw new PDOException ( $virhe [2], $virhe [1] );
		}
		
		// Luodaan laite olio
		$rivi = $stmt->fetchObject ();
		
		$laite = new Laite ();
		
		$laite->setId ( $id );
		$laite->setTyyppi ( $rivi->tyyppi );
		$laite->setMerkki ( utf8_encode ( $rivi->merkki ) );
		$laite->setMalli ( utf8_encode ( $rivi->malli ) );
		$laite->setHankintaAjankohta ( utf8_encode ( $rivi->hankintaAjankohta ) );
		$laite->setKuvaus ( utf8_encode ( $rivi->kuvaus ) );
		$laite->setTakuu ( $rivi->takuu );
		$laite->setHinta ( utf8_encode ( $rivi->hintaArvio ) );
		
		return $laite;
	}
	function lisaaLaite($laite) {
		$sql = "INSERT into laitteet (tyyppi, merkki, malli, hankintaAjankohta, kuvaus, takuu, hintaArvio)
				values (:tyyppi, :merkki, :malli, :hankintaAjankohta, :kuvaus, :takuu, :hintaArvio)";
		
		// Valmistellaan
		if (! $stmt = $this->db->prepare ( $sql )) {
			$virhe = $this->db->errorInfo ();
			throw new PDOException ( $virhe [2], $virhe [1] );
		}
		
		// Sidotaan parametrit
		$stmt->bindValue ( ":tyyppi", $laite->getTyyppi (), PDO::PARAM_INT );
		$stmt->bindValue ( ":merkki", utf8_decode ( $laite->getMerkki () ), PDO::PARAM_STR );
		$stmt->bindValue ( ":malli", utf8_decode ( $laite->getMalli () ), PDO::PARAM_STR );
		$stmt->bindValue ( ":hankintaAjankohta", utf8_decode ( $laite->getHankintaAjankohta () ), PDO::PARAM_STR );
		$stmt->bindValue ( ":kuvaus", utf8_decode ( $laite->getKuvaus () ), PDO::PARAM_STR );
		$stmt->bindValue ( ":takuu", $laite->getTakuu (), PDO::PARAM_INT );
		$stmt->bindValue ( ":hintaArvio", utf8_decode ( $laite->getHinta () ), PDO::PARAM_STR );
		
		// Transaktio
		$this->db->beginTransaction ();
		
		// Suoritetaan insert
		if (! $stmt->execute ()) {
			$virhe = $stmt->errorInfo ();
			
			if ($virhe [0] == "HY093") {
				$virhe [2] = "Invalid parameter";
			}
			
			// Perutaan tapahtuma virheen sattuessa
			$this->db->rollBack ();
			
			throw new PDOException ( $virhe [2], $virhe [1] );
		}
		
		$this->lkm = 1;
		
		// id talteen
		$id = $this->db->lastInsertId ();
		
		$this->db->commit ();
		
		// Palautetaan id
		return $id;
	}
	function poistaLaite($id) {
		$sql = "DELETE FROM laitteet WHERE id like :id";
		
		// Valmistellaan select
		if (! $stmt = $this->db->prepare ( $sql )) {
			$virhe = $this->db->errorInfo ();
			throw new PDOException ( $virhe [2], $virhe [1] );
		}
		
		// Sidotaan parametri
		$stmt->bindValue ( ":id", $id, PDO::PARAM_INT );
		
		// Suoritetaan
		if (! $stmt->execute ()) {
			$virhe = $stmt->errorInfo ();
			
			if ($virhe [0] == "HY093") {
				$virhe [2] = "Invalid parameter";
			}
			
			throw new PDOException ( $virhe [2], $virhe [1] );
		}
	}
}
