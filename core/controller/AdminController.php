<?php
class AdminController extends Controller{
	private $AdminModel;

	public function __construct(){
		$this->AdminModel = new AdminModel();
	}

	public function Authenticate(){
		// check if post is not empty
		if(count($_POST) > 0) {
			$username = $_POST['username'];
			$password = $_POST['password'];
			$hashPwd = sha1($password);
			$result = $this->AdminModel->getUserByUsernameAndPassword($username, $hashPwd);
			if($output !== false) {
				
			}
		}
		// get fields from the post

		// call getUserByUsernameAndPassword in model and based on the result
		// open new login session and redirect
		// or return error message
	}
}