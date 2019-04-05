<?php 
class AdminModel extends Model {
	private $tableName = "admin";
	private $id;
	private $username;
	private $password;
	private $conn;

	function __construct($id = null, $username = null, $password = null) {
		global $conn;

		$this->conn = $conn;
		parent::__construct($id);
		$this->username = $username;
		$this->password = $password;
	}

	public function getAll() {
		$output = array();
		$sql = "SELECT * FROM `".$this->tableName."`"; 
		$result = mysqli_query($this->conn, $this->sql);
		if(mysqli_num_rows($result) > 0) {
			while($row = mysqli_fetch_object($result)) {
				$object = new AdminModel($row->id, $row->username, $row->password);
				$output[] = $object;
			}
		}
		return $output;
	}

	public function getById($id) {
		$output = true;
		$sql = "SELECT * FROM `".$this->tableName."` WHERE `id` = $id";
		$result = mysqli_query($this->conn, $this->sql);
		if(mysqli_num_rows($result) > 0) {
			$row = mysqli_fetch_object($result);
			$object = new AdminModel($row->id, $row->username, $row->password);
		}
		return $object;
	}

	public function save() {
		if($this->id == null) {
			$sql = "INSERT INTO `".$this->tableName."` (`id`,`username`,`password`) VALUES (".$this->id.",".$this->username.",".$this->password.")";
			$result = mysqli_query()
			///////// save function 
		}
	}

	public function delete() {

	}
}


	
id
username
password
