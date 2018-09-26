<?php
session_start();
unset($_SESSION['id_logado']);

header("Location: ../index.php ");
?>