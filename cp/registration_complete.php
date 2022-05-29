<?php  session_start(); 
   require_once $_SERVER["DOCUMENT_ROOT"].'/init/autoload.php'; 
      
?>


<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Autofactorng || Verification Complete</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<script type="text/javascript" src="js/jquery.js"></script>
</head>
<body>
	<?php  $verify_email = $_SESSION['verify_email']?>
  <div id="signup_wrapp">
	    <div id="signup_header">
			    <a href="http://autofactorng.com" alt="LINK: HOME" title="<< Go back to homepage"><img src="images/afng_logo.png"></a>
			    </div>
			     <h3 style="color: #777;">Account Registration</h3>
			   <hr />
		   <h3 style="color: #777;"><p class="pass">Your new account has been sucessfully created. One more step, please verify your email .An email has been to <?php echo $verify_email  ?></p></h3>
	   <hr />
   <h4 id="reg_response">Verification Complete <a href="index.php">Continue Shopping</a></h4>
	          
 </div>
</body>
</html>
	  
	  