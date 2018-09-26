<?php
require_once 'config.php';

class Cadastra
{
	private $db_conn, $stmt, $row, $campos, $sql_code;
	private $params = array();

	public function __construct()
	{
		$this->db_conn = Cnx::connect();
	}

	private function capturaForm($array)
	{
		foreach ($array as $key => $value) 
		{
			$this->params[$value] = $_POST[$value];
		}
		$this->params['senha'] = sha1($this->params['senha']);
		$this->params = array_values($this->params);
	}

	private function sqlQuery($sql, $parametros)
	{
		$this->stmt = $this->db_conn->prepare($sql);
		$this->stmt->execute($parametros);
	}

	private function verifyUser($post)
	{
		$this->stmt = $this->db_conn->prepare("SELECT usuarios FROM tb_web_usuarios WHERE usuarios = '$post'");
		$this->stmt->execute();

		if ($this->stmt->rowCount() == 1) 
		{
			echo "<script>alert('Usuário já existe! Por favor escolha outro')</script>";
			exit();
		}
	}

	public function Result()
	{
		if (isset($_POST['cadastra'])) 
		{
			if (!empty($_POST['usuario']) and !empty($_POST['senha'])) 
			{
				$this->verifyUser($_POST['usuario']);

				if (isset($_POST['admin'])) 
				{
					$this->sql_code = "INSERT INTO tb_web_usuarios (usuarios, senha, admin) VALUES (?, ?, ?)";

					$this->capturaForm(array('usuario', 'senha', 'admin'));

					$this->sqlQuery($this->sql_code, $this->params);

					if ($this->stmt == true) 
					{
						echo "<script>alert('Cadastrado com sucesso!')</script>";
						echo "<script>window.location.href = 'index.php'</script>";
					} else
					{
						echo "<script>alert('Ocorreu algum erro! :( ')</script>";
					}
				} else
				{
					$this->sql_code = "INSERT INTO tb_web_usuarios (usuarios, senha, admin) VALUES (?, ?, 0)";
					$this->capturaForm(array('usuario', 'senha'));

					$this->sqlQuery($this->sql_code, $this->params);

					if ($this->stmt == true) 
					{
						echo "<script>alert('Cadastrado com sucesso!')</script>";
						echo "<script>window.location.href = 'index.php'</script>";
					} else
					{
						echo "<script>alert('Ocorreu algum erro! :( ')</script>";
					}
				}
			} else
			{
				echo "<script>alert('Preencha os campos!')</script>";
			}
		}
	}
}

$cad = new Cadastra;
$cad->Result();
?>