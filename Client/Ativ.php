<?php

	include_once('rotinas.php');

	if( !empty($_POST['form_submit']) ) {

		if($_POST['botao'] == "get") {
			// GET
			$get = GET();
		}
		else if($_POST['botao'] == "post") {
			// POST
			$post = POST();
		}
		else if($_POST['botao'] == "put") {
			// PUT
			$put = PUT();
		}
		else if($_POST['botao'] == "delete") {
			// DELETE
			$delete = DELETE();
		}
    }
	else {
		$get = "";
		$post = "";
		$put = "";
		$delete = "";
	}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="img/umidae_icon.ico">

    <title>Framework Slim</title>

    <!-- Bootstrap core CSS -->
    <link href="bs/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="bs/themes/signin.css" rel="stylesheet">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

    <script type="text/javascript">
		function fMasc(objeto,mascara) {
			obj=objeto
			masc=mascara
			setTimeout("fMascEx()",1)
		}
		function fMascEx() {
			obj.value=masc(obj.value)
		}
		function mCPF(cpf){
			cpf=cpf.replace(/\D/g,"")
			cpf=cpf.replace(/(\d{3})(\d)/,"$1.$2")
			cpf=cpf.replace(/(\d{3})(\d)/,"$1.$2")
			cpf=cpf.replace(/(\d{3})(\d{1,2})$/,"$1-$2")
			return cpf
		}
	</script>

  </head>

  <body role="document">
    <!-- Fixed navbar -->
    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="index.php">Home</a>
          <a class="navbar-brand" href="Ativ.php">Atividade</a>
        </div>
	<div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>

    <div class="container theme-showcase" role="main">

		<form class="form" method="post" action="Ativ.php">
	    	<input TYPE="hidden" NAME="form_submit" VALUE="OK">

			<div class="page-header">
				<h1 class="form-signin-heading">
					<div id="m_texto">Cliente Web Service (Slim)</div>
				</h1>
			</div>

			<div class='row'>
				<!-- POST -->
				<div class='col-sm-3'>
					<!-- Nome -->
					<h2>Cadastrar Usuario</h2>
					<label>Nome</label>
					<input type="text" class="form-control" name="nome_post">
					<label>Usuario</label>
					<input type="text" class="form-control" name="usuario_post">
					<label>Senha</label>
					<input type="password" class="form-control" name="senha_post">
					<br>
					<button type="submit" name="botao" value="post" class="btn btn-success btn-block">
						<b>Cadastrar</b>
					</button>
					<br>
					<?php
						if($post != "") {
							echo "<div class='alert alert-success' role='alert'>";
								$dadoJson = json_decode($post);
								$msg = $dadoJson->{'msg'};
			   					echo "<strong>Retorno do Web Service!</strong><br>$msg";
			 				echo "</div>";
						}
					?>
					
				</div>


				<!-- GET -->
				<div class='col-sm-3'>
					<!-- Número de Registros -->
					<h2>Autenticar Usuario</h2>
					<label>Usuario</label>
					<input type="text" class="form-control" name="usuario_get" maxlength="20">
					<label>Senha</label>
					<input type="password" class="form-control" name="senha_get" maxlength="20">
					<br>
					<button type="submit" name="botao" value="get" class="btn btn-primary btn-block">
						<b>Confirmar / Autenticar</b>
					</button>
					<br>
					<?php
						if($get != "") {

							$dadoJson = json_decode($get);
							echo "<br>";
							echo "<div class='alert alert-success' role='alert'>";
								echo "<strong>Retorno do Web Service!</strong>";
								echo "<br>$dadoJson->msg";
			 				echo "</div>";
						}
					?>
					
				</div>

				<!-- Validar -->
				<div class='col-sm-3'>
					<!-- Número de Registros -->
					<h2>Validar CPF</h2>
					<label>CPF</label>
					<input type="text" class="form-control" name="cpf_put" minlength="14" maxlength="14" onkeydown="javascript: fMasc(this, mCPF);" placeholder="517.223.830-11">
					<br>
					<button type="submit" name="botao" value="put" class="btn btn-warning btn-block">
						<b>Validar</b>
					</button>
					<br>
					<?php
						if($put != "") {
							echo "<div class='alert alert-success' role='alert'>";

								$dadoJson = json_decode($put);
								$msg =  $dadoJson->{'msg'};

								echo "<strong>Retorno do Web Service!</strong>$msg";
			 				echo "</div>";
						}
					?> 
				</div>
				
			</div>
		</form>

		<div class="page-header">
			<b>&copy;2018&nbsp;&nbsp;&raquo;&nbsp;&nbsp; Gil Eduardo de Andrade</b>
		</div>
    </div> <!-- /container -->

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>
  </body>
</html>
