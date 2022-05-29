<?php
	session_start();
	$coupon_code = $_GET['coupon-code'];
	$_SESSION['coupon_code'] = $coupon_code;
?>