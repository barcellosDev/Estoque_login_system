<?php
class Edit
{
  public static $static_row, $static_db_conn, $static_stmt;

  public static function editar($campo)
  {
    if (isset($_GET['id']) and $_GET['acao'] == 'editar')
    {
      self::$static_db_conn = Cnx::connect();

      self::$static_stmt = self::$static_db_conn->prepare("SELECT ".$campo." FROM tb_web_estoque WHERE id = ".$_GET['id']);
      self::$static_stmt->execute();

      if (self::$static_stmt->rowCount() > 0)
      {
        switch (self::$static_row = self::$static_stmt->fetch(PDO::FETCH_ASSOC))
        {
          case $campo == 'titulo':
            return self::$static_row['titulo'];
            break;

          case $campo == 'preco':
            return self::$static_row['preco'];
            break;

          case $campo == 'descricao':
            return self::$static_row['descricao'];
            break;

          case $campo == 'img_dir':
            return self::$static_row['img_dir'];
            break;
        }
      } else
      {
        echo "Campo não encontrado!";
        exit();
      }
    }
  }
}
?>
