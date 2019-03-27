<?php 

class PageModel extends Model {
	private $id;
	private $title;
	private $content;
	private $slug;
	private $sidebar;
	private $priority;
	private $conn;

	function __construct($id=null,$title,$content,$slug,$sidebar,$priority) {
		global $conn;
		$this->conn = $conn;
		$this->id = $id;
		$this->title;
		$this->content;
		$this->slug;
		$this->sidebar;
		$this->priority;
	}

	public function getId() {
		return $this->id;
	}

	public function setId($newId) {
		$this->id = $newId;
	}

	public function getTitle() {
		return $this->title;
	}

	public function setTitle($newTitle) {
		return $this->newTitle;
	}

	public function getContent() {
		return $this->content;
	}

	public function setContent($newContent) {
		$this->content = $newContent; 
	}

	public function getSlug() {
		return $this->slug;
	}

	public function setSlug($newSlug) {
		$this->setSlug = $newSlug
	}

	public function getSidebar() {
		return $this->sidebar;
	}

	public function setSidebar($newSidebar) {
		$this->sidebar = $newSidebar;
	}

	public function getPriority() {
		return $this->priority;
	}

	public function setPriority($newPriority) {
		$this->priority = $newPriority;
	}

	public function getAll() {

	}

	public function save() {


	public function delete() {

	}
}


	