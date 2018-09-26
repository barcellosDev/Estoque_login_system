<?php
require_once '../config.php';

/**
 *
 */
class Delete
{
  private $stmt, $db_conn, $rows;

  public function __construct()
  {
    $this->db_conn = Cnx::connect();

    if (isset($_GET['id']))
    {
      $this->stmt = $this->db_conn->prepare("DELETE FROM tb_web_estoque WHERE id = ".$_GET['id']);
      $this->stmt->execute();

      if ($this->stmt == true)
      {
        header("Location: ../../conteudo/index.php");
      } else
      {
        echo "Ocorreu algo ao excluir o produto!";
        exit();
      }
    } elseif (isset($_GET['acao']) and $_GET['acao'] == 'truncate')
    {
      $this->stmt = $this->db_conn->prepare("TRUNCATE tb_web_estoque");
      $this->stmt->execute();

      if ($this->stmt == true)
      {
        header("Location: ../../conteudo/index.php");
      } else
      {
        echo "Ocorreu algo ao excluir o produto!";
        exit();
      }
    }
  }
}
$del = new Delete;
?>
