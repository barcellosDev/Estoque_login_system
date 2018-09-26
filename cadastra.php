<?php
include 'lib/redirect.php';
error_reporting(0);
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<link href="https://fonts.googleapis.com/css?family=Dosis" rel="stylesheet">
	<title>Cadastrar-se</title>
	<style>
		.align-center
		{
			text-align: center;
		}

		body
		{
			background-color: #f7ffbf;
			background-image: url(lib/sea.jpg);
			background-repeat: no-repeat;
			background-attachment: fixed;
			background-size: 100%;
			background-size: cover;
		}
		.dosis-font
		{
			font-family: 'Dosis', sans-serif;
		}
	</style>
</head>
<body>
<div class="align-center">
	<h1 class="dosis-font">Cadastrar-se</h1>
	<img src="lib/user.png" width="150">
	<form method="post">
		<input type="text" name="usuario" placeholder="Insira seu usuário"><br>
		<input type="password" name="senha" placeholder="Insira sua senha"><br>
		<input type="checkbox" name="admin" value="1">Admin<br>
		<input type="submit" name="cadastra" value="Cadastrar">
		<a href="index.php">Já cadastrado?</a>
	</form>
</div>
</body>
</html>
<?php
require 'lib/cad.php';
?>
