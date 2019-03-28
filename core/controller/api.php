<?php
$action = '';
$subaction = '';
$id = '';
$output = array();

if(!empty($_GET['action'])) {
	$action = $_GET['action'];
}

if(!empty($_GET['subaction'])) {
	$subaction = $_GET['subaction'];
}

if(!empty($_GET['id'])) {
	$id = $_GET['id'];
}

if($action == 'galleryitems'){
	if($subaction == 'getall'){
		$output = GalleryItemModel::getAll();
	}else if($subaction == 'getbyid'){
		$output = GalleryItemModel::getById($id);
	}
}else if($action == 'pages'){
	if($subaction == 'getall'){
		$output = PageModel::getAll();
	}else if($subaction == 'getbyid'){
		$output = PageModel::getById($id);
	}
}

echo json_encode($output);

