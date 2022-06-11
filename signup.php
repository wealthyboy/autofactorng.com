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
     <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>


<body>
<?php
	require_once('classes/class.db.php');
	require_once('classes/class.user.php');
	require_once $_SERVER["DOCUMENT_ROOT"].'/init/autoload.php';
	require $_SERVER["DOCUMENT_ROOT"].'/modules/phpmailer/PHPMailerAutoload.php';
	require_once('classes/Mailchimp.php');    // You may have to modify the path based on your own configuration.
       $api_key = "null";
       $list_id = "a07acc0523";
	
	
	$display_form = true;
	$reg_response = '';
	
	if ( !isset($_SESSION['token']) ){
	    $_SESSION['token'] =$token=bin2hex(openssl_random_pseudo_bytes(30));
	}
	
	
	
	$number_format = ['081','080','070','090'];
	
	$sub_phone = substr(Input::get('phone'), 0, 3);
	//dd(strlen(Input::get('phone')));
	$address   = parse_url(Input::get('address'));

	if (Input::exists('post')) {
	      $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$_POST['secret'].'&response='.$_POST['g-recaptcha-response']); 
             
            // Decode json data 
            $responseData = json_decode($verifyResponse);
            
           
		//check session id and time of any registration
		
		if ($responseData->success == false ){
		   $reg_response=  '<p class="error">PLease tick your captcha.</p>';  
		}

		elseif (!preg_match("/^[A-Za-z\\- \']+$/",Input::get('fname') ) || strlen(Input::get('fname'))   > 20) 
       {
       	  $reg_response=  '<p class="error">Sorry, Your first name is not accepted !!.</p>';
       	
       } 
       elseif ($_SESSION['token'] !== Input::get('token') )  {
          $reg_response=  '<p class="error">Token mismatch !!.</p>';
       }
        
       
       elseif (!preg_match("/^[A-Za-z\\- \']+$/",Input::get('lname') ) || strlen(Input::get('lname'))   > 20) {
          $reg_response=  '<p class="error">Sorry, Your last name is not accepted !!.</p>';
       }elseif (!preg_match("/^[A-Za-z\\- \']+$/",Input::get('lname') ) || strlen(Input::get('lname'))   > 20) {
          $reg_response=  '<p class="error">Sorry, Your last name is not accepted !!.</p>';
       }   elseif (!filter_var(Input::get('email'), FILTER_VALIDATE_EMAIL)){
	     	$reg_response = '<p class="error">Email is not valid</p>';
	   } elseif( strlen(Input::get('password'))   <= 5){
            $reg_response = '<p class="error">Password must be at least 6 characters long!!</p>';
	   } else {
			//$token=bin2hex(openssl_random_pseudo_bytes(30));
		    $check_mail_response =User::getInstance()->find('email',Input::get('email'));
       
			if (empty($check_mail_response)) {
			        $Mailchimp = new Mailchimp( $api_key );
                    $Mailchimp_Lists = new Mailchimp_Lists( $Mailchimp );
			    
			        $data = User::getInstance()->create([
						  'first_name'=>Input::get('fname'),
						  'last_name'=>Input::get('lname'),
						  'email'=>Input::get('email'),
						  'is_verified'=>true,
						  'password'=>sha1($_SESSION['password']),
					 ]);
					 
					 try 
                        {
                            $subscriber = $Mailchimp_Lists->subscribe(
                                $list_id,
                                array('email' => Input::get('email')),      // Specify the e-mail address you want to add to the list.
                                array('FNAME' => Input::get('fname'), 'LNAME' => Input::get('lname')),   // Set the first name and last name for the new subscriber.
                                'text',    // Specify the e-mail message type: 'html' or 'text'
                                FALSE,     // Set double opt-in: If this is set to TRUE, the user receives a message to confirm they want to be added to the list.
                                TRUE       // Set update_existing: If this is set to TRUE, existing subscribers are updated in the list. If this is set to FALSE, trying to add an existing subscriber causes an error.
                            );
                        } 
                        catch (Exception $e) 
                        {
							
                        }
                        
                        
					 
					 
					 
					  //Log any user who registers 
                      $last_insert_id = mysqli_insert_id($GLOBALS['dbc']);
                      
                      $response = LogSecurity::getInstance()->request();
					  LogSecurity::getInstance()->create([
                         'user_id'=>$last_insert_id, 
		                 'ip'=>$response['ip'],
		                 'city'=>$response['city'] , 
		                 'region'=>$response['region'], 
		                 'region_code'=>$response['region_code'], 
		                 'country_name'=>$response['country_name'], 
		                 'country_code'=>$response['country_code'], 
		                 'continent_name'=>$response['continent_name'], 
		                 'continent_code'=>$response['continent_code'], 
		                 'latitude'=>$response['latitude'], 
		                 'longitude'=>$response['longitude'], 
		                 'organisation'=>$response['organisation'], 
		                 'postal'=>$response['postal'], 
		                 'currency'=>$response['currency'],  
		                 'currency_symbol'=>$response['currency_symbol'], 
		                 'calling_code'=>$response['calling_code'], 
		                 'flag'=>$response['flag'], 
		                 'emoji_flag'=>$response['emoji_flag'], 
		                ' time_zone'=>$response['time_zone'],
                        'user_agent'=>$_SERVER ['HTTP_USER_AGENT'],
					  ]);

                    $_SESSION['verify_email'] =Input::get('email');

                if ($data) {
                	
            	   	    //Auto log in
            	      $user = array(
				       'id' => $last_insert_id,
				       'logged_in' => true
			         );
			        setcookie('user', json_encode($user), time() + 3600, '/'); //cookie 
						$reg_response = '<p class="pass">Your new account have been sucessfully created </p>';
						$display_form = false;
						$first_name=Input::get('fname');
						//send verification email
						$mail = new PHPMailer;
                	   require_once('modules/signup_mail.php');
						$to = Input::get('email');
						$mail->isSMTP();
						$mail->Host = 'smtp.zoho.com';
						$mail->Port = 465;
						$mail->SMTPAuth = true;
					    $mail->Username = '@com';
					    $mail->Password = 'Oriyomi_88'; 
						$mail->SMTPSecure = 'ssl';
						$mail->From = '@.com';
						$mail->FromName = 'Autofactorng Team';
						$mail->addAddress(Input::get('email'), 'Autofactor');
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
						    
						    Redirect::to('index');
						    
						} else {
							$reg_response = '<p class="error">We cannot create an account at this time please try again later.</p>';
						}
				}//insert	
			} else {
				$reg_response = '<p class="error">An account already exists with this email address. Please use a different one.</p>';
			}
		}
	} 
