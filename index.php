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
  <?php  
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,'http://jonthanks.com/2019/core/controller/api.php?action=galleryitems&subaction=getall');
  curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,false);
  curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,false);
  $response = curl_exec($ch);
  $responseArray = json_decode($response,true);
  if($responseArray['success']==true){
    foreach ($responseArray['items'] as $item) {
      echo '<img src="http://jonthanks.com/images/gallery/'.$item['original'].'">';
      echo '<br>';
    }
  }
  //echo($response);
  curl_close($ch);

  ?>

</body>
</html>