<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="author" content="">
	<title>Autofactorng || Reset Password</title>
	<link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<?php
	require_once('../classes/class.db.php');
?>

<div class="container">
	<div class="row text-center">
		<div class="col-md-2"></div>
		<div class="col-md-8" id="reset-box">
			<a href="http://autofactorng.com" alt="LINK: HOME" title="<< Go back to homepage"><img class="img-responsive center-block" src="../images/afng_logo.png"></a>
			<h1>Autofactorng Password Recovery</h1>
			<hr />
			<?php
			$valid_token = false;

			if (isset($_POST['reset-password'])) {
				$pass_1 = $_POST['password1'];
				$pass_2 = $_POST['password2'];
				$user_email = $_POST['user-email'];
				if ($pass_1 == $pass_2) {
					$query = "UPDATE users SET password = SHA('$pass_1') WHERE email = '$user_email' LIMIT 1";
					$update_password = mysqli_query($GLOBALS['dbc'], $query);

					if ($update_password) {
						echo '<p class="pass">Congratulations, you have successfully reset your password</p>';
						mysqli_query($GLOBALS['dbc'], "DELETE FROM reset_password WHERE email = '$user_email'");
					}
				}

				else {
					echo '<p class="error">Password mismatch, please re-enter password</p>';
					$valid_token = true;
				}
			}

			else if ( isset($_GET['token']) ) {
				$token = mysqli_real_escape_string($GLOBALS['dbc'], trim($_GET['token']));

				$data = mysqli_query($GLOBALS['dbc'], "SELECT * FROM reset_password where token = '$token'");

				if (mysqli_num_rows($data) == 1) {
					$valid_token = true;
					$row = mysqli_fetch_array($data);
					$user_email = $row['email'];
				}

				else {
					echo '<p class="error">Invalid link or token expired</p>';
					echo '<p><a href="http://autofactorng.com/account/begin_password_reset.php">
						<button>Retry</button></a></p>';
				}
			}

			else {
				header('Location:begin_password_reset.php');
			}

			if ($valid_token) { ?>
				<form role="form" method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
				<div class="row">
					<div class="col-md-3"></div>
					<div class="col-md-6">
						<div class="form-group">
							<label>Enter your new password</label>
							<input class="form-control" type="password" name="password1" value="" required="required" pattern=".{6,}" placeholder= "Minimum of 6 characters"/>
						</div>
						<div class="form-group">
							<label>Confirm password</label>
							<input class="form-control" type="password" name="password2" value="" required="required" pattern=".{6,}" placeholder="Minimum of 6 characters"/>
						</div>
						<input type="hidden" name="user-email" value="<?php echo $user_email; ?>" />
						<input class="btn btn-warning" type="submit" name="reset-password" value="Reset Password">
					</div>
					<div class="col-md-3"></div>
				</div>
			</form>
			<?php } ?>
			<br /><br />
			<div class="pull-left"><a href="http://autofactorng.com"><i class="glyphicon glyphicon-chevron-left"></i> Go back to homepage</a></div>
			<div class="clearfix"></div>
		</div>
		<div class="col-md-2"></div>
	</div>
</div>
</body>
</html>