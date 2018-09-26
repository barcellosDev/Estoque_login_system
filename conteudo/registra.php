<?php
require_once '../lib/config.php';
include '../lib/protect.php';
require '../lib/dump_user.php';
include '../lib/estoque/edit.php';
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Estoque</title>
	<style>
		.align-center
		{
			text-align: center;
		}
	</style>
</head>
<body>
	<div class="align-center">
		<form method="post" enctype="multipart/form-data">
			<input type="text" name="titulo" value="<?php echo Edit::editar("titulo"); ?>" placeholder="Título"><br>
			<input type="number" name="preco" value="<?php echo Edit::editar("preco"); ?>"><br>
			<textarea name="descricao" maxlength="255"><?php echo Edit::editar("descricao"); ?></textarea><br>
			<input type="file" name="arquivo[]" multiple="">
			<input type="submit" name="envia">
		</form>
		<?php
			if ($dump->row['admin'] == 1)
			{
				require '../lib/estoque/cadastra_produto.php';
			} elseif ($dump->row['admin'] == 0)
			{
				header("Location: index.php");
			}
		?>
	</div>
	<br>
	<a href="../lib/logout.php">Logout</a>
	<strong>|</strong>
	<a href="index.php">Visualizar</a>
</body>
</html>
