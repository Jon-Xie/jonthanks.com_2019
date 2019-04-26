var endpoint = 'http://jonthanks.com/2019/core/controller/api.php';
var gallerySections;

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
			document.getElementById('gallery-list').innerHTML += '<tr><td>'+item.id+'</td><td>'+item.thumb+'</td><td>'+item.name+'</td><td class="cat-'+item.categoryId+'"></td><td>'+item.favorite  +'</td><td>Edit</td><td>Delete</td></tr>';
			//console.log(res.items[i]);
			replaceCatIdWithCatName(item.categoryId);
		}
	}
}

function getCategories(id){
	var url = endpoint + '?action=gallerysections&subaction=getall';
	ajax(url,'GET',setCategoriesArray);
}
function setCategoriesArray(){
	var res = this.responseText;
	if(res !== undefined) {
		res = JSON.parse(res);
		gallerySections = res;
	}
	loadList();
}

function replaceCatIdWithCatName(catId){
	if(gallerySections!=undefined){
		for(i=0; i<gallerySections.items.length; i++){
			var item = gallerySections.items[i];
			if(item.id == catId){
				var catCells = document.getElementsByClassName('cat-'+catId);
				for(j=0; j<catCells.length; j++){
					catCells[j].innerHTML = item.title;
				}
				break;
			}
		}
	}
	console.log(catId);
		console.log(gallerySections);
}


// function editObject();
	

// function deleteObject();
// getCategories(); 

// $('.cats').html('hi');
// targetClass('cats','color','red');

// function targetByClass(className,func,value) {
// 	var items = document.getElementsByClassName(className);
// 	for(j=0; j<items.length; j++){
// 		if(func=='sethtml'){
// 			items[j].innerHTML = value;
// 		}else if(func == 'settext'){
// 			items[j].innerText = value;
// 		}else if(func == 'color'){
// 			items[j].style.color = value;
// 		}
// 	}
// }

