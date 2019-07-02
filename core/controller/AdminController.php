<?php
class AdminController extends Controller{
	private $AdminModel;

	public function __construct(){
		$this->AdminModel = new AdminModel();
	}

	public function Authenticate(){
		$output = null;
		// check if post is not empty
		if(count($_POST) > 0) {
			$username = $_POST['username'];
			$password = $_POST['password'];
			$hashPwd = sha1($password);
			$result = $this->AdminModel->getUserByUsernameAndPassword($username, $hashPwd);
			if($result !== false) {
				$_SESSION['loggedIn'] = true;
				$_SESSION['userId'] = $result->getId();
				header('location: dashboard.php');
				exit();
			} else {
				$output = 'Failed to log in';
			}
		}
		return $output;
	}

	public static function IsAuthorized() {
		if(empty($_SESSION['loggedIn'])){
			header('location: index.php');
			exit();
		}
	}
}