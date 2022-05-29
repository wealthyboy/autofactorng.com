<?php
	session_start();
	$windshield_installation = $_GET['windshield-installation'];
	$_SESSION['install_windshield'] = $windshield_installation;

	if ( !empty($_SESSION['install_windshield']) ){
		echo $_SESSION['install_windshield'] . " has been set to SESSION super global";
	}
?>