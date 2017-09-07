<?php  
require __DIR__.'/vendor/autoload.php';
session_start();
if (!empty($_POST['adress'])){
	$_SESSION['adress'] = $_POST['adress'];
	$query = $_SESSION['adress'];
	$api = new \Yandex\Geo\Api();
	$api->setQuery($query);
	$api
		->setLang(\Yandex\Geo\Api::LANG_RU)
		->load();
	$response = $api->getResponse();
	$collection = $response->getList();
	foreach ($collection as $item) {
    echo '<a href="?latitude='.$item->getLatitude().'&longitude='.$item->getLongitude().'">'.$item->getAddress().'</a>   ';
    	echo '('.$lat = $item->getLatitude().' - ';
		echo $long = $item->getLongitude().')<br>';
	}
}

$lat = '55.76';
$long = '37.64';
if (isset($_GET['latitude']) && isset($_GET['longitude'])) {
	$lat = $_GET['latitude'];
	$long = $_GET['longitude'];
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>maps</title>
	<meta charset="utf-8">
	<script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU" type="text/javascript"></script>
	<script type="text/javascript">
        ymaps.ready(init);
        var myMap, 
            myPlacemark;

        function init(){ 
            myMap = new ymaps.Map("map", {
                center: [<?=$lat?>, <?=$long?>],
                zoom: 7
            }); 
            
            myPlacemark = new ymaps.Placemark([<?=$lat?>, <?=$long?>], {
                hintContent: 'тута!',
                balloonContent: 'здеся'
            });
            
            myMap.geoObjects.add(myPlacemark);
        }
    </script>
</head>
<body>
	<br>
	<form action="" name="search" method="post">
		<input type="text" name="adress" value="" placeholder="введите адрес...">
		<input type="submit" name="go" value="Искать!">
	</form>
	<br>	
	<div id="map" style="width: 600px; height: 400px"></div>
</body>
</html>