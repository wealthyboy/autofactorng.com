<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<!--<meta http-equiv="X-UA-Compatible" content="IE=edge">-->
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	
	<title>Autofactorng || <?php echo $page_title; ?></title>


	<link rel="shortcut icon" href="/images/favicon.ico" type="image/ico">
	<link rel="stylesheet" type="text/css" href="/css/font.css">
	<link rel="stylesheet" type="text/css" href="/css/unslider.css">
	<link rel="stylesheet" type="text/css" href="/css/unslider-dots.css">
	<link rel="stylesheet" type="text/css" href="/css/smoothproducts.css">
	<link rel="stylesheet" type="text/css" href="/css/jquery.sweet-dropdown.min.css">
	<link rel="stylesheet" type="text/css" href="/css/jquery-ui.min.css">
	<link rel="stylesheet" type="text/css" href="/css/glyphs.css">
	<link rel="stylesheet" type="text/css" href="/css/font-awesome.css">
	<link rel="stylesheet" type="text/css" href="/css/slick.css">
	 <!-- Bootstrap 3.3.6 -->
    
	<link rel="stylesheet" type="text/css" href="/css/node.min.css">
	<link rel="stylesheet" type="text/css" href="/css/style.css?<?php echo time(); ?>">
	<link rel="stylesheet" type="text/css" href="/css/respond.css?<?php echo time(); ?>">
	<script src='https://kit.fontawesome.com/a076d05399.js'></script>


	<!-- Facebook Pixel Code -->
	<script>
	!function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?
	n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;
	n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;
	t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,
	document,'script','https://connect.facebook.net/en_US/fbevents.js');

	fbq('init', '1821180714781438');
	fbq('track', "PageView");
	fbq('track', 'ViewContent');
	fbq('track', 'Search');
	fbq('track', 'AddToCart');
	fbq('track', 'AddToWishlist');
	fbq('track', 'InitiateCheckout');
	fbq('track', 'AddPaymentInfo');
	fbq('track', 'Purchase', {value: '1.00', currency: 'USD'});
	fbq('track', 'Lead');
	fbq('track', 'CompleteRegistration');
	fbq('track', 'AggregateCustomConversion');</script>
	<noscript><img height="1" width="1" style="display:none"
	src="https://www.facebook.com/tr?id=1821180714781438&ev=PageView&noscript=1"
	/></noscript>
	<!-- End Facebook Pixel Code -->
</head>
<body>
<?php
require_once('config.php');
require_once('functions/login.php');
require_once('functions/db_table_events.php');
require_once $_SERVER["DOCUMENT_ROOT"].'/init/autoload.php';
require_once $_SERVER["DOCUMENT_ROOT"].'/init/init.php';