?>
<div id="signup_wrapp">
<div id="signup_header">
<a href="https://autofactorng.com" alt="LINK: HOME" title="<< Go back to homepage"><img src="/images/afng_logo.png"></a>
</div>
<h3 style="color: #777;">Account Registration</h3>
<p>Let's get you started</p>
<hr />
<h4 id="reg_response"><?= $reg_response; ?></h4>
<?php
	if ($display_form) { ?>
		<form method="POST" action="">
			 <input type="hidden" name="token" value="<?php echo  $_SESSION['token'] ?>" />
			  <input type="hidden" name="secret" value="6LfNv0cUAAAAAPsOGLWHxAuzbPSZTVcvp1t7u6Se" />
		<p>
			<label for="fname">First Name</label><br />
			<input type="text" name="fname" value="<?php echo Input::get('fname') ?>" id="fname" placeholder="First name" required="required" />
		</p>
		<p>
			<label for="lname">Last Name</label><br />
			<input type="text" name="lname" value="<?php echo Input::get('lname') ?>" id="lname" placeholder="Last name" required="required" />
		</p>
		<!-- <p>
			<label for="uname">Username</label><br />
			<input type="text" name="uname" value="<?php echo Input::get('uname') ?>" id="uname" placeholder="Username" required="required" />
		</p> -->
		<p>
			<label for="email">Email</label><br />
			<input type="email" name="email" value="<?php echo Input::get('email') ?>" id="email" placeholder="Email address" required="required" />
		</p>
		<p>
			<label for="pword1">Password</label><br />
			<input type="password" name="password" id="pword1" placeholder="Enter password" required="required" />
		</p>
		
	
      <br/>
          <div class="g-recaptcha" data-sitekey="6LfNv0cUAAAAAM0vAsdIOvKQdcUVAC7kqTlr4GrU"></div>

		<!-- <p>
			<label for="pword2">Re-type password</label><br />
			<input type="password" name="pword2" id="pword2" placeholder="Re-type password" required="required" />
		</p> -->
		
		
		<p>
			<input type="submit" name="signup" value="Continue" />
		</p>
	</form>
<?php } ?>
</div>

 <script type="text/javascript">
      var verifyCallback = function(response) {
        alert(response);
      };
     
    </script>

</body>
</html>