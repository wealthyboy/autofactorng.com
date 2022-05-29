<?php
	$coupon_code = getToken(7);
	$message = '<html><body style="margin: 0; padding: 0;">';
	$message .= '<table border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color: silver;">';
	$message .= '<tr><td><table align="center" border="1" cellpadding="0" cellspacing="0" width="600" style="border-collapse: collapse; color: black;" bgcolor="white">';
	$message .= '<tr><td style="padding: 40px 30px 40px 30px;"><table border="0" cellpadding="0" cellspacing="0" width="100%">';
	$message .= '<tr><td align="center" bgcolor="#70bbd9" style="padding: 40px 0 20px 0;">';
	$message .= '<img src="http://autofactorng.com/images/afng_logo.png" alt="Autofactorng logo" width="400" height="100" style="display: block;" /></td></tr>'; // row 1 end
	$message .= '<tr><td><h3>Dear ' . $first_name. ',</h3>';
	//$message .= '<tr><td><h3>Dear Customer,</h3>';
	$message .= '<h3>We wish to welcome you to AutofactorNG.</h3>';
	$message .= '<h3>You are now registered with our store and have account privileges.
							With your account, you can take part in the various services we have to offer you.
							Some of these many services include
							<ul>
							<li>Order History - View the details of orders you have completed with us.</li>
							<li>Persistent Cart - Any products added to your online cart remains there until you remove or check them out.</li>
							<li>Products Review - Share your opinions on our products with other customers.</li></h3>';
	$message .= '<h3>We have also rewarded you with a coupon code of 5% off your next purchase.</h3>';
	$message .= '<h3>If you need help witih our services, please email us at <a href="mailto://care@autofactorng.com">care@autofactorng.com</a>.</h3>';
	$message .= '<h2>Your coupon code: ' . $coupon_code . '</h2>';
	$message .= '</td></tr>'; // row 2 end
	$message .= '<tr><td align="center" bgcolor="#70bbd9" style="padding: 10px 0 30px 0;">';
	$message .= '<a href="http://facebook.com/autofactorng" title="Autofactorng (facebook)" target="_blank"> <img src="http://autofactorng.com/images/facebook_a.png" alt="fb" /></a> ';
	$message .= '<a href="http://twitter.com/autofactorng" title="Autofactorng (twitter)" target="_blank"> <img src="http://autofactorng.com/images/twitter_a.png" alt="twitter" /></a> ';
	$message .= '<a href="http://instagram.com/autofactorng" title="Autofactorng (instagram)" target="_blank"> <img src="http://autofactorng.com/images/instagram_a.png" alt="ig" /></a>';
	$message .= '</td></tr></table></td></tr></table></td></tr></table></body></html>'; // row 3 end

	$headers = "From: Autofactorng <info@autofactorng.com>" . "\r\n";
	$headers .= "Reply-To: info@autofactorng.com" . "\r\n";
	$headers .= "Bcc: info@autofactorng.com\r\n";
	$headers .= "MIME-Version: 1.0\r\n";
	$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

	//echo $message;

	function crypto_rand_secure($min, $max) {
	  $range = $max - $min;
	  if ($range < 0) return $min; // not so random...
	  $log = log($range, 2);
	  $bytes = (int) ($log / 8) + 1; // length in bytes
	  $bits = (int) $log + 1; // length in bits
	  $filter = (int) (1 << $bits) - 1; // set all lower bits to 1
	  do {
	      $rnd = hexdec(bin2hex(openssl_random_pseudo_bytes($bytes)));
	      $rnd = $rnd & $filter; // discard irrelevant bits
	  } while ($rnd >= $range);
	  return $min + $rnd;
	}

	function getToken($length=32){
	  $token = "";
	  $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
	  $codeAlphabet.= "abcdefghijklmnopqrstuvwxyz";
	  $codeAlphabet.= "0123456789";
	  for($i=0;$i<$length;$i++){
	      $token .= $codeAlphabet[crypto_rand_secure(0,strlen($codeAlphabet))];
	  }
	  return $token;
	}
?>