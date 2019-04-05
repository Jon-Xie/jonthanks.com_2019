<?php 
	require_once('includes/config.php');
	require_once('core/model/Model.php');
	require_once('core/model/GalleryItemModel.php');
	require_once('core/controller/GalleryItemController.php');
	require_once('core/model/GallerySectionModel.php');
	$res = GalleryItemModel::getAllAsArray();
	print_r($res);
?>
