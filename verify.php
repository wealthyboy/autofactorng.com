<?php ob_start();
      session_start(); 
?>
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
	<script src='https://www.googles.com/recaptcha/api.js'></script>
</head>
<body>
<?php
	require_once('classes/class.db.php');
	require_once('classes/class.user.php');
	require_once $_SERVER["DOCUMENT_ROOT"].'/init/autoload.php';
	require $_SERVER["DOCUMENT_ROOT"].'/modules/phpmailer/PHPMailerAutoload.php';
	
	
	$display_form = true;
	$reg_response = '';
	
	$number_format = ['081','080','070','090'];
	$sub_phone = substr(Input::get('phone'), 0, 3);
	$address   = parse_url(Input::get('address'));
	
	$token = $_SESSION['token'] = Input::get('token');
	
  
	if (Input::exists('post')) {
	    
	    $token = $_SESSION['token'];
	    
	    $user_stage = UserStage::getInstance()->find('token',$token);
	    
		if (!empty($user_stage)){
            if (!is_numeric(Input::get('phone')) || strlen(Input::get('phone')) !=  11 || !in_array($sub_phone, $number_format) ){
	     	       $reg_response = '<p class="error">Phone number not accepted!!</p>';
	        } elseif (!empty($address['host'])){
	   	           $reg_response = '<p class="error">Your address is not accepted!!</p>';
	        } elseif (!empty(strlen(Input::get('city')) > 20 )){
	   	           $reg_response = '<p class="error">Your address is not accepted!!</p>';
	        } else {  
                   $data = User::getInstance()->create([
						  'first_name'=>$user_stage->first_name,
						  'last_name'=>$user_stage->last_name,
						  'email'=>$user_stage->email,
						  'phone'=>Input::get('phone'),
						  'address'=>Input::get('address'),
						  'city'=>Input::get('city'),
						  'state_id'=>Input::get('state'),
						  'landmark'=>Input::get('lmark'),
						  'is_verified'=>true,
						  'password'=>sha1($_SESSION['sign_up_password']),
					 ]);
					  //Log any user who registers 
                      $last_insert_id = mysqli_insert_id($GLOBALS['dbc']);
                      
    //                   $response = LogSecurity::getInstance()->request();
				// 	  LogSecurity::getInstance()->create([
    //                      'user_id'=>$last_insert_id, 
		  //               'ip'=>$response['ip'],
		  //               'city'=>$response['city'] , 
		  //               'region'=>$response['region'], 
		  //               'region_code'=>$response['region_code'], 
		  //               'country_name'=>$response['country_name'], 
		  //               'country_code'=>$response['country_code'], 
		  //               'continent_name'=>$response['continent_name'], 
		  //               'continent_code'=>$response['continent_code'], 
		  //               'latitude'=>$response['latitude'], 
		  //               'longitude'=>$response['longitude'], 
		  //               'organisation'=>$response['organisation'], 
		  //               'postal'=>$response['postal'], 
		  //               'currency'=>$response['currency'],  
		  //               'currency_symbol'=>$response['currency_symbol'], 
		  //               'calling_code'=>$response['calling_code'], 
		  //               'flag'=>$response['flag'], 
		  //               'emoji_flag'=>$response['emoji_flag'], 
		  //              ' time_zone'=>$response['time_zone'],
    //                     'user_agent'=>$_SERVER ['HTTP_USER_AGENT'],
				// 	  ]);

                    $_SESSION['verify_email'] = $user_stage->email;

                if ($data) {
                	
            	   	    //Auto log in
            	      $user = array(
				       'id' => $last_insert_id,
				       'logged_in' => true
			         );
			        setcookie('user', json_encode($user), time() + 3600, '/'); //cookie 
						$reg_response = '<p class="pass">Your new account have been sucessfully created </p>';
						$display_form = false;
						$first_name=$user_stage->first_name;
						//send verification email
						$mail = new PHPMailer;
                	   require_once('modules/signup_mail.php');
						$to = $check_token->email;
						$mail->isSMTP();
						$mail->Host = 'smtp.zoho.com';
						$mail->Port = 465;
						$mail->SMTPAuth = true;
					    $mail->Username = 'verify@autofactorng.com';
					    $mail->Password = 'AFng_0808'; 
						$mail->SMTPSecure = 'ssl';
						$mail->From = 'verify@autofactorng.com';
						$mail->FromName = 'Autofactorng Team';
						$mail->addAddress($user_stage->email, 'Autofactor');
						$mail->AddBcc('info@autofactorng.com', 'New Registration Autofactor');
						$mail->isHTML(true);
						$mail->Subject = 'Thanks for registering';
						$mail->Body = "$message";
						
						if ($mail->send() ){
							$date = new DateTime('+3 months');
						    $coupon_expiry_date = date('Y-m-d', $date->getTimeStamp());
						    $query = "INSERT INTO coupons(coupon_code, coupon_value, coupon_type, valid_to, cat_id, status) 
											VALUES('$coupon_code', '5', 'percentage', '$coupon_expiry_date', 99, 'active')";

						    $data = mysqli_query($GLOBALS['dbc'], $query);
						    $_SESSION['token'] = null;
						    session_regenerate_id();
						    UserStage::getInstance()->delete('token',$user_stage->token);
						    Redirect::to('verification_complete.php');
						    
						} else {
						//	dd( $mail->ErrorInfo);
						}
				}//insert
			}
		} else {
			Redirect::to('/404.php');
		}
	}
?>
<div id="signup_wrapp">
<div id="signup_header">
<a href="http://autofactorng.com" alt="LINK: HOME" title="<< Go back to homepage"><img src="/images/afng_logo.png"></a>
</div>
<h3 style="color: #777;">Account Registration: Step 3</h3>
<hr />
<h4 id="reg_response"><?= $reg_response; ?></h4>
<?php
	if ($display_form) { ?>
		<form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
			 <input type="hidden" name="token" value="<?php echo $_SESSION['token'] ?>" />
		<p>
			<label for="phone">Mobile Number</label><br />
			<input type="text" name="phone" value="<?php echo Input::get('phone')?>" id="phone" placeholder="Phone number " required="required" />
		</p>
		<p>
			<label for="address">Street Address</label><br />
			<input type="text" name="address" value="<?php echo Input::get('address') ?>" id="address" placeholder="Street address" required="required" />
		</p>
		<p>
			<label for="city">City</label><br />
			<input type="text" name="city" value="<?php echo Input::get('city') ?>" id="city" placeholder="e.g Surulere" required="required" />
		</p>
		<p>
			<label for="lmark">Land Mark</label><br />
			<input type="text" name="lmark" value="<?php echo  Input::get('lmark') ?>" id="lmark" placeholder="e.g Opposite mobile filling station" />
		</p>
		<p>
			<label for="state">State</label><br />
			<select name="state" id="state" required="required">
				<?php
					$data = mysqli_query($GLOBALS['dbc'], "SELECT * FROM state");
					while($row = mysqli_fetch_array($data)) { ?>
						<option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
				<?php	} ?>
			</select>
		</p>
		
		<p>
			<input type="submit" name="signup" value="Finish" />
		</p>
	</form>
<?php } ?>
</div>
</body>
</html>