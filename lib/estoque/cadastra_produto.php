<?php
class Cad_produto
{
	private $stmt, $db_conn, $row, $img_dir, $file_array, $errors, $name, $allowed_ext, $extensions, $sql_code;
	private $params = array();

	public function __construct()
	{
		$this->db_conn = Cnx::connect();
		$this->db_conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}

	private function pre_r($array)
	{
		echo "<pre>";
		print_r($array);
		echo "</pre>";
	}

	public function Reg_product($dir)
	{
		if (isset($_FILES['arquivo']))
		{
			$this->reArray($_FILES['arquivo']);
			$this->error_files();
			//$this->pre_r($this->file_array);

			for ($i=0; $i < count($this->file_array); $i++)
			{
				if (isset($this->file_array[$i]['error']))
				{
					//echo $this->errors[$this->file_array[$i]['error']];
					if ($this->errors[$this->file_array[$i]['error']] == 0)
					{
						echo br;

						$this->extensions = array('jpg', 'png', 'jpeg', 'gif', 'bmp', 'JPG', 'PNG', 'JPEG', 'BMP', 'GIF');
						$this->allowed_ext = explode('.', $this->file_array[$i]['name']);
						//$this->pre_r($this->allowed_ext);  = Funcionando...
						$this->allowed_ext = end($this->allowed_ext);

						if (!in_array($this->allowed_ext, $this->extensions))
						{
							echo 'O arquivo '."<strong>(".$this->file_array[$i]['name'].")</strong>".' tem extensão inválida!';
						} else
						{
							$this->name = str_replace(' ', '-', $this->file_array[$i]['name']);
							$this->name = strtoupper($this->name);

							$this->img_dir = $dir.$this->name;
							//////////////////////SQL INSERT//////////////////////

							if (!empty($_POST['titulo']) and !empty($_POST['descricao']) and !empty($_POST['preco']))
							{
								if (isset($_GET['id']) and $_GET['acao'] == 'editar')
								{
									$this->capturaForm();

									$this->sql_code = "UPDATE tb_web_estoque SET titulo = ?, descricao = ?, preco = ?, img_dir = ? WHERE id = ".$_GET['id'];
									$this->sqlQuery($this->sql_code, $this->params);

									if ($this->stmt == true)
									{
										echo "<strong>Alterado com sucesso!</strong>";
									} else
									{
										echo "<strong>Ocorreu um erro!</strong>";
									}
								} else
								{
									$this->capturaForm();
									$this->sql_code = "INSERT INTO
														tb_web_estoque (titulo, descricao, preco, img_dir)
														VALUES (?, ?, ?, ?)";

									//echo $this->sql_code;
									//exit();

									$this->sqlQuery($this->sql_code, $this->params);

									if ($this->stmt == true)
									{
										move_uploaded_file($this->file_array[$i]['tmp_name'], $this->img_dir);

										if (count($this->file_array[$i]) > 1)
										{
											echo "Não houve erros, o upload dos arquivos foram bem sucedidos";
										} elseif (count($this->file_array[$i]) == 1)
										{
											echo $this->errors[0];
										}

										//echo "<script>alert('Produto cadastrado com sucesso !')</script>";
										//echo "<script>window.location.href = 'index.php'</script>";
									} else
									{
										echo "<script>alert('Ocorreu algo de errado com o produto ao ser cadastrado :( ')</script>";
									}
								}
							} else
							{
								echo "<script>alert('Preencha os campos!')</script>";
							}

							///////////////////////////////////////////////////////
						}

					} elseif ($this->errors[$this->file_array[$i]['error']] !== 0)
					{
						for ($i=1; $i <= array_keys($this->errors); $i++)
						{
							echo $this->errors[$i];
						}
					}
				}
			}
		}
	}

	private function capturaForm()
	{
		$this->params = array(
			$_POST['titulo'] = ucwords($_POST['titulo']),
			$_POST['descricao'],
			$_POST['preco'] = floatval($_POST['preco']),
			$this->img_dir
		);
	}

	private function sqlQuery($sql, $parametros)
	{
		$this->stmt = $this->db_conn->prepare($sql);
		$this->stmt->execute($parametros);
	}

	private function reArray($file_ary)
	{
		$this->file_array = array();
		$array_count = count($file_ary['name']);
		$array_keys = array_keys($file_ary);

		for ($i=0; $i < $array_count; $i++)
		{
			foreach ($array_keys as $key)
			{
				$this->file_array[$i][$key] = $file_ary[$key][$i];
			}
		}
		return $this->file_array;
	}

	private function error_files()
    {
         $this->errors = array(
         		0 => 'Não houve erro, o upload foi bem sucedido',
            1 => 'O arquivo enviado excede o limite definido na diretiva upload_max_filesize do php.ini',
            2 => 'O arquivo excede o limite definido em MAX_FILE_SIZE no formulário HTML',
            3 => 'O upload do arquivo foi feito parcialmente',
            4 => 'Nenhum arquivo foi enviado',
            6 => ' Pasta temporária ausênte',
            7 => 'Falha em escrever o arquivo em disco',
            8 => 'Uma extensão do PHP interrompeu o upload do arquivo. O PHP não fornece uma maneira de determinar qual extensão causou a interrupção'
        );
    }
}
$reg_estoque = new Cad_produto;
$reg_estoque->Reg_product('imgs/');
?>
