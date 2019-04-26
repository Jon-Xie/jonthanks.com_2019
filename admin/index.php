<?php
	require_once("../includes/config.php");
	$AdminController = new AdminController();
	$result = $AdminController->Authenticate();
?>


<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<title>JonThanks Admin Login</title>
</head>
<body class="backend">
	<div class="container">
		<div class="row">
			<div class="col">
				<?php 
					if($result !== null){
						echo('<div class="alert alert-danger mt-4">'.$result.'</div>');
					}
				?>
				<div class="card mt-4" style="width: 100%;">
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
