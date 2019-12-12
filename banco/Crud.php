<?php

class Crud {
	private $tabela;
	
	function __construct($tabela) {
		$this->tabela = $tabela;
	}
	
	public function select($parametros) {
		try {
			$conn = new PDO("mysql:host=localhost;port=3306;dbname=cente376_sispsgraph", "cente376_sisgrap", "sis123");
			$stmt = $conn->prepare("SELECT * FROM $this->tabela WHERE $parametros;");
			$stmt->setFetchMode(PDO::FETCH_ASSOC);
			$stmt->execute();
			
			return $stmt->fetch();
		} catch(PDOException $e) {
			echo "ERROR: " . $e->getMessage();
		}
	}
	
	public function insert($atributos, $parametros) {
		try {
			$conn = new PDO("mysql:host=localhost;port=3306;dbname=cente376_sispsgraph", "cente376_sisgrap", "sis123");
			$stmt = $conn->prepare("INSERT INTO $this->tabela($atributos) VALUES($parametros);");
			$stmt->execute();
			
			return $stmt->rowCount();
		} catch(PDOException $e) {
			echo "ERROR: " . $e->getMessage();
		}
	}
}