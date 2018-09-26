<?php
class Display
{
	private $stmt, $db_conn, $rows;

	public function __construct()
	{
		$this->db_conn = Cnx::connect();
	}

	public static function verifyAdmin($id_admin)
	{
		if ($id_admin == 1)
		{
			return true;
		} else
		{
			return false;
		}
	}

	public function show()
	{
		$this->sqlQuery("SELECT * FROM tb_web_estoque");

		if ($this->stmt->rowCount() > 0)
		{
			while ($this->rows = $this->stmt->fetch(PDO::FETCH_ASSOC))
			{
				if (self::verifyAdmin($_SESSION['id_logado']) == true)
				{
					echo ("
						<tr>
							<td><a href=../lib/estoque/delete.php?id=".$this->rows['id'].">Excluir</a> - <a href=registra.php?id=".$this->rows['id']."&acao=editar>Editar</a> - ".$this->rows['titulo']."</td>
							<td>".$this->rows['descricao']."</td>
							<td><img src=".$this->rows['img_dir']." width=150px></td>
							<td>R$".$this->rows['preco']."</td>
							<td>".$this->rows['data']."</td>
						</tr>
						");
				} else
				{
					echo ("
						<tr>
							<td>".$this->rows['titulo']."</td>
							<td>".$this->rows['descricao']."</td>
							<td><img src=".$this->rows['img_dir']." width=150px></td>
							<td>R$".$this->rows['preco']."</td>
							<td>".$this->rows['data']."</td>
						</tr>
						");
				}

			}
		} else
		{
			echo "<strong>Não há produtos cadastrados. Por favor, <a href=registra.php>cadastre</a></strong>";
		}
	}

	private function sqlQuery($sql)
	{
		$this->stmt = $this->db_conn->prepare($sql);
		$this->stmt->execute();
	}
}
$display = new Display();
$display->show();
?>
