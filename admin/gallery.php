<?php 
	require_once("../includes/config.php");
	// if(empty($_SESSION['loggedin'])){
	// 	header('location: index.php');
	// 	exit();
	// }
	$GalleryItemController = new GalleryItemController();
	$GalleryItemController->processForm();

	$action = '';
	if(!empty($_GET['act'])){ //$_GET pulls from query string
		$action = $_GET['act'];
	}

	if(!empty($_GET['id'])){
		$id = $_GET['id'];
	}

	//Update Sort
	if(!empty($_POST['isAjax'])){
		$action = $_POST['action'];
		$sortData = $_POST['sortData'];
		if(count($sortData)>0){
			foreach ($sortData as $item) {
				$image = GalleryItemModel::getById($item['id']);
				$image->setOrderNumber($item['orderNumber']);
				$image->save();
			}
		}
		exit();
	}
	

?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="../css/styles.css">
	<title></title>
</head>
<body class="backend">
	<div class="container">
		<div class="row">
			<div class="col">
				<h1>GALLERY</h1>
				<?php 
					if(empty($action)){
				?>		
						<a href="dashboard.php" class="btn btn-danger">Back</a>
						<a href="gallery.php?act=add" class="btn btn-dark">Add</a>
						<table class="table">
							<thead>
								<tr>
									<td>ID</td>
									<td>Thumbnail</td>
									<td>Name</td>
									<td>Category</td>
									<td>Favorite</td>
									<td>Edit</td>
									<td>Delete</td>
								</tr>
							</thead>
							<tbody  id="sortable" >
							<?php 
								$items = GalleryItemModel::getAll();
								if(count($items)>0){
									foreach ($items as $item) {
										$item = $item->getAsArray();
										echo '<tr class="draggable" id="row-'.$item['id'].'">';
										echo '<td>';
										echo '<input type="hidden" class="orderNumber" name="orderNumber[]" value="'.$item['orderNumber'].'">';
										echo '<input type="hidden" class="imageId" name="imageId[]" value="'.$item['id'].'">';
										echo $item['id'];
										echo '</td>';
										echo '<td><img class="gallery-admin-thumb" src="../images/gallery/thumbnails/'.$item['thumb'].'"></td>';
										echo '<td>'.$item['name'].'</td>';
										echo '<td>'.$item['category_name'].'</td>';
										echo '<td>'.(($item['favorite'])?'Yes':'No').'</td>';
										echo '<td><a href="gallery.php?act=edit&id='.$item['id'].'" class="btn btn-dark">Edit</a></td>';
										echo '<td><a href="gallery.php?act=delete&id='.$item['id'].'" class="btn btn-dark">Delete</a></td>';
										echo '</tr>';
									}
								}
							?>
							</tbody>
						</table>
				<?php 
					}else if($action=='add'){
				?>
					<h2>Add</h2>
					<form method="POST" enctype="multipart/form-data">
						<input type="hidden" name="form-name" value="add">
						<label>Name</label><br>
						<input  class="form-control" type="text" name="name"><br>
						<label>Image</label><br>
						<input type="file" name="image"><br>
						<label>Category</label><br>
						<select name="categoryId" class="form-control">
							<?php 
								$sql="SELECT * FROM `gallerysections`";
								$res=mysqli_query($conn, $sql);
								while($row = mysqli_fetch_object($res)) {
									echo('<option value="'.$row->id.'">'.$row->title.'</option>');
								}
							?>
						</select><br>
						<label>Favorite</label><br>
						<select name="favorite" class="form-control">
							<option value="0">No</option>
							<option value="1">Yes</option>
						</select><br>
						<input type="submit" name="submit" value="Add" class="btn btn-dark">

					</form>
				<?php 
					}else if($action=='edit'){
						$theImage = GalleryItemModel::getById($id);
				?>
					<h2>Edit</h2>
					<form method="POST" enctype="multipart/form-data">
						<input type="hidden" name="form-name" value="edit">
						<label>Name</label><br>
						<input  class="form-control" type="text" name="name" value="<?=$theImage['name'] ?>"><br>
						<label>Image</label>
						<input type="file" name="image"> <img class="image-preview" src="../images/gallery/<?php echo($theImage['original']); ?>" width="100">
						<br>
						<!-- Crop End -->
						<label>Category</label><br>
						<select name="categoryId" class="form-control">
							<?php 
								$sql="SELECT * FROM `gallerysections`";
								$res=mysqli_query($conn, $sql);
								while($row = mysqli_fetch_object($res)) {
									if($row->id === $theImage['categoryId'] ){
										$selected = "selected";
									}else{
										$selected = "";
									}
									echo('<option value="'.$row->id.'" '.$selected.'>'.$row->title.'</option>');
								}
							?>
						</select><br>
						<label>Favorite</label><br>
						<select name="favorite" class="form-control">
							<option value="0" <?=($theImage['favorite'] === "0")? 'selected':'' ?>>No</option>
							<option value="1" <?=($theImage['favorite'] === "1")? 'selected':'' ?>>Yes</option>
						</select><br>
						<input type="submit" name="submit" value="Update" class="btn btn-dark">

					</form>
				<?php
					}else if($action=='delete'){
						$sql="SELECT * FROM `gallery` WHERE `id`=$id";
						$result = mysqli_query($conn, $sql); //run the query after start
						$theImage = mysqli_fetch_object($result);
				?>
					<h2>Delete</h2>
					<div class="card mt-4">
						<h5 class="card-header">Are you sure you want to delete "<?php echo($theImage->name); ?>" ?</h5>
						<div class="card-body">
							<a href="gallery.php" class="btn btn-success">No</a>&nbsp;&nbsp;
							<a href="gallery.php?act=delete&id=<?php echo($id); ?>&confirm=yes" class="btn btn-danger">Yes</a>
						</div>
					</div>
				<?php 
					}else if($action=="crop"){
						$sql="SELECT * FROM `gallery` WHERE `id`=$id";
						$result = mysqli_query($conn, $sql);
						$theImage = mysqli_fetch_object($result);
				?>
						<!-- Crop Start -->
						<div class="cropper-wrap">
							<!-- <div class="glass"></div> -->
							<img class="image-preview"  id="image-preview" src="../images/gallery/<?php echo($theImage->original); ?>">
							<div class="crop-area" >
								<div class="scale-corner"></div>
							</div>
						</div><br><br>
						<!-- Crop End -->
						<form method="POST">
							<input type="hidden" name="form-name" value="crop">
							<input type="hidden" name="id" value="<?=$id ?>">
							<input type="hidden" name="x1" class="x1">
							<input type="hidden" name="y1" class="y1">
							<input type="hidden" name="width" class="width">
							<input type="hidden" name="height" class="height">
							<input type="submit" name="submit" value="Crop" class="btn btn-dark">
						</form>
				<?php
					}
				?>
			</div>
		</div>
	</div>
	
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	<script>
		$(document).ready(function(){
			let biggestSide = 0;

			let imageOnFly = new Image();
			let scaledDownRatio = 0;
			imageOnFly.onload = function() {
		      let height = imageOnFly.height;
		      let width = imageOnFly.width;
		      let imagePreviewW = document.getElementById('image-preview').width;
		      let imagePreviewH = document.getElementById('image-preview').height;
		      scaledDownRatio = width / imagePreviewW;
		      console.log('Scale ration:'+scaledDownRatio);
		      if(imagePreviewW >= imagePreviewH){
		      	biggestSide = imagePreviewH;
		      }else{
		      	biggestSide = imagePreviewW;
		      }
		      biggestSide = biggestSide - 15; //add some buffer
		      $('.crop-area').width(biggestSide);
		      $('.crop-area').height(biggestSide);
		      console.log('biggest side ='+(biggestSide));
		    }
			imageOnFly.src = $('.image-preview').attr('src');

			$('.crop-area').draggable({ 
				containment: ".cropper-wrap", 
				scroll: false,
				drag: function( event, ui ) {
					var x1 = ui.position.left;
					var y1 = ui.position.top;
					//console.log('ratio is '+scaledDownRatio);
					var cropAreaW = biggestSide * scaledDownRatio;
					var cropAreaH = biggestSide * scaledDownRatio;
					x1 = x1 * scaledDownRatio;
					y1 = y1 * scaledDownRatio;
					$('.x1').val(x1);
					$('.y1').val(y1);
					$('.width').val(cropAreaW);
					$('.height').val(cropAreaH);
					console.log('*************');
					console.log("X1:"+x1);
					console.log("y1:"+y1);
					console.log("width:"+cropAreaW);
					console.log("height:"+cropAreaH);
				}
			});

		    $( "#sortable" ).sortable({
		      revert: true,
		      update: function( event, ui ) {
		      	var i =0;
		      	var sortData = [];
		      	 $( "#sortable tr" ).each(function(){
		      	 	console.log(i);
		      	 	$(this).find('.orderNumber').val(i);
		      	 	sortData.push({
		      	 		'id' : $(this).find('.imageId').val(),
		      	 		'orderNumber' : $(this).find('.orderNumber').val(),
		      	 	});
		      	 	i++;
		      	 })
		      	 console.log(sortData);
		      	 //Send Ajax request to update data
		      	 $.ajax({
		      	 	method: 'POST',
		      	 	data: {
		      	 		'isAjax' : true,
		      	 		'action' : 'updateSort',
		      	 		'sortData' : sortData
		      	 	}
		      	 }).done(function(response){

		      	 })
		      }
		    });
		    $( "tbody, tr" ).disableSelection();
		});
		
	</script>
</body>
</html>