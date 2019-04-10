<!DOCTYPE html>
<html>
<head>
	<title></title>
	<script
  src="https://code.jquery.com/jquery-3.3.1.min.js"
  integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
  crossorigin="anonymous"></script>
  <script type="text/javascript">
  	$(document).ready(function(){
  		$.ajax({
  			'url': 'http://jonthanks.com/2019/core/controller/api.php?action=galleryitems&subaction=getall',
  			'method' : 'GET',
  		}).done(function(response){
  			console.log(response);
  		})
  	});
  </script>
</head>
<body>

</body>
</html>