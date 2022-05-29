<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="author" content="">
	<title>Autofactorng || Reset Password</title>
	<link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>

<?php
require_once('../classes/class.db.php');
$display_email_form = true;
$display_reset_form = false;
?>
<div class="container">
	<div class="row text-center">
		<div class="col-md-2"></div>
		<div class="col-md-8" id="reset-box">
			<a href="http://autofactorng.com" alt="LINK: HOME" title="<< Go back to homepage"><img class="img-responsive center-block" src="../images/afng_logo.png"></a>
			<h1>Autofactorng Password Recovery</h1>
			<hr />
			<?php
			if ( isset($_GET['search']) && isset($_GET['email']) ) {
				$email = mysqli_real_escape_string($GLOBALS['dbc'], trim($_GET['email']));

				$query = "SELECT * FROM users where email = '$email' or username = '$email'";

				$data = mysqli_query($GLOBALS['dbc'], $query);

				if ( mysqli_num_rows($data) == 1 ) {
					echo '<p class="pass">Email verified</p>';
					$row = mysqli_fetch_array($data);
					$username = $row['username'];
					$token = getToken();
					//$day_name_full = 'l';
					//$day_name = 'D';
					//$day_num = 'j';
					//$month_name_full = 'F';
					//$month_name = 'M';
					//$year = 'Y';
					$token_expiry = 'CURRENT_TIMESTAMP + INTERVAL 30 minute';
					$event_name = 'delete_token_' . $username . time();
					//$valid_from = date("$day_name $month_name $day_num\, h:i A");
					//$valid_to = $token_expiry

					$query = "INSERT INTO reset_password(email, token, valid_to) 
						VALUES('$email', '$token', $token_expiry)";

					$data = mysqli_query($GLOBALS['dbc'], $query) or die('Error querying DB');

					if ($data) {
						$query2 = "CREATE EVENT $event_name ON SCHEDULE AT $token_expiry DO 
							DELETE FROM reset_password WHERE email = '$email' AND valid_to <= now()";
							mysqli_query($GLOBALS['dbc'], $query2);

						require_once('../includes/password_reset_msg.php');
						if ( mail($email, $subject, $message, $headers) ) {
							echo "<p>A password-reset email has been sent to $email</p>";
							echo '<p>Follow the instructions to reset your password</p>';
							
							$display_email_form = false;
						}

						else {
							echo '<p class="error">Sorry, your account password cannot be reset at this time';
						}
						
					}
				}//

				else {
					echo '<p class="error">Email not registered</p>';
				}
			} 
			?>
			<?php
			if ($display_email_form) { ?>
			<p>Find your Autofactorng account</p>
			<form role="form" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
			<div class="row">
				<div class="col-md-3"></div>
				<div class="col-md-6">
					<div class="form-group">
						<label>Enter your email or username</label>
						<input class="form-control" type="text" name="email" value="" required="required" />
					</div>
				</div>
				<div class="col-md-3"></div>
			</div>
				<input class="btn btn-warning rcv_btn" type="submit" name="search" value="Search">
			</form>
			<?php } ?>
			<br /><br />
			<div class="pull-left"><a href="http://autofactorng.com"><i class="glyphicon glyphicon-chevron-left"></i> Go back to homepage</a></div>
			<div class="clearfix"></div>
		</div>
		<div class="col-md-2"></div>
	</div>
</div>

<?php
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
</body>
</html>