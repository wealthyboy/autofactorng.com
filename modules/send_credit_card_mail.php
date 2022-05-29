<?php
require 'phpmailer/PHPMailerAutoload.php';

$u = new User();
$user = $u->get_by_id($user_id);

$mail = new PHPMailer;

$mail->isSMTP();
$mail->Host = 'smtp.zoho.com';
$mail->Port = 465;
$mail->SMTPAuth = true;
$mail->Username = 'orders@autofactorng.com';
$mail->Password = 'autofactorng080816';
$mail->SMTPSecure = 'ssl';

$mail->From = 'orders@autofactorng.com';
$mail->FromName = 'Autofactorng Team';
$mail->addAddress($user->get('email'), $user->get('username'));
$mail->AddCC('orders@autofactorng.com', 'Order');

//$mail->addReplyTo('orders@autofactorng.com', 'Orders');

$mail->WordWrap = 50;
$mail->isHTML(true);

$mail->Subject = 'Thanks For Ordering';

$product_list = $_SESSION['product_list'];
$bodyc = "<h1 style= 'text-align: center ; color: #D43A16;'> Your order for </h1>";
$bodyc .= "<p style= 'text-align: center;'> the following product(s) $product_list </p>";
$bodyc .= "<h1 style= 'text-align: center ; color: #D43A16;'> has been received </p>";
$bodyc .= "<h3 style= 'text-align: center ;'> Your Tracking Number is: <span style='color: #D43A16;'> $tracking_number_string </span></h3>";
$bodyc.= "<!-- START FOOTER -->



<div style= 'text-align: center; background: #363636; min-height: 200px'>
<div style= 'min-height: 15px'> </div>
<div style= 'text-align: center; color: #f7f7f7; margin: 50px auto 12px; outline: none'> info@autofactorng.com </div>
<div style= 'text-align: center; color: #f7f7f7; margin: 12px auto;'> +234 (0) 908 1155 505 </div>

<a href='https://www.facebook.com/autofactorng' target='_blank'> <img src='https://cdn3.iconfinder.com/data/icons/free-social-icons/67/facebook_circle_gray-48.png'> </a>

<a href='https://twitter.com/autofactorng' target='_blank'> <img src='https://cdn3.iconfinder.com/data/icons/free-social-icons/67/twitter_circle_gray-48.png'> </a>

<a href='http://instagram.com/autofactorng/'> <img src='https://cdn3.iconfinder.com/data/icons/free-social-icons/67/instagram_circle_gray-48.png'> </a>

<div style= 'min-height: 20px'> </div>
</div>

<!-- END FOOTER -->";

// $mail->Body    = "<p style= 'background: #ccc;'> Your order for the following product(s) ". $items."  has been successfully placed</p>";

$mail->Body = "$bodyc";

$mail->send();

?>