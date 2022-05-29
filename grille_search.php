<?php
	require_once('classes/class.db.php');
	
	$make = $_GET['grille-make'];
	$grille_option = $_GET['grille-option'];

	$query = "SELECT model FROM cars WHERE brand_id = $make AND $grille_option";

  $result = mysqli_query($GLOBALS['dbc'], $query);

	$vehicle_models = array();

	while($row = mysqli_fetch_array($result)) {
	   $vehicle_models[] = array(
			'model' => $row['model']
		);
	}

	echo json_encode($vehicle_models);
	//echo 'Make: ' . $make . ' || Grille Option: ' . $grille_option;
	//echo 'Make: ' . $make;
?>