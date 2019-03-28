<?php 
	class Model {
		private $id;

		public function __construct($id = null){
			$this->id = $id;
		}

		public function getId() {
			return $this->id;
		}

		public function setId($newId) {
			$this->id = $newId;
		}
	}
?>