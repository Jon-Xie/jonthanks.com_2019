<?php 
	require_once("../includes/config.php");
	$PageController = new PageController();
	AdminController::IsAuthorized();


	$action = '';
	if(!empty($_GET['act'])){ //$_GET pulls from query string
		$action = $_GET['act'];
	}

	if(!empty($_GET['id'])){
		$id = $_GET['id'];
	}

	if(count($_POST) > 0){
		$formName = $_POST['form-name'];
		$title = $_POST['title'];
		$content = $_POST['content'];
		$sidebar = $_POST['sidebar'];
		$slug = $_POST['slug'];
		$title = mysqli_real_escape_string($conn,$title);
		$content = mysqli_real_escape_string($conn,$content);
		$sidebar = mysqli_real_escape_string($conn,$sidebar);
		$slug = mysqli_real_escape_string($conn,$slug);
		if($formName == 'add'){
			$priority = (!empty($_POST['priority']))? $_POST['priority'] : 0;
			$sql = "INSERT INTO `pages` (`title`,`content`,`sidebar`,`slug`,`priority`)VALUES('$title','$content','$sidebar','$slug', $priority)";
			mysqli_query($conn, $sql);
			header('location: page.php');
			exit();
		}else if($formName == 'edit'){
			$priority = (!empty($_POST['priority']))? $_POST['priority'] : 0;
			$sql = "UPDATE `pages` SET `title` = '$title' , `content` = '$content', `sidebar`= '$sidebar' , `slug` ='$slug', `priority`=$priority WHERE `id` = $id"; // WHERE essential bc it will update all if u dont specify idate
			mysqli_query($conn, $sql);
			header('location: page.php');
			exit();
		}
	}
	if($action== 'delete' && !empty($_GET['confirm'])){ //
		$sql = "DELETE FROM `pages` WHERE `id`= $id";
		mysqli_query($conn, $sql); // sends, $sql just is a variable
		header('location: page.php');
		exit();
	}

?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

	<title>Page Management</title>
