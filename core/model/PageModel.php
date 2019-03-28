<?php 

class PageModel extends Model {
	private $tablename = 'pages';
	private $title;
	private $content;
	private $slug;
	private $sidebar;
	private $priority;
	private $conn;

	function __construct($id=null,$title,$content,$slug,$sidebar,$priority) {
		global $conn;
		$this->conn = $conn;
		parent::__construct($id);
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

	public static function getAll() {
		$output = array();
		$sql = "SELECT * FROM `".$this->tablename."`";
		$result = mysqli_query($this->conn,$sql);
		if(mysqli_num_rows($result) > 0) {
			$row = mysqli_fetch_object($result) 
			$object = new PageModel($row->id, $row->title, $row->content, $row->slug, $row->sidebar, $row->priority);
			$output[] = $object; 
		}
		return $output;
	}

	public function save() {
		if(parent::getId() == null) {
			$sql = "INSERT INTO `".$this->tablename."` (`id`,`title`,`content`,`slug`,	`sidebar`,`priority`) VALUES (".$this->id.",'".$this->title."','".$this->content."','".$this->slug."','".$this->sidebar."',".$this->priority.")";
			$result = mysqli_query($this->conn, $sql);
		}
		else {
			$sql = "UPDATE `".$this->tablename."` SET `id`=".parent::getId().",`title` = '".$this->title."' , `content` = '".$this->content."', `slug` = '".$this->slug."' , `sidebar` = '".$this->sidebar."', `priority` = ".$this->priority." WHERE `id` = ".parent->getId().;
			$result = mysqli_query($this->conn, $sql);
		}
	}

	public function delete() {
		$sql =  "DELETE FROM `".$this->tablename."` WHERE `id` = `".$this->id."`"
	}
}


	