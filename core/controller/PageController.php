<?php 
	class PageController extends Controller {
		private $PageModel;

		public function __construct(){
			$this->PageModel = new PageModel();
		}
		
		
	}