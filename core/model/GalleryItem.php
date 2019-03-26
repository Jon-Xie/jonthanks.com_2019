<?php
class GalleryItem extends Model {
	private $id;
	private $name;
	private $thumb;
	private $original;
	private $catagoryId;
	private $favorite;

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

	public function save() {}






	// private $id;
	// private $name;
	// private $thumb;
	// private $original;
	// private $categoryId;
	// private $favorite;

	// public function getId(){
	// 	return $this->id;
	// }
	// public function setId($id){
	// 	$this->id = $id;
	// }
}
?>