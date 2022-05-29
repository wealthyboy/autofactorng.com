<?php
	$subject = "Autofactorng Password Reset";

	$headers = "From: Autofactorng Team <support@autofactorng.com>" . "\r\n";
	$headers .= "Reply-To: support@autofactorng.com" . "\r\n";
	$headers .= "Bcc: support@autofactorng.com\r\n";
	$headers .= "MIME-Version: 1.0\r\n";
	$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

	$message = '<html><body style="margin: 0; padding: 0;">';
	$message .= '<table border="0" cellpadding="0" cellspacing="0" width="100%">';
	$message .= '<tr><td>';
	$message .= 	'<table align="center" border="1" cellpadding="0" cellspacing="0" width="600" style="border-collapse: collapse; color: black; font-family: verdana; font-size: 10pt;" bgcolor="white">';
	$message .= 	'<tr bgcolor="brown"><th style="padding: 10px 0px"><img src="http://autofactorng.com/images/afng_logo.png" /></th></tr>';
	$message .= 	'<tr><td style="padding: 40px 30px 40px 30px;">';
	$message .= 	'<p>Hello ' . $username . ',</p>';
	$message .= 	'<p>You recently requested to reset your password for your Autofactorng account. Click the button below to reset it.</p>';
	$message .= 	'<p align="center">
									<a href="http://www.autofactorng.com/account/reset_password.php?token=' . $token . '">
									<button title="Reset your password" style="background-color: orange;
									color: white;
									border: 0px;
									padding: 10px;
									border-radius: 4px;
									cursor: pointer;
									font-weight: bolder;">
									Reset your password</button></a></p>';
	$message .= 	'<p>If you did not request a password reset, please ignore this email or reply to let us know. This password reset is only valid for the next 30 minutes.</p>';
	$message .= 	'<p>Thanks, <br /> The Autofactorng Team <br /></p><p>Phone: +234 (0) 908 1155 505</p>';
	$message .= 	'<hr /><p style="font-size: 8pt;">If you\'re having trouble clicking the password reset button, copy and paste the URL below into your web browser</p>';
	$message .= 	'<p style="font-size: 8pt;"><a href="http://www.autofactorng.com/account/reset_password.php?token=' . $token . '">http://www.autofactorng.com/account/reset_password.php?token=' . $token . '</a></p>';
	$message .= 	'</td></tr>';
	$message .= 	'</table>';
	$message .= '</td></tr>';
	$message .= '</table>';
	$message .= '</body></html>';
?>