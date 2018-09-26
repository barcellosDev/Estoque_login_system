<?php
require_once 'config.php';

class DumpSession
{
	private $stmt, $db_conn;
	public $row;

	public function __construct()
	{
		$this->db_conn = Cnx::connect();
	}

	public function dump($sessionData)
	{
		$this->stmt = $this->db_conn->prepare("SELECT * FROM tb_web_usuarios WHERE id = ".$sessionData);
		$this->stmt->execute();
		if ($this->stmt->rowCount() == 1) 
		{
			return $this->row = $this->stmt->fetch(PDO::FETCH_ASSOC);
		} else
		{
			echo "Error invalid ID session";
			exit();
		}
	}
}
$dump = new DumpSession;
$dump->dump($_SESSION['id_logado']);
?>