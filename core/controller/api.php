<?php
require_once('../../includes/config.php');

$action = '';
$subaction = '';
$id = '';
$output = array(
		'success' => false,
		'message' => 'Error.'
	);

if(!empty($_GET['action'])) {
	$action = $_GET['action'];
}
if(!empty($_POST['action'])) {
	$action = $_POST['action'];
}

if(!empty($_GET['subaction'])) {
	$subaction = $_GET['subaction'];
}
if(!empty($_POST['subaction'])) {
	$subaction = $_POST['subaction'];
}

if(!empty($_GET['id'])) {
	$id = $_GET['id'];
}
if(!empty($_POST['id'])) {
	$id = $_POST['id'];
}

if(!empty($_GET['categoryId'])) {
	$categoryId = $_GET['categoryId'];
}

if($action == 'galleryitems'){
	if($subaction == 'getall'){
		$items = GalleryItemModel::getAllAsArray();
		if(count($items)>0){
			$output = array(
				'success' => true,
				'message' => '',
				'items' => $items
			);
		}else{
			$output = array(
				'success' => false,
				'message' => 'There was no image in the galleryitems table',
			);
		}
	}else if($subaction == 'getbyid'){
		$item = GalleryItemModel::getByIdAsArray($id);
		if($item !== false){
			$output = array(
				'success' => true,
				'message' => '',
				'item' => $item
			);
		}else{
			$output = array(
				'success' => false,
				'message' => 'There was no image by provided ID',
			);
		}
	}else if ($subaction == 'getByCategoryId'){
		$item = GalleryItemModel::getByCategoryIdAsArray($categoryId);
		if($item !== false) {
			$output = array(
				'success' => true,
				'message' => '',
				'item' => $item
			);
		} else {
			$output = array(
				'success' => false,
				'message' => 'There was no image by provided ID'
			);
		}

	}else if($subaction == 'add'){
		$errors = array();
		if(!empty($_POST['name'])){
			$name = $_POST['name'];
		}else{
			$errors[] = 'Please provide the name for this image';
		}
		if(!empty($_POST['image'])){
			$image = $_POST['image']; //Using php map to thumb/original
		}else{
			$errors[] = 'Please select an image';
		}
		if(!empty($_POST['categoryId'])){
			$categoryId = $_POST['categoryId'];
		}else{
			$errors[] = 'Please select a category';
		}
		$favorite = (!empty($_POST['favorite']))? 1 : 0;
		if(!empty($_POST['orderNumber'])){
			$orderNumber = $_POST['orderNumber'];
		}else{
			$errors[] = 'Please provide the orderNumber';
		}
		if(count($errors)==0){
			$GalleryItemModel = new GalleryItemModel(null,$name, $image, $image, $categoryId,$favorite, $orderNumber);
			$GalleryItemModel->save();
			$output = array(
				'success' => true,
				'message' => '',
			);
		}else{
			$output = array(
				'success' => false,
				'message' => $errors,
			);
		}

	}else if($subaction == 'edit'){
		$galleryItem = GalleryItemModel::getById($id);
		$errors = array();
		if($galleryItem === false){
			$errors[] = 'There is no image with the provided id';
		}
		if(!empty($_POST['name'])){
			$name = $_POST['name'];
		}else{
			$errors[] = 'Please provide the name for this image';
		}
		if(!empty($_POST['image'])){
			$image = $_POST['image']; //Using php map to thumb/original
		}else{
			$errors[] = 'Please select an image';
		}
		if(!empty($_POST['categoryId'])){
			$categoryId = $_POST['categoryId'];
		}else{
			$errors[] = 'Please select a category';
		}
		$favorite = (!empty($_POST['favorite']))? 1 : 0;
		if(!empty($_POST['orderNumber'])){
			$orderNumber = $_POST['orderNumber'];
		}else{
			$errors[] = 'Please provide the orderNumber';
		}
		if(count($errors)==0){
			$galleryItem->setName($name);
			$galleryItem->setThumb($image);
			$galleryItem->setOriginal($image);
			$galleryItem->setCategoryId($categoryId);
			$galleryItem->setFavorite($favorite);
			$galleryItem->setOrderNumber($orderNumber);
			$galleryItem->save();
			$output = array(
				'success' => true,
				'message' => '',
			);
		}else{
			$output = array(
				'success' => false,
				'message' => $errors,
			);
		}
	}else if($subaction == 'delete'){
		$galleryItem = GalleryItemModel::getById($id);
		$errors = array();
		if($galleryItem === false){
			$errors[] = 'There is no image with the provided id';
		}
		if(count($errors)==0){
			$galleryItem->delete();
			$output = array(
				'success' => true,
				'message' => '',
			);
		}else{
			$output = array(
				'success' => false,
				'message' => $errors,
			);
		}
		
	}
}else if($action=='gallerysections'){
	if($subaction == 'getall'){
		$items = GallerySectionModel::getAllAsArray();
		if(count($items)>0){
			$output = array(
				'success' => true,
				'message' => '',
				'items' => $items
			);
		}else{
			$output = array(
				'success' => false,
				'message' => 'There was no gallery section in the database',
			);
		}
	}else if($subaction == 'getbyid'){
		$item = GallerySectionModel::getByIdAsArray($id);
		if($item !== false){
			$output = array(
				'success' => true,
				'message' => '',
				'item' => $item
			);
		}else{
			$output = array(
				'success' => false,
				'message' => 'There was no gallery section by provided ID',
			);
		}
	}else if($subaction == 'add'){
		$errors = array();
		if(!empty($_POST['title'])){
			$title = $_POST['title'];
		}else{
			$errors[] = 'Please provide the title for this gallery section';
		}
		if(count($errors)==0){
			$GallerySectionModel = new GallerySectionModel(null,$title);
			$GallerySectionModel->save();
			$output = array(
				'success' => true,
				'message' => '',
			);
		}else{
			$output = array(
				'success' => false,
				'message' => $errors,
			);
		}

	}else if($subaction == 'edit'){
		$gallerySection = GallerySectionModel::getById($id);
		$errors = array();
		if($gallerySection === false){
			$errors[] = 'There is no gallery section with the provided id';
		}
		if(!empty($_POST['title'])){
			$title = $_POST['title'];
		}else{
			$errors[] = 'Please provide the title for this gallery section';
		}
		if(count($errors)==0){
			$gallerySection->setTitle($title);
			$gallerySection->save();
			$output = array(
				'success' => true,
				'message' => '',
			);
		}else{
			$output = array(
				'success' => false,
				'message' => $errors,
			);
		}
	}else if($subaction == 'delete'){
		$gallerySection = GallerySectionModel::getById($id);
		$errors = array();
		if($gallerySection === false){
			$errors[] = 'There is no gallery section with the provided id';
		}
		if(count($errors)==0){
			$gallerySection->delete();
			$output = array(
				'success' => true,
				'message' => '',
			);
		}else{
			$output = array(
				'success' => false,
				'message' => $errors,
			);
		}
		
	}
}else if($action == 'pages'){
	// if($subaction == 'getall'){
	// 	$output = PageModel::getAll();
	// }else if($subaction == 'getbyid'){
	// 	$output = PageModel::getById($id);
	// }
}

echo json_encode($output);

/*
Getall getbyid GET
Add,edit,delete POST
PUT, DELETE

*/
// api.php?action=galleryitems&subaction=getall  Get all the images
// api.php?action=galleryitems&subaction=getbyid&id=2  Get image by id