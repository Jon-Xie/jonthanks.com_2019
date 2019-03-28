<?php
class GalleryItemModel extends Model {
	private $tableName = 'gallery';
	private $name;
	private $thumb;
	private $original;
	private $catagoryId;
	private $favorite;
	private $conn;

	function __construct($id = null,$name = null,$thumb = null,$original = null,$catagoryId = null,$favorite = null) {
		parent::__construct($id);
		global $conn;
		$this->conn = $conn;
		$this->name = $name;
		$this->thumb = $thumb;
		$this->original = $original;
		$this->catagoryId = $catagoryId;
		$this->favorite = $favorite;
	}

	public function getName() {
		return $this->name;
	}

	public function setName($newName) {
		$this->name = $newName;
	}

	public function getThumb() {
		return $this->thumb; 
	}

	public function setThumb($newThumb) {
		$this->thumb = $newThumb;
	}

	public function getOriginal() {
		return $this->original;
	}

	public function setOriginal($newOriginal) {
		$this->original = $newOriginal;
	}

	public function getCatagoryId() {
		return $this->catagoryId;
	}

	public function setCatagoryId($newCatagoryId) {
		$this->catagoryId = $newCatagoryId
	}

	public function getFavorite() {
		return $this->favorite;
	}

	public function setFavorite($newFavorite) {
		$this->favorite = $newFavorite;
	}

	public static function getAll() {
		$output = array();
		$sql = "SELECT * FROM `".$this->tableName."`";
		$result = mysqli_query($this->conn, $sql); //Result set
		if(mysqli_num_rows($result) > 0){ 
			while($row = mysqli_fetch_object($result)){
				$GalleryItemModel = new GalleryItemModel($row->id, $row->name, $row->thumb, $row->original, $row->categoryId, $row->favorite);
				$output[] = $GalleryItemModel; //Append to the output array
			}
		}
		return $output;
	}

	public static function getById($id){
		$output = false;
		$sql = "SELECT * FROM `".$this->tableName."` WHERE `id` = $id";
		$result = mysqli_query($this->conn, $sql);
		if(mysqli_num_rows($result) > 0) {
			$row = mysqli_fetch_object($result);
			$GalleryItemModel = new GalleryItemModel($row->id, $row->name, $row->thumb, $row->original, $row->categoryId, $row->favorite);
			$output = $GalleryItemModel;
		}
		return $output;
	}

	public function save() {
		if(parent::getId() == null){
			$sql = "INSERT INTO `".$this->tableName."` (`id`,`name`,`thumb`,`original`,`categoryId`,`favorite`) VALUES (".parent::getId().",'".$this->name."','".$this->thumb."','".$this->original."',".$this->categoryId.",".$this->favorite.")";
			mysqli_query($this->conn,$sql);
		}else{
			$sql = "UPDATE `".$this->tableName."` SET `id`= ".parent::getId().", `name`='".$this->name."',`thumb`= '".$this->thumb."', `original` = '".$this->original."', `categoryId`= ".$this->categoryId.",`favorite` = ".$this->favorite. " WHERE `id` = ".parent::getId();
			mysqli_query($this->conn,$sql);
		}
	}

	public function delete() {
		$sql = "DELETE FROM `".$this->tableName."` WHERE `id`= ".parent::getId();
		mysqli_query($this->conn,$sql);
	}
}
?>