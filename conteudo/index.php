<?php
require_once '../lib/config.php';
include '../lib/protect.php';
require '../lib/dump_user.php';
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Produtos</title>
</head>
<body>
	<table border="1px" width="75%" align="center">
		<th>Título <?php if ($_SESSION['id_logado'] == 1) echo ("- <a href=../lib/estoque/delete.php?acao=truncate>Excluir tudo</a>"); ?></th>
		<th>Descrição</th>
		<th>Foto</th>
		<th>Preço</th>
		<th>Data</th>

		<?php
		require '../lib/estoque/visualiza_produto.php';
		?>
</table>
<br>
</body>
</html>
<?php
if ($dump->row['admin'] == 1)
{
	echo ("
		<a href=../lib/logout.php>Logout</a>
		<strong>|</strong>
		<a href=registra.php>Cadastrar</a>
		");
} else
{
	echo ("
		<a href=../lib/logout.php>Logout</a>
		");
}
?>
