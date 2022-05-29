<?php
	require_once('../../classes/class.db.php');

	if($_SERVER['REQUEST_METHOD'] == 'POST') {
		$name = $_POST['tech-name'];
		$address = $_POST['tech-address'];
		$phone = $_POST['tech-phone'];
		$car_brands = $_POST['tech-car-brand'];
		$experience_year = $_POST['tech-experience'];

		$query = sprintf("INSERT INTO technicians(name, address, phone, brand_of_cars, years_of_experience) 
			VALUES('%s', '%s', '%s', '%s', '%s')", 
			$name, $address, $phone, $car_brands, $experience_year);

		$data = mysqli_query($GLOBALS['dbc'], $query);

		$return_url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/../index.php?p=technicians';
		if ($data) {
			header('Location: ' . $return_url);
		}

		else {
			echo 'Failed to save technician details';
		}
	}

	elseif ($_SERVER['REQUEST_METHOD'] == 'GET') {
		$id = $_GET['id'];

		$data = mysqli_query($GLOBALS['dbc'], "DELETE FROM technicians WHERE id = '$id'");

		$return_url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/../index.php?p=technicians';
		if ($data) {
			header('Location: ' . $return_url);
		}

		else {
			echo 'Failed to delete technician details';
		}
	}
?>