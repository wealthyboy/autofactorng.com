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
       }  elseif (!filter_var(Input::get('email'), FILTER_VALIDATE_EMAIL)){
	     	$reg_response = '<p class="error">Email is not valid</p>';
	   } elseif( strlen(Input::get('phone_number'))   < 0){
            $reg_response = '<p class="error">Enter a phone number </p>';
	   } else {
			//$token=bin2hex(openssl_random_pseudo_bytes(30));
		    $check_mail_response =Marketers::getInstance()->find('email',Input::get('email'));
       
			if (empty($check_mail_response)) {
			     $data = Marketers::getInstance()->create([
						  'first_name'=>Input::get('fname'),
						  'last_name'=>Input::get('lname'),
						  'email'=>Input::get('email'),
						  'phone_number'=>Input::get('phone_number'),
						  'location'=>Input::get('location'),
						  'state'=>Input::get('location'),
						  'referral'=>Input::get('referral'),
					 ]);
					  //Log any user who registers 
                      $last_insert_id = mysqli_insert_id($GLOBALS['dbc']);
                     

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
					    $mail->Username = 'welcome@autofactorng.com';
					    $mail->Password = 'Oriyomi_88'; 
						$mail->SMTPSecure = 'ssl';
						$mail->From = 'welcome@autofactorng.com';
						$mail->FromName = 'Autofactorng Team';
						$mail->addAddress('mobolaji.a@autofactorng.com', 'Autofactor');
						
						$mail->isHTML(true);
						$mail->Subject = 'New marketer registration';
						$mail->Body = "We have a new marketer";
						
						if ($mail->send() ){
						    $_SESSION['token'] = null;
						    session_regenerate_id();
						    
                         $reg_response = '<p class="">Registration Successful
                         
                          <p>Give us a moment to review your account</p>
                         </p>';
						    
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
<h3 style="color: #777;">Registration</h3>
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
			<p>
			<label for="phone_number">Phone number</label><br />
			<input type="text" name="phone_number" value="<?php echo Input::get('phone_number') ?>" id="phone_number" placeholder="Phone Number" required="required" />
		</p>
		
		<p>
			<label for="email">Email</label><br />
			<input type="email" name="email" value="<?php echo Input::get('email') ?>" id="email" placeholder="Email address" required="required" />
		</p>
		
		<p>
			<label for="location">Location</label><br />
			<input type="text" name="location" value="<?php echo Input::get('location') ?>" id="location" placeholder="Location" required="required" />
		</p>
		
		<p>
		    <label for="referral">How did you hear about the refer and earn program:
</label><br />

		    <select name="referral" id="referral" class="browser-default custom-select custom-select-lg mb-3">
		      <option value="" selected>Choose One</option>

              <option value="Social Media">Social Media </option>
              <option value="Referral">Referral</option>
              <option value="Website">On AutoFactor website</option>
              <option value="newsletter">Email newsletter</option>
            </select>
		</p>
		
      <br/>
          <div class="g-recaptcha" data-sitekey="6LfNv0cUAAAAAM0vAsdIOvKQdcUVAC7kqTlr4GrU"></div>
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