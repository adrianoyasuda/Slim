<?php

	require 'Slim/Slim.php';
	require 'Client/ValidaCPF.php';

	\Slim\Slim::registerAutoloader();


	$app = new \Slim\Slim();

	// CONEXÃO COM O BD
	function getConn() {

		return new PDO('mysql:host=infoprojetos.com.br;port=3132;dbname=tads17_yasuda', 'tads17_yasuda', '081012',
				array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
	}

	// TESTAR WEBSERVICE
	$app->get('/', function() {
		echo "<h1>Web Service: GET / POST / PUT / DELETE!</h1>";
	});

	// GET - Selecionar
	$app->get('/:dados', function($dados) {

		$dadoJson = json_decode($dados);

		$user = $dadoJson->usuario;
		$senha = $dadoJson->senha;

		$conn = getConn();
		$sql = "SELECT * FROM tb_usuario_slim WHERE usuario = :usuario AND senha = :senha LIMIT 1";
		$stmt = $conn->prepare($sql);
		$stmt->bindParam("usuario", $user);
		$stmt->bindParam("senha", $senha);
		$stmt->execute();

		$dadoJson = $stmt->fetchAll();

		if(empty($dadoJson)){
			echo json_encode(array('msg' => "[ERRO] Usuário ou Senha incorretos!"));
		}
		else {
			echo json_encode(array('msg' => "[OK] Usuário ($user) Logado!"));
		}

	});

	// POST - Inserir
	$app->post('/', function() use ($app) {

		$dadoJson = json_decode( $app->request()->getBody() );

		$sql = "INSERT INTO tb_usuario_slim (nome, usuario, senha) values(:nome, :usuario, :senha)";
		$conn = getConn();
		$stmt = $conn->prepare($sql);
		$stmt->bindParam("nome", $dadoJson->nome);
		$stmt->bindParam("usuario", $dadoJson->usuario);
		$stmt->bindParam("senha", $dadoJson->senha);
		$stmt->execute();
		$id = $conn->lastInsertId();

		echo json_encode( array('msg' => "[OK] Usuario ($id) Cadastro com Sucesso!") );
	});

	// PUT - Validar CPF
	$app->put('/', function() use ($app) {
		$dadoJson = json_decode( $app->request()->getBody() );
		if(validaCpf($dadoJson->cpf)) {
			echo json_encode( array('msg' => "[OK] ($dadoJson->cpf) CPF Válido!") );
		}
		else {
			echo json_encode( array('msg' => "[ERRO] ($dadoJson->cpf) CPF Inválido!") );
		}
	});

	$app->run();
?>
