<?php

//error_reporting(E_ALL);
//ini_set('display_errors', 'On');
	require_once('classes/class.db.php');
	$page_title = 'Home';
	require_once('includes/header.php');
?>
		<div id="car_filter_wrapp">
			<form method="GET" action="car_search.php">
			<p>
				<label for="year">Year</label>
				<select id="year" name="year">
					<option value="">Select Year</option>
					<?php require('modules/year_select'); ?>
				</select>
			</p>

			<p>
				<label for="make">Make</label>
				<select id="make" name="make">
					<option>Select Make</option>
				</select>
			</p>
			
			<p>
				<label for="model">Model</label>
				<select id="model" name="model">
					<option>Select Model</option>
				</select>
			</p>

			<p>
				<input id="filter_car" type="submit" name="submit" value="SEARCH" />
			</p>
			</form>
		</div><!--car_filter_wrapp-->
		<div id="article">
			<div class="article_tiles">
				<span>Need a Technician?</span>
				<img src="images/mechanic.png" />
				<a href="call_technician.php"><button><i class="glyphicon glyphicon-earphone"></i> Call Now </button></a>
			</div>
			<div class="article_tiles">
				<!--<span>Service Pack</span>-->
				<a href="products.php?cat_id=9"><img src="images/service_pack.png" /></a>
				<!--Text Goes Here-->
			</div>
			<div class="article_tiles">
				<!--<span>Service Pack</span>-->
				<a href="tow_truck.php"><img src="images/tow_truck_s.jpg" /></a>
				<!--Text Goes Here-->
			</div>
			<div class="article_tiles">
				<span style="color: #F44C25;">New Arrivals</span>
				<a href="products.php?cat_id=1&sub_cat_id=10"><img src="images/products/complete_shaft.png" /></a>
				<span style="color: #363636;">Complete Shaft Assembly</span>
			</div>
			<div class="article_tiles">
				<span style="color: #F44C25;">New Arrivals</span>
				<a href="products.php?cat_id=1&sub_cat_id=11"><img src="images/products/wheel_hub.jpg" /></a>
				<span style="color: #363636;">Wheel Hub</span>
			</div>
		</div>
		<div id="main">
			<div id="banner_box">
				<div class="banner">
				
					<ul>
					<?php foreach ($banner->all() as $details):?>
					  <li><a href="<?= $details->link?>"><img src="images/banner/<?= $details->image;?>" /></a></li>
					<?php endforeach;?>	
					</ul>
				</div>
			</div><!--banner_box-->
			<form id="car_filter_wrapp2" action="car_search.php">
			<select id="year2" name="year">
				<option value="">Year</option>
				<?php require('modules/year_select'); ?>
			</select>
			<select id="make2" name="make">
				<option>Make</option>
			</select>
			<select id="model2" name="model">
				<option>Model</option>
			</select>
			<button name="submit" id="filter_car2" type="submit"><i class="fa fa-search"></i></button>
		</form><!--car_filter_wrapp-->
			<div id="content">
				<h3 id="top_seller_header">Top Sellers</h3>
				<div class="topseller_prod">
					<div class="topseller_prod_image">
							<a href="products.php?cat_id=1&sub_cat_id=3"><img src="images/products/brake_pad.jpg" /></a>
					</div>
					<div class="topseller_prod_capt">
							<span>Brake Pads</span>
					</div>
				</div>
				<div class="topseller_prod">
					<div class="topseller_prod_image">
							<a href="products.php?cat_id=1&sub_cat_id=11"><img src="images/products/shocks.png" /></a>
					</div>
					<div class="topseller_prod_capt">
							<span>Shocks</span>
					</div>
				</div>
				<div class="topseller_prod">
					<div class="topseller_prod_image">
							<a href="products.php?cat_id=1&sub_cat_id=11"><img src="images/products/Spark Plugs.jpg" /></a>
					</div>
					<div class="topseller_prod_capt">
							<span>Spark Plugs</span>
					</div>
				</div>
				<div class="topseller_prod">
					<div class="topseller_prod_image">
							<a href="products.php?cat_id=1&sub_cat_id=3"><img src="images/products/brake_disk_f.jpg" /></a>
					</div>
					<div class="topseller_prod_capt">
							<span>Brake Discs</span>
					</div>
				</div>
				<div class="topseller_prod">
					<div class="topseller_prod_image">
							<a href="products.php?cat_id=1&sub_cat_id=11"><img src="images/products/Mobil1 Engine Oil.jpg" /></a>
					</div>
					<div class="topseller_prod_capt">
							<span>MOBIL 1 ( Advanced Synthetic Motor Oil) </span>
					</div>
				</div>
				<div class="topseller_prod">
					<div class="topseller_prod_image">
							<a href="products.php?cat_id=2&sub_cat_id=14"><img src="images/products/toyota_and_Lexus_oil_filter_for_most_brand_off_toyota,_except_corrolla,_camry,_avensis,_avalon_2007_upeards.jpg" /></a>
					</div>
					<div class="topseller_prod_capt">
							<span>Oil Filters</span>
					</div>
				</div>
				<div class="topseller_prod">
					<div class="topseller_prod_image">
							<a href="products.php?cat_id=8"><img src="images/products/diamond_battery.jpg" /></a>
					</div>
					<div class="topseller_prod_capt">
							<span>Diamond 75AH Battery</span>
					</div>
				</div>
				<div class="topseller_prod">
					<div class="topseller_prod_image">
							<a href="products.php?cat_id=7&sub_cat_id=45"><img src="images/products/Car Dashboard DVD System.jpg" /></a>
					</div>
					<div class="topseller_prod_capt">
							<span> Car Dashboard DVD System</span>
					</div>
				</div>
				<div class="topseller_prod">
					<div class="topseller_prod_image">
							<a href="products.php?cat_id=6&sub_cat_id=24"><img src="images/products/IMG_0478.JPG" /></a>
					</div>
					<div class="topseller_prod_capt">
							<span>Tyres</span>
					</div>
				</div>
			</div><!--content-->
			<div class="clearfix"></div>
			<div id="other">
				<div id="service_pack">
					<a href="products.php?cat_id=9"><img src="images/service_pack.png"></a>
				</div>
				<div id="delivery_info">
					<p>
						<span>NATIONWIDE DELIVERY AVAILABLE</span>
						<img src="images/truck_time.png">
					</p>
					<p>
						<span>PAY ON DELIVERY AVAILABLE LAGOS ONLY</span>
						<img src="images/cash_hand.png">
					</p>
					<p>
						<span>FREE RETURNS T &amp; C APPLY</span>
						<img src="images/returnIcon.png">
					</p>
				</div>
				<div id="newsletter_wrapp">
					<p>
						<img src="images/envelope.png">
						GET FANTASTIC DEAL <br /> 
						<span>Sign Up to get fresh updates
						</span>
					</p>
					<div id="newsletter_form_wrapp">
						<form action="//autofactorng.us12.list-manage.com/subscribe/post?u=997069fcccc2a07c01d0a7dd1&amp;id=a07acc0523" method="post" target="_blank" novalidate>
							<input type="text" name="EMAIL" placeholder="email address" /><input type="submit" name="sub-to-newsletter" value="GO" />
						</form>
					</div>
				</div>
				<div class="clearfix"></div>
				<?php require('modules/about'); ?>
			</div><!--other-->
			<div id="other2">
				<div class="banner">
					<ul>
						<li>
							<div id="service_pack">
								<a href="products.php?cat_id=9"><img src="images/service_pack.png"></a>
							</div>
						</li>
						<li>
							<div id="tow_truck">
								<a href="tow_truck.php"><img src="images/tow_truck_s.jpg" /></a>
							</div>
						</li>
						<li>
							<div id="newsletter_wrapp">
								<p>
									<img src="images/envelope.png">
									GET FANTASTIC DEAL <br /> 
									<span>Sign Up to get fresh updates
									</span>
								</p>
								<div id="newsletter_form_wrapp">
									<form action="//autofactorng.us12.list-manage.com/subscribe/post?u=997069fcccc2a07c01d0a7dd1&amp;id=a07acc0523" method="post" target="_blank" novalidate>
										<input type="text" name="EMAIL" placeholder="email address" /><input type="submit" name="sub-to-newsletter" value="GO" />
									</form>
								</div>
							</div>
						</li>
						<li>
							<div id="delivery_info">
								<p>
									<span>NATIONWIDE DELIVERY AVAILABLE</span>
									<img src="images/truck_time.png">
								</p>
								<p>
									<span>PAY ON DELIVERY AVAILABLE LAGOS ONLY</span>
									<img src="images/cash_hand.png">
								</p>
								<p>
									<span>FREE RETURNS T &amp; C APPLY</span>
									<img src="images/returnIcon.png">
								</p>
							</div>
						</li>
					</ul>
				</div>
				<?php require('modules/about'); ?>
			</div><!--other2-->
		</div><!--main-->
<?php
	require_once('includes/footer.php');
?>