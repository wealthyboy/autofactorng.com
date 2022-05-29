<?php
	require_once('classes/class.db.php');
	
	//$year = (ISSET($_GET['year']) && $_GET['year']!=='') ? $_GET['year'] : "2016";
	$year = $_GET['year'];

	$query = "SELECT car_brands.name make, cars.model model FROM cars INNER JOIN car_brands ON cars.brand_id = car_brands.id WHERE cars.year like '%$year%' ORDER BY make ASC, model ASC";

  $result = mysqli_query($GLOBALS['dbc'], $query);

	$vehicle_models = array();

	while($row = mysqli_fetch_array($result)) {
	   $vehicle_models[] = array(
			'make' => $row['make'],
			'model' => $row['model']
		);
	}

	echo json_encode($vehicle_models);
?>