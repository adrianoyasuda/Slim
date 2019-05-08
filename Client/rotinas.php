<?php

	function getConn() {

		return new PDO('mysql:host=localhost;dbname=AulaSlim', 'root', 'root',
					array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
	}

	function GET() {

		// DADO DE ENTRADA VAZIO - ERRO
		if($_POST['usuario_get'] == "") {
		 	return json_encode( array('msg' => '[ERRO] Preencha o Campo de Entrada!') );
		}

		// MONTA ARRAY DE DADOS
		$dados = array('usuario' => $_POST['usuario_get'],
						'senha' => $_POST['senha_get']);

		// INICIALIZA/CONFIGURA CURL
		$curl = curl_init("http://localhost/Slim/rest.php/".json_encode($dados));
		// CONFIGURA AS OPÇÕES (parâmetros)
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		// INVOCA A URL DO WEBSERVICE
		$curl_resposta = curl_exec($curl);
		curl_close($curl);

		return $curl_resposta;
	}

	function POST() {

		// DADO DE ENTRADA VAZIO - ERRO
		if($_POST['nome_post'] == "") {
			return json_encode( array('msg' => '[ERRO] Preencha o Campo de Entrada!') );
		}

		// MONTA ARRAY DE DADOS
		$dados = array('nome' => $_POST['nome_post'], 
						'usuario' => $_POST['usuario_post'],
						'senha' => $_POST['senha_post'] );

		// INICIALIZA/CONFIGURA CURL
		$curl = curl_init("http://localhost/Slim/rest.php");
		// CONFIGURA AS OPÇÕES (parâmetros)
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_POST, 'POST');
		curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($dados));
		// INVOCA A URL DO WEBSERVICE
		$curl_resposta = curl_exec($curl);
		curl_close($curl);

		return $curl_resposta;
	}

	function PUT() {

		// DADO DE ENTRADA VAZIO - ERRO
		if($_POST['id_put'] == "" || $_POST['nome_put'] == "") {
			return json_encode( array('msg' => '[ERRO] Preencha o Campo de Entrada!') );
		}

		// MONTA ARRAY DE DADOS
		$dados = array('id' => $_POST['id_put'],
			'nome' => mb_strtoupper($_POST['nome_put'], 'UTF-8')
		);

		// INICIALIZA/CONFIGURA CURL
		$curl = curl_init("http://localhost/Slim/rest.php");
		// CONFIGURA AS OPÇÕES (parâmetros)
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'PUT');
		curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($dados));
		// INVOCA A URL DO WEBSERVICE
		$curl_resposta = curl_exec($curl);
		curl_close($curl);

		return $curl_resposta;

	}

	function DELETE() {

		// DADO DE ENTRADA VAZIO - ERRO
		if($_POST['id_delete'] == "") {
			return json_encode( array('msg' => '[ERRO] Preencha o Campo de Entrada!') );
		}

		// MONTA ARRAY DE DADOS
		$dados = array('id' => $_POST['id_delete']);

		// INICIALIZA/CONFIGURA CURL
		$curl = curl_init("http://localhost/Slim/rest.php");
		// CONFIGURA AS OPÇÕES (parâmetros)
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'DELETE');
		curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($dados));
		// INVOCA A URL DO WEBSERVICE
		$curl_resposta = curl_exec($curl);
		curl_close($curl);

		return $curl_resposta;
	}
?>
