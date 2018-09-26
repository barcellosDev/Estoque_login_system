<?php
session_start();
const br = "<br>";
date_default_timezone_set('America/Sao_Paulo');
error_reporting(E_ALL);

abstract class Cnx
{
	public static $conn;

	public static function connect()
	{
		self::$conn = new PDO("mysql:host=localhost;dbname=website", "root", "");
		if (self::$conn == true) 
		{
			return self::$conn;
		} else
		{
			echo "Conexão recusada!";
		}
	}
}
?>