//remove Expired product deals
//Deals::RemoveExpiredProductDeals();
$banner =  new Banner();
$year   =  new Year();
//$cart = json_decode($_COOKIE['cart'], true);
//$num_prod_in_cart = count($cart);
//$total = 0;
?>
<div id="wrapp">
	<div id="header">
		<div id="top_header_wrapp">
			<div id="cart_wrapp">
				<button data-dropdown="#cart" class="btn btn-danger">
					<span>
						<span id="cart_icon"><img src="/images/empty_cart.png" /></span>
						Cart: <span id="prod_count">0</span>
					</span>
				</button>
				<div class="dropdown-menu dropdown-anchor-top-center dropdown-has-anchor" id="cart">
					<div id="cart_dropdown"></div>
				</div>
			</div>
			<div 
			    class="<?php  echo  isLoggedIn() ? 'mb-60' : "" ?>" 
			    id="header_logo_wrapp">
				<a href="/"><img src="/images/afng_logo.png"></a>
			</div>
			<div id="header_login_wrapp">
				<?php
				if (isLoggedIn()) { 
				  $user = json_decode($_COOKIE['user'], true);
				 $wallet =  Wallet::where('user_id',$user['id'])->first();

				?>
					<button data-dropdown="#header_login" class="btn btn-danger"><span>Your Account</span></button>
					
				<div  class="wallet text-center">
				     <div  class="wallet-content">
				         <span id="cart_icon"><i class='fas fa-wallet'></i>
</span>
           <div  class="wallet-content-text">
            <span class="wallet-text">Wallet: </span> <span class="badge" id=""><?php 
				     echo number_format($wallet->amount);
				?></span>
            </div>
				      </div>
				
				
				</div>
    					
				<?php }
				else { ?>
					<button data-dropdown="#header_login" class="btn  btn-danger login_btn_t"><span>LOG IN</span></button>
				<?php	} 
				?>
				<div class="dropdown-menu dropdown-anchor-top-center dropdown-has-anchor" id="header_login">
					<div id="login_dropdown">
					<span title="close" class="close_dropdown"><i class="fa fa-times-circle"></i> close</span>
						<form id="login_form">
							<p id="login_status"></p>
				<?php
						if (!isLoggedIn()) { ?>
							<p>
								<label for="uname">Username</label>
								<input type="text" name="uname" id="uname" placeholder="Enter your email" required="required" />
							</p>
							<p>
								<label for="pword">Password</label>
								<input type="password" name="pword" id="pword" placeholder="Enter your password" required="required" />
							</p>
							<span class="forgot_password align_right"><a href="/account/begin_password_reset.php">forgot password?</a></span>
							<input type="hidden" name="page-ref" value="<?php echo $_SERVER['PHP_SELF']; ?>" />
							<p class="align_right">
								<input type="submit" name="login" value="Log In" id="login_button" />
							</p>
							<p id="login_footer">
								Don't have an account? <a href="/signup.php">Sign up >> </a>
							</p>
							<br /><br /><hr />
							<?php
						}
								if (isLoggedIn()) { ?>
									<p class="links"><i class="fa fa-arrow-right"></i><a href="/profile"> View &amp; update your Shipping address/details</a></p>
									<p class="links"><i class="fa fa-arrow-right"></i><a href="/profile"> View your Order History</a></p>
										<p class="links"><i class="fa fa-arrow-right"></i><a href="/add_funds"> Add funds to your wallet</a></p>
							<?php
								}
							?>
								<br /><br />
								<h4 style="color: #999;" class="center">Track your order</h4>
								<hr />
								<form id="dropdown_track_order_form">
									<p class="track_order_msg_output error"></p>
									<p>
										<label for="order_number">Your tracking number</label>
										<input type="text" name="order-number" required="required" id="order_number">
									</p>
									<p>
										<label for="track_email">Your email</label>
										<input type="text" name="email" value="" id="track_email">
									</p>
									<p>
										<button style="width: 100%;" required="required" id="track_order_button">Track</button>
									</p>
							<?php
								if (isLoggedIn()) { ?>
									<br /><br /><hr />
									<p><button style="width: 100%; background-color: red;" id="logout_button"><span>LOG OUT</span></button></p>
							<?php } ?>
								</form>
							<!-- </p> -->
						</form>
					</div>
				</div>
			</div>
			<div id="search_box">
			<form method="get" action="/search_result.php">
                 <input id="search_bar" required="required"  name="term" type="text" placeholder="search keyword e.g toyota brake pad front 2010 camry" />
				<button type="submit"  id="search_button" class=" <?php  echo  isLoggedIn() ? 'top-245' : "" ?>  search_button">GO</button> 
			</div>
		  </form>
		</div>
		<div id="ribbon">
			<div id="left">
				<span>CALL TO ORDER +234 (0) 908 1155 505</span>
			</div>
			<div id="right">
				<span>WE SELL 100% GENUINE, WE SELL CONFIDENCE</span>
			</div>
		</div>
		<div id="nav_bar">
			<ul>
			<?php
				$cat_data = mysqli_query($GLOBALS['dbc'], "SELECT * FROM product_cats ORDER BY cat_id ASC LiMIT 8");
				if (mysqli_num_rows($cat_data)) {
					while($row = mysqli_fetch_assoc($cat_data)) {
						$cur_cat_id = $row['cat_id'];
						if ($cur_cat_id != 9) {
							if ($cur_cat_id == 8) { ?>
								<li><span><a href="/all/<?= $row['slug'];  ?>"><?= $row['name']; ?></a></span></li>
				<?php
							} else { ?>
									<li><span><?= $row['name']; ?></span>
										<ul style="z-index: 11;">
				<?php
										$subcat_data = mysqli_query($GLOBALS['dbc'], "SELECT * FROM product_sub_cats WHERE cat_id = $cur_cat_id ORDER BY sub_cat_id ASC");	
										if (mysqli_num_rows($subcat_data)) {
											while($row2 = mysqli_fetch_assoc($subcat_data)) { ?>
												<li>
												    <a href="/<?= $row['slug']; ?>/<?= $row2['slug']; ?>">
												        <span>
												            <?= $row2['name']; ?>
												            </span></a>
											</li>
				<?php
											}
										}		
		    ?>     
						      	</ul>
					      	</li>
      	<?php
      				}
      			}
					}
				}
				?>
				<!--<li><span><a href="maintenance.php">Maintenance</a></span></li>-->
				<li style="position: relative; border-bottom: 3px solid red;"><span><a href="/deals/CyberSale">Deals</a></span> <img class="new_sticker" src="/images/new.png"></li>
			</ul>
		</div>
	</div>
	<div id="body_wrapp">
		<div id="nav_menu">
			<div id="nav_menu_toggle"><i class="fa fa-bars"></i> MENU</div>
			<div id="nav_menu_list">
				<ul class="main_list">
				<?php
					$cat_data = mysqli_query($GLOBALS['dbc'], "SELECT * FROM product_cats ORDER BY cat_id ASC LIMIT 8");
					if (mysqli_num_rows($cat_data)) {
					while($row = mysqli_fetch_assoc($cat_data)) {
						$cur_cat_id = $row['cat_id'];
						// dont display service pack category link
						if ($cur_cat_id != 9) {
							if ($cur_cat_id == 8) { ?>
								<li><span><a href="/all/<?= $row['slug']; ?>"><?= $row['name']; ?></a></span></li>
				<?php
							} else { ?>
									<li><span><?= $row['name']; ?></span></li>
										<ul class="sub_list">
				<?php
										$subcat_data = mysqli_query($GLOBALS['dbc'], "SELECT * FROM product_sub_cats WHERE cat_id = $cur_cat_id ORDER BY sub_cat_id ASC");	
										if (mysqli_num_rows($subcat_data)) {
											while($row2 = mysqli_fetch_assoc($subcat_data)) { ?>
												<li>
												     <a href="/<?= $row['slug']; ?>/<?= $row2['slug']; ?>">
												        
												        <span><?= $row2['name']; ?></span></a></li>
				<?php
											}
										}		
		    ?>     
						      	</ul>
      	<?php
      				}
      			}
					}
				}
				?>
			   	<!--<li><a href="maintenance.php"><span>Maintenance</span></a></li>-->
			   	<li style="position: relative;"><a href="/deals/CyberSale"><span>Deals</span></a><img class="new_sticker" src="stage.autofactorng.com/images/new.png"></li>
				</ul>
			</div>
		</div>