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

	}

	public function getExcerpt() {
		
	}

	
id
title
excerpt
body
thumbnail
image
date

