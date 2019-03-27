<?php
class GalleryItemModel extends Model {
	private $id;
	private $name;
	private $thumb;
	private $original;
	private $catagoryId;
	private $favorite;
	private $conn;

	function __construct($id = null,$name = null,$thumb = null,$original = null,$catagoryId = null,$favorite = null) {
		global $conn;
		$this->conn = $conn;
		$this->id = $id;
		$this->name = $name;
		$this->thumb = $thumb;
		$this->original = $original;
		$this->catagoryId = $catagoryId;
		$this->favorite = $favorite;
	}

	public function getId() {
		return $this->id;
	}

	public function setId($newId) {
		$this->id = $newId;
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
		$sql = "SELECT * FROM `gallery`";
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
		$sql = "SELECT * FROM `gallery` WHERE `id` = $id";
		$result = mysqli_query($this->conn, $sql);
		if(mysqli_num_rows($result) > 0) {
			$row = mysqli_fetch_object($result);
			$GalleryItemModel = new GalleryItemModel($row->id, $row->name, $row->thumb, $row->original, $row->categoryId, $row->favorite);
			$output = $GalleryItemModel;
		}
		return $output;
	}

	public function save() {
		if($this->id == null){
			$sql = "INSERT INTO `gallery` (`id`,`name`,`thumb`,`original`,`categoryId`,`favorite`) VALUES (".$this->id.",'".$this->name."','".$this->thumb."','".$this->original."',".$this->categoryId.",".$this->favorite.")";
			mysqli_query($this->conn,$sql);
		}else{
			$sql = "UPDATE `gallery` SET `id`= ".$this->id.", `name`='".$this->name."',`thumb`= '".$this->thumb."', `original` = '".$this->original."', `categoryId`= ".$this->categoryId.",`favorite` = ".$this->favorite. " WHERE `id` = ".$this->id;
			mysqli_query($this->conn,$sql);
		}
	}

	public function delete() {
		$sql = "DELETE FROM `gallery` WHERE `id`= ".$this->id;
		mysqli_query($this->conn,$sql);
	}
}
?>