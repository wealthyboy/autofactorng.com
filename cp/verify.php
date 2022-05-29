<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Autofactorng || Sign Up</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<script type="text/javascript" src="js/jquery.js"></script>
</head>
<body>

<?php require_once $_SERVER["DOCUMENT_ROOT"].'/init/autoload.php';
	  require $_SERVER["DOCUMENT_ROOT"].'/modules/phpmailer/PHPMailerAutoload.php';

    if(count($_GET) == 1){

    	if (Input::exists('get') && Input::get('token') ) {
	  	    $check_token = User::getInstance()->find('token',Input::get('token'));
            if(!empty($check_token)){
               //then we have a match
            	$result=User::getInstance()->update($check_token->id,[
            		'is_verified'=>true,
            		'token'=>null,
            	]);
            	//Auto log in
            	$user = array(
				 'id' => $check_token->id,
				 'logged_in' => true
			    );
			setcookie('user', json_encode($user), time() + (86400 * 30 * 20), '/'); //cookie expires in 20yrs
                if($result){
                	$mail = new PHPMailer;
                	require_once('modules/signup_mail.php');
						$to = $check_token->email;
						$mail->isSMTP();
						$mail->Host = 'smtp.zoho.com';
						$mail->Port = 465;
						$mail->SMTPAuth = true;
						$mail->Username = 'noreply@autofactorng.com';
						$mail->Password = 'autofactorng88';
						$mail->SMTPSecure = 'ssl';
						$mail->From = 'noreply@autofactorng.com';
						$mail->FromName = 'Autofactorng Team';
						$mail->addAddress($check_token->email, 'Autofactor');
						$mail->isHTML(true);
						$mail->Subject = 'Thanks for registering';
						$mail->Body = "$message";
						
						if ($mail->send() ) {
							
							$date = new DateTime('+3 months');
						    $coupon_expiry_date = date('Y-m-d', $date->getTimeStamp());
						    $query = "INSERT INTO coupons(coupon_code, coupon_value, coupon_type, valid_to, cat_id, status) 
											VALUES('$coupon_code', '5', 'percentage', '$coupon_expiry_date', 99, 'active')";

						    $data = mysqli_query($GLOBALS['dbc'], $query);
						     Redirect::to('verification_complete.php');
						} else {
							dd( $mail->ErrorInfo);
						}
	           } else{
	           	  Redirect::to('404.php');
	           }
            } else{
               Redirect::to('404.php');
            }
	    } else {
	  	    Redirect::to('404.php');
	    }
    } else{
           Redirect::to('404.php');
    } ?>

 </div>
</body>
</html>
	  
	  