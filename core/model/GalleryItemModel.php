<?php
class GalleryItemModel extends Model {
	private static $tableName = 'gallery';
	private $name;
	private $thumb;
	private $original;
	private $categoryId;
	private $favorite;
	private $orderNumber;
	private $conn;

	function __construct($id = null,$name = null,$thumb = null,$original = null,$categoryId = null,$favorite = null, $orderNumber = 0) {
		parent::__construct($id);
		global $conn;
		$this->conn = $conn;
		$this->name = $name;
		$this->thumb = $thumb;
		$this->original = $original;
		$this->categoryId = $categoryId;
		$this->favorite = $favorite;
		$this->orderNumber = $orderNumber;
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

	public function getCategoryId() {
		return $this->categoryId;
	}

	public function setCategoryId($newCategoryId) {
		$this->categoryId = $newCategoryId;
	}

	public function getFavorite() {
		return $this->favorite;
	}

	public function setFavorite($newFavorite) {
		$this->favorite = $newFavorite;
	}

	public function getOrderNumber() {
		return $this->orderNumber;
	}

	public function setOrderNumber($newOrderNumber) {
		$this->orderNumber = $newOrderNumber;
	}


	public static function getAll($args = array()) {
		global $conn;
		$output = array();
		$sql = "SELECT * FROM `".self::$tableName."`";
		if(!empty($args['keywords'])){
			$sql .= " WHERE `original` LIKE '%".$args['keywords']."%'";
		}
		if(!empty($args['orderBy'])){
			$sql .= " ORDER BY `".$args['orderBy']."`";
		}
		if(!empty($args['orderDirection'])){
			$sql .= " ".$args['orderDirection'];
		}
		$result = mysqli_query($conn, $sql); //Result set
		if(mysqli_num_rows($result) > 0){ 
			while($row = mysqli_fetch_object($result)){
				$GalleryItemModel = new GalleryItemModel($row->id, $row->name, $row->thumb, $row->original, $row->categoryId, $row->favorite, $row->orderNumber);
				$output[] = $GalleryItemModel; //Append to the output array
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
			while($row = mysqli_fetch_object($result)){
			$GalleryItemModel = new GalleryItemModel($row->id, $row->name, $row->thumb, $row->original, $row->categoryId, $row->favorite, $row->orderNumber);
			$output = $GalleryItemModel;
			}
		} 
		return $output;
	}



	public static function getByCategoryId($categoryId){
		global $conn;
		$output = false;
		$sql = "SELECT * FROM `".self::$tableName."` WHERE `categoryId` = $categoryId";
		$result = mysqli_query($conn, $sql);
		if(mysqli_num_rows($result) > 0) {
			$row = mysqli_fetch_object($result);
			$GalleryItemModel = new GalleryItemModel($row->id, $row->name, $row->thumb, $row->original, $row->categoryId, $row->favorite, $row->orderNumber);
			$output = $GalleryItemModel;
		} 
		return $output;
	}





	public function save() {
		if(parent::getId() == null){
			$sql = "INSERT INTO `".self::$tableName."` (`name`,`thumb`,`original`,`categoryId`,`favorite`,`orderNumber`) VALUES ('".$this->name."','".$this->thumb."','".$this->original."',".$this->categoryId.",".$this->favorite.",".$this->orderNumber.")";
			mysqli_query($this->conn,$sql);
		}else{
			if($this->thumb == null || $this->original == null){ //User is not updating the image file
				$sql = "UPDATE `".self::$tableName."` SET `id`= ".parent::getId().", `name`='".$this->name."', `categoryId`= ".$this->categoryId.",`favorite` = ".$this->favorite. ",`orderNumber` = ".$this->orderNumber. " WHERE `id` = ".parent::getId();		
			}else{	
				$sql = "UPDATE `".self::$tableName."` SET `id`= ".parent::getId().", `name`='".$this->name."',`thumb`= '".$this->thumb."', `original` = '".$this->original."', `categoryId`= ".$this->categoryId.",`favorite` = ".$this->favorite. ",`orderNumber` = ".$this->orderNumber. " WHERE `id` = ".parent::getId();
			}
			mysqli_query($this->conn,$sql);
		}
	}

	public function delete() {
		$sql = "DELETE FROM `".self::$tableName."` WHERE `id`= ".parent::getId();
		mysqli_query($this->conn,$sql);
	}

}
?>