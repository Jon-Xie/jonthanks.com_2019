<?php 
	require_once('includes/config.php');

	require_once('core/model/Model.php');
	require_once('core/model/GalleryItem.php');
	require_once('core/model/GallerySectionModel.php');
	
	// $gi = new GalleryItemModel();
	// $photos = $gi->getAll();
	
	// $photos = GalleryItemModel::getAll();
	// if(count($photos)> 0 ){
	// 	foreach($photos as $photo){
	// 		$photo->setTitle('On Sale');
	// 		$photo->save();
	// 	}
	// }


	// $jonPhoto = GalleryItemModel::getById(4);
	// if($jonPhoto != false){
	// 	echo $JonPhoto->getTitle();
	// }
	$GSM = new GallerySectionModel(2,"Personal");
	//$GSM->setId(4);


	$GIM = new GalleryItemModel(5,"Jon Picture","1-thumb.jpg",....);
	//$GIM->setId(14);


	jonthanks.com/api.php?action=galleryitems&subaction=getall 
	jonthanks.com/api.php?action=galleryitems&subaction=getbyid&id=4
	jonthanks.com/api.php?action=galleryitems&subaction=blah 


	jonthanks.com/api.php?action=pages&subaction=getall 
	jonthanks.com/api.php?action=pages&subaction=getbyid&id=2
	jonthanks.com/api.php?action=pages&subaction=Blahblah
	

	jonthanks.com/api/pages/getall/
	jonthanks.com/api/pages/getbyid/3/	

	jonthanks.cm/api/pages/add/
}

?>