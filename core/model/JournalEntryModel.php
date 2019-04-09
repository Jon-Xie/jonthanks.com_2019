<?php 

class JournalEntryModel extends Model {
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

	}

	public function getById($id) {

	}
	
	public function save() {

	}

	public function delete() {

	}


id
title
excerpt
body
thumbnail
image
date

