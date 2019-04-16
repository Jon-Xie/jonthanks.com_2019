<?php
class GallerySectionModel extends Model {
	private $tableName = 'gallerysections';
	private $title;
	private $conn;

	function __construct($id = null,$title = null) {
		parent::__construct($id);
		global $conn;
		$this->conn = $conn;
		$this->title = $title;
	}

	public function getTitle() {
		return $this->title;
	}

	public function setTitle($newTitle) {
		$this->title = $newTitle;
	}

	public static function getAll() {
		$output = array();
		$sql = "SELECT * FROM `".$this->tableName."`";
		$result = mysqli_query($this->conn, $sql); //Result set
		if(mysqli_num_rows($result) > 0){ 
			while($row = mysqli_fetch_object($result)){
				$GallerySectionModel = new GallerySectionModel($row->id, $row->title);
				$output[] = $GallerySectionModel; //Append to the output array
			}
		}
		return $output;
	}

	public static function getAllAsArray(){

	}

	public static function getById($id){
		$output = false;
		$sql = "SELECT * FROM `".$this->tableName."` WHERE `id` = $id";
		$result = mysqli_query($this->conn, $sql);
		if(mysqli_num_rows($result) > 0) {
			$row = mysqli_fetch_object($result);
			$GallerySectionModel = new GallerySectionModel($row->id, $row->title);
			$output = $GallerySectionModel;
		}
		return $output;
	}

	public static function getByIdAsArray(){
		
	}



	public function save() {
		if(parent::getId() == null){
			$sql = "INSERT INTO `".$this->tableName."` (`title`) VALUES ('".$this->title.")";
			mysqli_query($this->conn,$sql);
		}else{
			$sql = "UPDATE `".$this->tableName."` SET `id`= ".parent::getId().", `name`='".$this->title." WHERE `id` = ".parent::getId();
			mysqli_query($this->conn,$sql);
		}
	}

	public function delete() {
		$sql = "DELETE FROM `".$this->tableName."` WHERE `id`= ".parent::getId();
		mysqli_query($this->conn,$sql);
	}
}
?>