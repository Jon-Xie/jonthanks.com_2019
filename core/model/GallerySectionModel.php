<?php
class GallerySectionModel extends Model {
	private static $tableName = 'gallerysections';
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
		global $conn;
		$output = array();
		$sql = "SELECT * FROM `".self::$tableName."`";
		$result = mysqli_query($conn, $sql); //Result set
		if(mysqli_num_rows($result) > 0){ 
			while($row = mysqli_fetch_object($result)){
				$GallerySectionModel = new GallerySectionModel($row->id, $row->title);
				$output[] = $GallerySectionModel; //Append to the output array
			}
		}
		return $output;
	}

	public static function getAllAsArray(){
		$output = array();
		$items = self::getAll();
		if(count($items) > 0) {
			foreach($items as $item) {
				$output[] = array(
					'id' => $item->getId(),
					'title' => $item->getTitle()
				);
			}
		}
		return $output;
	}

	public static function getById($id){
		global $conn;
		$output = false;
		$sql = "SELECT * FROM `".self::$tableName."` WHERE `id` = $id";
		$result = mysqli_query($conn, $sql);
		if(mysqli_num_rows($result) > 0) {
			$row = mysqli_fetch_object($result);
			$GallerySectionModel = new GallerySectionModel($row->id, $row->title);
			$output = $GallerySectionModel;
		}
		return $output;
	}

	public static function getByIdAsArray($id){
		$output = array();
		$item = self::getById($id);
		if(count($item) > 0) {
			$output = array(
				'id' => $item->getId(),
				'title' => $item->getTitle()
			);
		}
		return $output;
	}

	public function save() {
		if(parent::getId() == null){
			$sql = "INSERT INTO `".self::$tableName."` (`title`) VALUES ('".$this->title.")";
			mysqli_query($this->conn,$sql);
		}else{
			$sql = "UPDATE `".self::$tableName."` SET `id`= ".parent::getId().", `name`='".$this->title." WHERE `id` = ".parent::getId();
			mysqli_query($this->conn,$sql);
		}
	}

	public function delete() {
		$sql = "DELETE FROM `".self::$tableName."` WHERE `id`= ".parent::getId();
		mysqli_query($this->conn,$sql);
	}
}
?>