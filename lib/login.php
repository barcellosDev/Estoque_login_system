<?php
require_once 'config.php';

class Login
{
	private $stmt, $db_conn, $row, $sql_code;
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

	public function Result()
	{
		if (isset($_POST['logar'])) 
		{
			if (!empty($_POST['usuario']) and !empty($_POST['senha'])) 
			{
				$this->sql_code = "SELECT * FROM tb_web_usuarios WHERE usuarios = ? and senha = ?";
				$this->capturaForm(array('usuario', 'senha'));
				//print_r($this->params);
				//exit();

				$this->sqlQuery($this->sql_code, $this->params);

				if ($this->stmt->rowCount() == 1) 
				{
					$this->row = $this->stmt->fetch(PDO::FETCH_ASSOC);
					$_SESSION['id_logado'] = $this->row['id'];
					header("Location: conteudo/registra.php");
				} else
				{
					echo "<script>alert('Usuário não encontrado! Tente novamente')</script>";
				}
			} else 
			{
				echo "<script>alert('Preencha os campos!')</script>";
			}
		}
	}
}
$login = new Login;
$login->Result();
?>