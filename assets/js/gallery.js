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

}
function ajax(url, method ,callback) {
	var req = new XMLHttpRequest();
	req.addEventListener("load", callback);
	req.open(method, url);
	req.send();
}

function loadList(){
	var url = endpoint + '?action=galleryitems&subaction=getall';
	ajax(url,'GET',populateList);
}
function populateList(){
	var res = this.responseText;
	if(res !== undefined) {
		res = JSON.parse(res);
		var items = res.items;
		for(var i = 0; i <items.length; i++) {
			var item = items[i];
			document.getElementById('gallery-list').innerHTML += '<tr><td>'+item.id+'</td><td>'+item.thumb+'</td><td>'+item.name+'</td><td>'+item.categoryId+'</td><td>'+item.favorite  +'</td><td>Edit</td><td>Delete</td></tr>';
			console.log(res.items[i]);
		}

	}
}

loadList();


