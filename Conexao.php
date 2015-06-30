	<?php

	class Conexao{
		
		public $query;
		public $link;
		public $result;
		public $params;
		
		function __construct() {
			$this->connect();
		}
		
		function connect(){ //MÃ©todo para abrir e testar a conexÃ£o.		
			$host = "awsdb.cgf5dvcarylv.us-west-1.rds.amazonaws.com:3306";
			$user = "andrefpc";
			$pass = "andrefpc92";
			$db = "PlacesDB";
			
			//$connectionInfo = array("UID"=>$this->user, "PWD"=>$this->pass,"Database"=>$this->db, "CharacterSet"  => 'UTF-8');
						//$connectionInfo = array("UID"=>$this->user, "PWD"=>$this->pass,"Database"=>$this->db, "CharacterSet"  => 'UTF-8');
			$link = mysql_connect($host, $user, $pass) or die('Não foi possível selecionar o banco de dados');;
			$this->link = $link;
			mysql_select_db($db,$link) or die('Não foi possível selecionar o banco de dados');
			mysql_set_charset('utf8', $link);
			if (!$link) {
    			die('Não foi possível conectar: ' . mysql_error());
			}
		}
		
		function execute($query){ //MÃ©todo para executar uma query.
			$this->query = $query;
			$this->result = mysql_query($this->query, $this->link);
			
			mysql_query("SET NAMES 'utf8'");
			mysql_query('SET character_set_connection=utf8');
			mysql_query('SET character_set_client=utf8');
			mysql_query('SET character_set_results=utf8');
			
			if($this->result == false ){
				/* echo "Consulta Falhou.</br>";
				die( print_r( mysql_errors(), true)); */
				return false;
			}else{
				return $this->result;
			}
		}	
		
		function returnInsertedId(){ //Metodo retornar id inserido
			return mysql_insert_id($this->link);
		}

		function disconnect(){ //Metodo para desconectar do banco
			return mysql_close($this->link);
		}
		
		function typeColumns ($table) {
			$arrayType = null;
		
			$sql = "SELECT column_name, data_type FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = '$table';";
			$result = $this->execute($sql);
			while ($rs = mysql_fetch_array($result)) {
				$arrayType[$rs['column_name']] = $rs['data_type'];
			}
		
			return $arrayType;
		}

		function getLastId ($table) {
			$sql = "SELECT IDENT_CURRENT('".$table."') AS id";
			$result = $this->execute($sql);
			while ($rs = mysql_fetch_array($result)) {
				$id = $rs['id'];
			}
		
			return $id;
		}
				
		function insert($table, $data, $procedure){
			$fields = "";
			$values = "";
			$valores = "";
			$arrayTypeColumns = $this->typeColumns($table);
		
			foreach ($data as $key => $value) {
		
				if (!is_null($value)) {					
					$valores .= "@".$key . " = ";
		
					switch ($arrayTypeColumns[$key]) {
						case 'char':
							$valores .= "'" . $value . "', ";
							break;
						case 'datetime':
							$valores .= "'" . $value . "', ";
							break;
						case 'float':
							$valores .= $value . ", ";
							break;
						case 'int':
							$valores .= $value . ", ";
							break;
						case 'numeric':
							$valores .= $value . ", ";
							break;
						case 'smallint':
							$valores .= $value . ", ";
							break;
						case 'text':
							$valores .= "'" . $value . "', ";
							break;
						case 'varchar':
							$valores .= "'" . $value . "', ";
							break;
					}		
				}
			}
			
			$valores = substr($valores, 0, -2); // remove o Ãºltimo ", "
			
			$sql = "EXECUTE " . $procedure . " " . $valores . "";
			
// 			echo '</br>'.$sql.'</br>';
		
			$result = $this->execute($sql);
		
			if (!$result) {
				echo "Erro ao Inserir a consulta".$sql.".<br>";
			} else {
				$result = $this->getLastId($table); 
			}
		
			return $result;
		}
	}
?>