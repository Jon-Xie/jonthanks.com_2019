var endpoint = 'http://jonthanks.com/2019/core/controller/api.php';

function initGalleryBackend() {
	// $.ajax({
	// 	'url': endpoint + '?action=galleryitems&subaction=getall',
	// 	'method' : 'GET'
	// }).done(function(response){
	// 	if(response != undefined) {
	// 		response = JSON.parse(repsonse);
	// 		$().
	// 	}
	// });

	function reqLoad(){
		console.log(this.responseText);
	}
	var req = new XMLHttpRequest();
	req.addEventListener("load",reqLoad);
	req.open('GET',endpoint+'?action=galleryitems&subaction=getall');
	req.send();
}