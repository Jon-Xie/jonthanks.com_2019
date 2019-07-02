<?php
class GalleryItemController{
	private $model;

	public function __construct(){
		$this->model = new GalleryItemModel();
	}

	public function processForm(){
		$action = $this->getAction();
		$id = $this->getId();
		if(!empty($_POST['form-name']) && ($_POST['form-name']=='add'|| $_POST['form-name']==edit)){
			$formName = $_POST['form-name'];
			$name = $_POST['name'];
			$categoryId = $_POST['categoryId'];
			$favorite = $_POST['favorite'];
			$orderNumber = $_POST['orderNumber'];
			//Upload image
			if(!empty($_FILES['image'])){
				$fileName = $_FILES['image']['name'];
				$siteTempDestination = BASEPATH.'images/temp/'.$fileName;
				$LargeDestination = BASEPATH.'images/gallery/'.$fileName;
				$res = move_uploaded_file($_FILES['image']['tmp_name'], $siteTempDestination); 
				thumbGen($siteTempDestination,$LargeDestination,LARGESIZE);
				unlink($siteTempDestination);
			}else{
				$fileName = '';
			}
			if($formName == 'add'){
				$this->model->setId(null);
				$this->model->setName($name);
				$this->model->setThumb($fileName);
				$this->model->setOriginal($fileName);
				$this->model->setCategoryId($categoryId);
				$this->model->setFavorite($favorite);
				$this->model->setOrderNumber($orderNumber);
				$this->model->save();
				header('location: gallery.php?act=crop&id='.$theId);
				exit();
			}else if($formName == 'edit'){
					$this->model->setId($id);
					$this->model->setName($name);
					$this->model->setCategoryId($categoryId);
					$this->model->setFavorite($favorite);
					$this->model->setOrderNumber($orderNumber);
				if($fileName==''){ //User didn't provide a new image so we will not update the image
					$this->model->setThumb(null);
					$this->model->setOriginal(null);
				}else{
					//Remove the old physical image file
					$newsObj = $this->model->getById($id);
					unlink(BASEPATH.'images/gallery/'.$newsObj->image);
					unlink(BASEPATH.'images/gallery/thumbnails/'.$newsObj->thumbnail);
					$this->model->setThumb($fileName);
					$this->model->setOriginal($fileName);
				}
				$this->model->save();
				header('location: gallery.php');
				exit();
			}else if($formName == 'crop'){
				$theImage = $this->model->getById($id);
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
				$virtual_image = imagecrop($source_image, array('x'=>$x1, 'y'=>$y1, 'width'=>$width,'height'=> $height)); //Crop
				$virtual_image = imagescale($virtual_image, 768); //resize
				$res = imagejpeg($virtual_image, BASEPATH.'images/gallery/thumbnails/'.$theImage->original, 100);

				$thumbName = $theImage->original;
				$image = $this->model->getById($id);
				$image->setThumb($thumbName);
				$image->save();
				header('location: gallery.php');
				exit();
			}
		}
		
		//Delete
		if($action== 'delete' && !empty($_GET['confirm'])){
			$item = $this->model->getById($id);
			$item->delete();
			header('location: gallery.php');
			exit();
		}

		//Update Sort
		if(!empty($_POST['isAjax'])){
			$action = $_POST['action'];
			$sortData = $_POST['sortData'];
			if($action == 'updateSort'){
				if(count($sortData)>0){
					foreach ($sortData as $item) {
						$image = GalleryItemModel::getById($item['id']);
						$image->setOrderNumber($item['orderNumber']);
						$image->save();
					}
				}
				$output = array('success'=> true,'message'=>'this transaction was successful');
				echo json_encode($output);
				exit();
			}
		}
	}

	function getAction(){
		$action = '';
		if(!empty($_GET['act'])){ //$_GET pulls from query string
			$action = $_GET['act'];
		}
		return $action;
	}

	function getId(){
		$id = null;
		if(!empty($_GET['id'])){
			$id = $_GET['id'];
		}
		return $id;
	}
}