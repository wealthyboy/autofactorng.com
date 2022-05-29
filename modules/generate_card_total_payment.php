<?php
	session_start();

	$index					= $_GET['index'] + 1;
	$shipping 			= $_SESSION['shipping'];
	$w_shipping 		= $_SESSION['w_shipping'];
	$w_installation = $_SESSION['w_installation'];

	unset($_SESSION['shipping']);
	unset($_SESSION['w_shipping']);
	unset($_SESSION['w_installation']);

	$payments = <<<EOT
	<input type="hidden" name="item_$index" value="Shipping Cost" />
	<input type="hidden" name="price_$index" value="$shipping" />
EOT;

	if ($w_shipping > 0) {
		$index = $index + 1;
		$payments .= <<<EOT
		<input type="hidden" name="item_$index" value="Windshield Shipping Cost" />
		<input type="hidden" name="price_$index" value="$w_shipping" />
EOT;
	}

	if ($w_installation > 0) {
		$index = $index + 1;
		$payments .= <<<EOT
		<input type="hidden" name="item_$index" value="Windshield Installation" />
		<input type="hidden" name="price_$index" value="$w_installation" />
EOT;
	}

	echo $payments;
?>