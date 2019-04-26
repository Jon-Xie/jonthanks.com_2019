<?php
	require_once("../includes/config.php");
	$AdminController = new AdminController();
	$result = $AdminController->Authenticate();
	// if(count($_POST)> 0){
	// 	$username = $_POST['username'];
	// 	$password = $_POST['password'];
	// 	$hashedPassword = sha1($password); //Hash the plain password that we got from user using SHA1 and later compare it with the hash in database

	// 	$sql = "SELECT * FROM `admin` WHERE `username`= '$username' AND `password`= '$hashedPassword' "; 
	// 	$result = mysqli_query($conn, $sql);
	// 	$count = mysqli_num_rows($result);
	// 	if($count === 1) {
	// 		$_SESSION["loggedin"] = true;
	// 		header('location: dashboard.php'); //redirect to next page
	// 		exit();
	// 	} else {
	// 		echo("Error in login");
	// 	}
	// }

?>


<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<title></title>
</head>
<body class="backend">
	<div class="container">
		<div class="row">
			<div class="col">
				<div class="card mt-4" style="width: 30%;">
					<h5 class="card-header">Login</h5>
					<div class="card-body">
						<form method="POST">
							<div class="form-group">
								<label for="username">Username</label>
								<input type="text" class="form-control" name="username" >
							</div>
							<div class="form-group">
								<label for="password">Password</label>
								<input type="password" class="form-control" name="password" >
							</div>
							<input type="submit" class="btn btn-dark" name="login" value="Login">
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>
