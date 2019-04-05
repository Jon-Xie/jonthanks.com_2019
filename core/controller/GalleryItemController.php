<?php
class GalleryItemController{
	private $model;

	public function __construct(){
		$this->model = new GalleryItemModel();
	}

	// public function getAllJSON(){
	// 	return json_encode($this->model->getAllAsArray());
	// }

	// public function getByIdJSON($id){
	// 	return json_encode($this->model->getByIdAsArray($id));
	// }

	public function processForm(){
			$action = '';
			if(!empty($_GET['act'])){ //$_GET pulls from query string
				$action = $_GET['act'];
			}

			if(!empty($_GET['id'])){
				$id = $_GET['id'];
			}
		if(count($_POST) > 0){
			$formName = $_POST['form-name'];
			$name = $_POST['name'];
			$categoryId = $_POST['categoryId'];
			$favorite = $_POST['favorite'];
			//Upload image
			if(!empty($_FILES['image'])){
				$fileName = $_FILES['image']['name'];
				$siteTempDestination = BASEPATH.'images/temp/'.$fileName;
				// $thumbDestination =  BASEPATH.'images/gallery/thumbnails/'.$fileName;
				$LargeDestination = BASEPATH.'images/gallery/'.$fileName;
				$res = move_uploaded_file($_FILES['image']['tmp_name'], $siteTempDestination); 
				thumbGen($siteTempDestination,$LargeDestination,LARGESIZE);
				// thumbGen($siteTempDestination,$thumbDestination,THUMBSIZE);
				unlink($siteTempDestination);
			}else{
				$fileName = '';
			}
			if($formName == 'add'){
				$sql = "INSERT INTO `gallery` (`name`,`original`,`categoryId`,`favorite`)VALUES('$name','$fileName',$categoryId,$favorite)";
				mysqli_query($conn,$sql);
				$theId = mysqli_insert_id($conn);
				header('location: gallery.php?act=crop&id='.$theId);
				exit();
			}else if($formName == 'edit'){
				if($fileName==''){ //User didn't provide a new image so we will not update the image
					$sql = "UPDATE `gallery` SET `name` = '$name' , `categoryId` = $categoryId, `favorite`= $favorite  WHERE `id` = $id"; // WHERE essential bc it will update all if u dont specify idate
				}else{
					//Remove the old physical image file
					$sql = "SELECT * FROM `gallery` WHERE `id`=".$id;
					$res = mysqli_query($conn, $sql);
					$newsObj = mysqli_fetch_object($res);
					unlink(BASEPATH.'images/gallery/'.$newsObj->image);
					unlink(BASEPATH.'images/gallery/thumbnails/'.$newsObj->thumbnail);
					$sql = "UPDATE `gallery` SET `name` = '$name' , `categoryId` = $categoryId, `favorite`= $favorite , `thumb`='$fileName', `original`='$fileName' WHERE `id` = $id"; // WHERE essential bc it will update all if u dont specify idate
				}
				mysqli_query($conn, $sql);
				header('location: gallery.php');
				exit();
			}else if($formName == 'crop'){
				$sql = "SELECT * FROM `gallery` WHERE `id`=".$id;
				$res = mysqli_query($conn, $sql);
				$theImage = mysqli_fetch_object($res);
				$originalImage = BASEPATH.'images/gallery/'.$theImage->original;
				$x1 = $_POST['x1'];
				$y1 = $_POST['y1'];
				$width = $_POST['width'];
				$height = $_POST['height'];
				if(exif_imagetype($originalImage) === IMAGETYPE_JPEG){
					$source_image = imagecreatefromjpeg($originalImage);
				}else if(exif_imagetype($originalImage) === IMAGETYPE_PNG){
					$source_image = imagecreatefrompng($originalImage);
				}
				// echo($x1.'<br>');
				// echo($y1.'<br>');
				// echo($width.'<br>');
				// echo($height.'<br>');
				$virtual_image = imagecrop($source_image, array('x'=>$x1, 'y'=>$y1, 'width'=>$width,'height'=> $height));
				$res = imagejpeg($virtual_image, BASEPATH.'images/gallery/thumbnails/'.$theImage->original, 100);
				// var_dump($res);
				// exit();
				$thumbName = $theImage->original;
				$sql = "UPDATE `gallery` SET `thumb`='$thumbName' WHERE `id`=$id ";
				$res = mysqli_query($conn, $sql);
				header('location: gallery.php');
				exit();
			}
		}

		if($action== 'delete' && !empty($_GET['confirm'])){ //
			$sql = "DELETE FROM `gallery` WHERE `id`= $id";
			mysqli_query($conn, $sql);
			header('location: gallery.php');
			exit();
		}
	}
}