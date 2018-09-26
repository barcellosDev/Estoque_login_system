<?php
if (!isset($_SESSION))
{
  session_start();
}
if (isset($_SESSION['id_logado']))
{
  header("Location: conteudo/index.php");
}
?>
