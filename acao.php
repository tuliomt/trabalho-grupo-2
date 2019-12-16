<?php

include_once "banco/Crud.php";

class Acao {
	public function criarPasta($usuario, $estacao = "") {
		$uploaddir = dirname(__FILE__) . "/estacoes/$usuario/$estacao";     
		
		if (!is_dir($uploaddir)) {
		   mkdir($uploaddir);
		}
	}

	public function inserirUsuario() {
		$atributos = "usuario, senha";
		$parametros = "'" . $_POST["usuario"] . "', '" . md5($_POST["senha"]) . "'"; 

		$usuario = (new Crud("usuarios"))->insert($atributos, $parametros);

		if($usuario) {
			self::criarPasta($_POST["usuario"]);
			
			echo true;
		}
		else
			echo false;
	}
	
	public function selectUsuario() {
		$parametros = "usuario = '" . $_POST["usuario"] . "' AND senha = '" . md5($_POST["senha"]) . "'"; 

		$usuario = (new Crud("usuarios"))->select($parametros);

		if($usuario) {
			echo $usuario["usuario"];
		}
		else
			echo false;
	}
}

(new Acao)->{$_GET["acao"]}();