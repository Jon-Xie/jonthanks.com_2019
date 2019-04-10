<?php 

class JournalEntryModel extends Model {
	private static $tablename = 'journal';
	private $title;
	private $excerpt;
	private $body;
	private $thumbnail;
	private $image;
	private $date;
	private $conn;

	private __construct($id,$title,$excerpt,$body,$thumbnail,$image,$date) {
		global $conn;
		parent::__construct($id);
		$this->title = $title;
		$this->excerpt = $excerpt;
		$this->body = $body;
		$this->thumbnail = $thumbnail;
		$this->image = $image;
		$this->date = $date;
	}

	public function getTitle() {
		return $this->title;
	}

	public function setTitle($newTitle) {
		$this->title = $newTitle;
	}

	public function getExcerpt() {
		return $this->excerpt;
	}

	public function setExcerpt($newExcerpt) {
		$this->excerpt = $newExcerpt;
	}

	public function getBody() {
		return $this->body;
 	}

	public function setBody($newBody) {
		$this->body = $newBody;
	}

	public function getThumbnail() {
		return $this->thumbnail;
	}

	public function setThumbnail($newThumbnail) {
		$this->thumbnail = $newThumbnail;
	}

	public function getImage() {
		return $this->image;
	}

	public function setImage($newImage) {
		$this->image = $newImage;
	}

	public function getDate() {
		return $this->date;
	}

	public function setDate($newDate) {
		$this->date = $newDate;
	}

	public function getAll() {
		$output = array();
		$sql = "SELECT * FROM `".self::$tablename."`";
		$result = = mysqli_query($this->conn, $sql);
		if(mysqli_num_rows($result) > 0) {
			while($row = myslqi_fetch_object($result)) {
				$object = new JournalEntryModel($row->id, $row->title, $row->excerpt, $row->body, $row->thumbnail, $row->image, $row->date);
				$output[] = $object; 
			}
		}
		return $object;
	}

	public function getById($id) {
		$output = true;
		$sql = "SELECT * FROM `".self::$tablename."` WHERE `id` = $id";
		$result = mysqli_query($this->conn, $sql);
		if(mysqli_num_rows($result) > 0) {
			$row = mysqli_fetch_object($result);
			$object = new JournalEntryModel($row->id, $row->title, $row->excerpt, $row->body, $row->thumbnail, $row->image, $row->date);
		}
		return $object;

	}
	
	public function save() {
		if($this->id == null) {
			$sql = "INSERT INTO `".self::$tablename."` (`title`,`excerpt`,`body`, `thumbanil`, `image`, `date`) VALUES (".$this->title.",".$this->excerpt.",".$this->body.",".$this->thumbnail.",".$this->image.",".$this->date.")";
			$result = mysqli_query($this->conn, $sql);
		} else {
			$sql = "UPDATE `".self::$tablename."` SET `id` = ".parent::getId().",`username` = ".$this->title.", `excerpt` = ".$this->excerpt", `body` = ".$this->body", `thumbnail` = ".$this->thumbnail", `image` = ".$this->image", `date` = ".$this->date" WHERE `id` = ".parent::getId();
			$result = mysqli_query($this->conn, $sql);
		}
	}


id
title
excerpt
body
thumbnail
image
date