</head>
<body class="backend">
	<div class="container">
		<div class="row">
			<div class="col">
				<h1>Page</h1>
				<?php 
					if(empty($action)){
				?>
						<a href="dashboard.php" class="btn btn-danger">Back</a>
						<a href="page.php?act=add" class="btn btn-success">Add</a>
						<table class="table">
							<tr>
								<td>ID</td>
								<td>Title</td>
								<td>Slug</td>
								<td>Priority</td>
								<td>Edit</td>
								<td>Delete</td>
							</tr>
							<?php 
								$results = $PageController->PageModel->getAll();
								if(count($results) !== 0) {
									foreach($results as $result) {
										echo '<tr>';
										echo '<td>'.$result->getId().'</td>';
										echo '<td>'.$result->getTitle().'</td>';
										echo '<td>'.$result->getSlug().'</td>';
										echo '<td>'.$result->getPriority().'</td>';
										echo '<td><a href="page.php?act=edit&id='.$result->getId().'"class="btn btn-dark">Edit</a></td>';
										echo '<td><a href="page.php?act=delete&id='.$result->getId().'"class="btn btn-dark">Delete</a></td>';
										echo '</tr>';
									}
								} else {
									echo '<tr><td colspan="6">There are no pages in the database currently.</td></tr>';
								}
							?>
						</table>
				<?php 
					}else if($action=='add'){
				?>
					<h2>Add</h2>
					<a href="page.php" class="btn btn-danger">Back</a>
					<form method="POST">
						<input type="hidden" name="form-name" value="add">
						<label>Title</label><br>
						<input  class="form-control" type="text" name="title"><br>
						<label>Content</label><br>
						<textarea style="height: 700px" class="form-control tinymce" name="content"></textarea><br>
						<label>Sidebar</label><br>
						<textarea style="height: 300px" class="form-control tinymce" name="sidebar"></textarea><br>
						<label>Slug</label><br>
						<input  class="form-control" type="text" name="slug"><br>
						<label>Priority</label><br>
						<input  class="form-control" type="number" name="priority"><br>
						<input type="submit" name="submit" value="Add" class="btn btn-dark">
					</form>
				<?php 
					}else if($action=='edit') {
						$result = $PageController->PageModel->getById($id);
						if($result != false) {
				?>
							<h2>Edit</h2>
							<a href="page.php" class="btn btn-danger">Back</a>
							<form method="POST">
								<input type="hidden" name="form-name" value="edit">
								<label>Title</label><br>
								<input  class="form-control" type="text" name="title" value="<?php echo($result->getTitle()); ?>"><br>
								<label>Content</label><br>
								<textarea style="height: 700px" class="form-control tinymce" name="content"><?php echo($result->getContent()); ?> </textarea><br>
								<label>Sidebar</label><br>
								<textarea style="height: 300px" class="form-control tinymce" name="sidebar"><?php echo($result->getSidebar()); ?> </textarea><br>
								<label>Slug</label><br>
								<input  class="form-control" type="text" name="slug"  value="<?php echo($result->getSlug()); ?>"><br>
								<label>Priority</label><br>
								<input  class="form-control" type="number" name="priority"  value="<?php echo($result->getPriority()); ?>"><br>
								<input type="submit" name="submit" value="Update" class="btn btn-dark">
							</form>
				<?php
						} else {
							echo('<div class="alert alert-danger mt-4">There is no entry for the provided id.</div>');
						}
					}else if($action=='delete'){
						$result = $PageController->PageModel->getById($id);
						if($result !== false)
				?>
							<h2>Delete</h2>
							<div class="card mt-4">
								<h5 class="card-header">Are you sure you want to delete "<?php echo($thePage->title); ?>" ?</h5>
								<div class="card-body">
									<a href="page.php" class="btn btn-danger">No</a>&nbsp;&nbsp;
									<a href="page.php?act=delete&id=<?php echo($id); ?>&confirm=yes" class="btn btn-success">Yes</a>
								</div>
							</div>
				<?php 
					} else {
						echo('<div class="alert alert-danger mt-4">There is no entry for the provided id.</div>');
					}
				?>
			</div>
		</div>
	</div>
	

  	<script src="../js/tinymce/tinymce.min.js"></script>
	 <script>tinymce.init({ 
	  	selector:'.tinymce',
	  	valid_elements: '*[*]',
	  	forced_root_block : '',
	  	theme: 'modern',
		  plugins: 'print preview fullpage  searchreplace autolink directionality  fullscreen image link media template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists textcolor wordcount   imagetools    contextmenu colorpicker textpattern  code image',
		  toolbar1: 'formatselect | bold italic strikethrough forecolor backcolor | link | alignleft aligncenter alignright alignjustify  | numlist bullist outdent indent  | removeformat code image',
		relative_urls : false,
		remove_script_host : false,
	    document_base_url: 'http://jonthanks.com/',
	    // without images_upload_url set, Upload tab won't show up
	    images_upload_url: 'tinyUploader.php',
	    
	    // override default upload handler to simulate successful upload
	    images_upload_handler: function (blobInfo, success, failure) {
	        var xhr, formData;
	      
	        xhr = new XMLHttpRequest();
	        xhr.withCredentials = false;
	        xhr.open('POST', 'tinyUploader.php');
	      
	        xhr.onload = function() {
	            var json;
	        
	            if (xhr.status != 200) {
	                failure('HTTP Error: ' + xhr.status);
	                return;
	            }
	        
	            json = JSON.parse(xhr.responseText);
	        
	            if (!json || typeof json.location != 'string') {
	                failure('Invalid JSON: ' + xhr.responseText);
	                return;
	            }
	        
	            success(json.location);
	        };
	      
	        formData = new FormData();
	        console.log(xhr);
	        console.log(formData);
	        formData.append('file', blobInfo.blob(), blobInfo.filename());
	      
	        xhr.send(formData);
	    
	     }
	     });
	 </script>
</body>
</html>