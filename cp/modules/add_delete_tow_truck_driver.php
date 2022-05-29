<?php
	require_once('../../classes/class.db.php');

	if($_SERVER['REQUEST_METHOD'] == 'POST') {
		$name = $_POST['driver-name'];
		$phone = $_POST['driver-phone'];
		$location = $_POST['driver-location'];

		$query = sprintf("INSERT INTO tow_truck_drivers(name, phone, location) 
			VALUES('%s', '%s', '%s')", 
			$name, $phone, $location);

		$data = mysqli_query($GLOBALS['dbc'], $query);

		$return_url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/../index.php?p=tow_truck_drivers';
		if ($data) {
			header('Location: ' . $return_url);
		}

		else {
			echo 'Failed to save driver details';
		}
	}

	elseif ($_SERVER['REQUEST_METHOD'] == 'GET') {
		$id = $_GET['id'];

		$data = mysqli_query($GLOBALS['dbc'], "DELETE FROM tow_truck_drivers WHERE id = '$id'");

		$return_url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/../index.php?p=tow_truck_drivers';
		if ($data) {
			header('Location: ' . $return_url);
		}

		else {
			echo 'Failed to delete driver details';
		}
	}
?>