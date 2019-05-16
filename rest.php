<?php

	require 'Slim/Slim.php';
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

	// PUT - Alterar
	$app->put('/', function() use ($app) {

		$dadoJson = json_decode( $app->request()->getBody() );

		$sql = "UPDATE tb_usuario_slim SET nome=:nome, usuario=:usuario, senha=:senha,  WHERE id=:id";
		$conn = getConn();
		$stmt = $conn->prepare($sql);
		$stmt->bindParam("nome", $dadoJson->nome);
		$stmt->bindParam("usuario", $dadoJson->usuario);
		$stmt->bindParam("senha", $dadoJson->senha);
		$stmt->bindParam("id", $dadoJson->id);

		if($stmt->execute()) {
			echo json_encode( array('msg' => "[OK] Produto ($dadoJson->id) Alterado com Sucesso!") );
		}
		else {
			echo json_encode( array('msg' => "[ERRO] Não foi possível Alterar o Produto ($dadoJson->id)!") );
		}
	});

	// DELETE - Remover
	$app->delete('/', function() use ($app) {

		$dadoJson = json_decode( $app->request()->getBody() );

		$sql = "DELETE FROM tb_usuario_slim WHERE id=:id";
		$conn = getConn();
		$stmt = $conn->prepare($sql);
		$stmt->bindParam("id", $dadoJson->id);

		if($stmt->execute()) {
			echo json_encode( array('msg' => "[OK] Produto ($dadoJson->id) Removido com Sucesso!") );
		}
		else {
			echo json_encode( array('msg' => "[ERRO] Não foi possível Remover o Produto ($dadoJson->id)!") );
		}
	});

	$app->run();
?>
