<?php
	session_start();
// 	error_reporting(E_ALL);
//     ini_set('display_errors', 1);
	require_once $_SERVER["DOCUMENT_ROOT"].'/init/init.php';


	require_once('classes/class.db.php');
	require_once('classes/class.coupon.php');
	require_once('config.php');
	require_once('functions/login.php');
	$currency = CURRENCY;
	$cart = json_decode($_COOKIE['cart'], true);
	$num_prod_in_cart = count($cart);
	
	$source = $_GET['source'];
	$total = $discounted_total = $shipping = 0;
	$u = null;

	if (isLoggedIn()) {
	    //Refactor code use sessions
		$user = json_decode($_COOKIE['user'], true);
		$user_id = $user['id'];
		$data = mysqli_query($GLOBALS['dbc'], "SELECT users.email AS user_email, state.name AS state_name FROM users INNER JOIN state 
			ON (users.state_id = state.id) WHERE users.id = $user_id");

		$row = mysqli_fetch_array($data);
		$user_state = $row['state_name'];
		$user_email = $row['user_email'];
		
		$userr = User::find($user_id);
		$u = null !== $userr  ? $userr->fund() : null;
		$shipn_price = Shipping::where('state_id',$userr->state_id)->first();
	
	}
    $the_cart  ='';
    $coupon_verified ='';
    $coupon_applied  ='';
    $coupon_success_msg ='';
	if (!empty($source)) {
		if ($source == 'cart_dropdown') {
				$the_cart = <<<EOT
				<p class="center" id="cart_dropdown_header">
					Your shopping cart
				</p>
				<span title="close" class="close_dropdown"><i class="fa fa-times-circle"></i> close</span>
EOT;

				//echo 'CART SIZE: ' .$num_prod_in_cart;

				if ($num_prod_in_cart == 0) {
					$the_cart .= <<<EOT
						<p align="center">
							Cart is empty
						</p>
EOT;
				}

				else {
					for ($i = 0; $i < $num_prod_in_cart; $i++) {
						$prod_qty   = $cart[$i]['0']['value'];
						$prod_name  = $cart[$i]['3']['value'];
						$prod_price = $cart[$i]['4']['value'];
						$prod_image = $cart[$i]['5']['value'];
						$cur_sum 		= $prod_qty * $prod_price;
              
						$the_cart .= <<<EOT
						<p class="cart_dropdown_product">
							<img src="/images/products/$prod_image">
							<span class="cart_dropdown_prod_name">
								<span>$prod_name</span>
								<span class="quantity">Qty: $prod_qty</span>
								<span class="price">$currency $cur_sum</span>
							</span>
							<span class="cart_dropdown_prod_pop"><i class="glyphicon glyphicon-remove" title="Remove product"></i></span>
						</p>
EOT;
						$total += $cur_sum;
					}
					$the_cart .= <<<EOT
					<p id="cart_dropdown_footer">
						<span class="price">Total: $currency $total</span>
						<a href="/checkout.php"><button class="to_checkout">Proceed to Checkout</button></a>
					</p>
EOT;
				}

				echo $the_cart;
		}

		elseif ($source == 'checkout_cart') {
			if ($num_prod_in_cart == 0) {
			$the_cart = <<<EOT
				<p id="empty_cart">
					Shopping Cart Empty
					<span>Shop More</span>
				</p>
EOT;
			}

			else {
				$shock_count = 0;
				$windshield_present = false;
				$heavy_product_present = false;
				$heavy_products = array('Brake Disc Front',
															  'Brake Disc Rear', 
															  'Caliper And Kit',
															  'Front Bumper', 
															  'Rear Bumper', 
															  'Hood/Bonnet', 
															  'Trunk/Boot'); //+batteries, tyres, grille guards
				//Add all products under respective categories to heavy_products
				//$query = "SELECT name FROM product_sub_cats WHERE cat_id = 5 AND cat_id = 6 AND cat_id = 8"

				if (isset($_SESSION['coupon_code'])) {
					
					$coupon_code = $_SESSION['coupon_code'];
					$c = new Coupon();
					$coupon = $c->get_by_code($coupon_code);
					
					$coupon_applied = false;
					//echo 'Coupon POST is set';
				

					// Applying Coupon
					if($coupon && $coupon->is_valid()) {
						if(!isLoggedIn()) {
							$coupon_error_msg = "Please login to apply your coupon";
						} 

						else if($coupon->is_valid_for($user_id)){
							$coupon_verified = true;
							$_SESSION['valid_coupon_code'] = $coupon_code;
						}

						else {
							$coupon_error_msg = "Coupon already used by you";
						}

					} 

					else {
						$coupon_error_msg = "Invalid Coupon";
					}
				}

				$prod_list = "<ul>";

				$paystack_product_list = '';  //Used to generate list of products for the paystack meta key
				$paystack_attr_index = 0; //for product hidden field names 
				//array to hold all tables to check for count apearance of tables
				$table_count=[];
				for ($i = 0; $i < $num_prod_in_cart; $i++) {
					$prod_qty   = $cart[$i]['0']['value'];
					$prod_name  = $cart[$i]['3']['value'];
					$prod_price = $prod_qty * $cart[$i]['4']['value'];
					$prod_image = $cart[$i]['5']['value'];
					$prod_tbl   = $cart[$i]['2']['value'];
					$table_count[]=$prod_tbl;
					$prod_cat   = '';

					switch ($prod_tbl) {
						case 'spare_parts':
							$prod_cat   = 'Spare Parts';
							break;

						case 'servicing_parts':
							$prod_cat   = 'Servicing Parts';
							break;
  
						case 'accessories':
							$prod_cat   = 'Accessories';
							break;

						case 'car_care':
							$prod_cat   = 'Car Care, Gadgets/Tools';
							break;

						case 'grille_guards':
							$prod_cat   = 'Grille Guards';
							break;

						case 'tyres':
							$prod_cat   = 'Wheels/Tyres';
							break;

						case 'lubricants':
							$prod_cat   = 'Lube/Fluids';
							break;

						case 'batteries':
							$prod_cat   = 'Batteries';
							break;

						case 'cybersale':
							$prod_cat   = 'CyberSale';
							break;
						
						default:
							# code...
							break;
					}

					if ( $prod_cat == 'Spare Parts' && strpos($prod_name, 'Shock') !== false ) {
						$shock_count++;
					}

					if ( preg_match('/Windshield \(/', $prod_name) ) {
						$windshield_present = true;
					}

					//heavy product code here
					if ( !$heavy_product_present && ($prod_cat == 'Batteries' || $prod_cat == 'Wheels/Tyres' || $prod_cat == 'Grille Guards') ) {
						$heavy_product_present = true;
					}

					else if ($prod_cat == 'Spare Parts') {
						for ($j = 0; $j < count($heavy_products); $j++) {
							if ( !$heavy_product_present && (strpos($prod_name, $heavy_products[$j]) !== false) ) {
								$heavy_product_present = true;
							}
						}
					}

					$cur_sum 		= $prod_price;
					$item_price = sprintf("%01.2f", $cur_sum);

					$the_cart .= "<p class='filled_cart_prod'>";

					if ($coupon_verified && $coupon->get('coupon_type') == "percentage" && $coupon->get('cat_id') > 0) {
						$coupon_value = $coupon->get('coupon_value');
						

						$coupon_deal = $coupon->no_deal($prod_qty, $cart[$i]['4']['value'], $cart[$i]['1']['value'], $prod_tbl);
						if($coupon->belongs_to_product_category($prod_cat) && $coupon_deal) {
							$coupon_applied  	 = true;
							$the_cart					.= "<img src='/images/products/$prod_image' />";
							$the_cart					.=   "<span class='filled_cart_prod_name'>$prod_qty X $prod_name - <em class='coupon_pass'>$coupon_value% coupon applied!</em></span>";
							$the_cart					.= "<span class='filled_cart_prod_price'> $currency " . sprintf("%01.2f", $coupon->get_discount_value($item_price)) . "</span>";

							$paystack_cur_prod_index = 'paystack-product-' . ++$paystack_attr_index;
							$paystack_cur_price_index = 'paystack-price-' . $paystack_attr_index;
							$paystack_cur_price_value = sprintf("%01.2f", $coupon->get_discount_value($item_price));
$paystack_product_list .= "<input type='hidden' name='$paystack_cur_prod_index' value='$prod_qty X $prod_name' />";
$paystack_product_list .= "<input type='hidden' name='$paystack_cur_price_index' value='$paystack_cur_price_value' />";

							$the_cart   			.= " <br/><em>instead of $currency $item_price</em>";
							$coupon_success_msg 		 	 = "Coupon successfully applied";
							$discounted_total += $coupon->get_discount_value($cur_sum); //Add up to discounted_total price

							$prod_list .= "<li>$prod_qty X $prod_name - $currency " . sprintf("%01.2f", $coupon->get_discount_value($item_price)) . " -- <em class='coupon_pass'>$coupon_value% coupon applied!</em></li>";
						}

						else {
							$the_cart .= "<img src='/images/products/$prod_image' />";
							if (!$coupon_deal) {
								$the_cart .= "<span class='filled_cart_prod_name'>$prod_qty X $prod_name - <em class='coupon_error'>coupon not applicable to discounted product</em></span>";
							} else {
								$the_cart .= "<span class='filled_cart_prod_name'>$prod_qty X $prod_name - <em class='coupon_error'>coupon not applicable to this product type</em></span>";
							}
							$the_cart .= "<span class='filled_cart_prod_price'>$currency $item_price</span>";
							$discounted_total += $cur_sum; //Add up to discounted_total price
						}

						$total += $cur_sum;   //Add up to total price

						if (!$coupon_deal) {
							$prod_list .= "<li>$prod_qty X $prod_name - $currency $item_price -- <em class='coupon_error'>coupon not applicable to discounted product</em></li>";
						} elseif (!$coupon->belongs_to_product_category($prod_cat)) {
							$prod_list .= "<li>$prod_qty X $prod_name - $currency $item_price -- <em class='coupon_error'>coupon not applicable to this product type</em></li>";
						}
					} 
					 elseif ($coupon_verified && $coupon->get('coupon_type') == "fixed" && $coupon->get('cat_id') > 0) {
						$coupon_value = $coupon->coupon_value;
						

						$coupon_deal = $coupon->no_deal($prod_qty, $cart[$i]['4']['value'], $cart[$i]['1']['value'], $prod_tbl);
						if($coupon->belongs_to_product_category($prod_cat) && $coupon_deal) {
							$coupon_applied  	 = true;
							$the_cart					.= "<img src='/images/products/$prod_image' />";
							$the_cart					.=   "<span class='filled_cart_prod_name'>$prod_qty X $prod_name </span>";
							$the_cart					.= "<span class='filled_cart_prod_price'> $currency $item_price  </span>";

							$paystack_cur_prod_index = 'paystack-product-' . ++$paystack_attr_index;
							$paystack_cur_price_index = 'paystack-price-' . $paystack_attr_index;
							$paystack_cur_price_value = $item_price;
$paystack_product_list .= "<input type='hidden' name='$paystack_cur_prod_index' value='$prod_qty X $prod_name' />";
$paystack_product_list .= "<input type='hidden' name='$paystack_cur_price_index' value='$paystack_cur_price_value' />";

							$the_cart   			.= " <br/>";
							$coupon_success_msg 		 	 = "Coupon successfully applied";
							$discounted_total += $cur_sum - ($coupon_value /$num_prod_in_cart)  ; //Tempral solution //Add up to discounted_total price
                           
							$prod_list .= "<li>$prod_qty X $prod_name - $currency " . sprintf("%01.2f", $coupon->get_discount_value($item_price)) . " -- <em class='coupon_pass'>$coupon_value% coupon applied!</em></li>";
						}

						else {
							$the_cart .= "<img src='/images/products/$prod_image' />";
							if (!$coupon_deal) {
								$the_cart .= "<span class='filled_cart_prod_name'>$prod_qty X $prod_name - <em class='coupon_error'>coupon not applicable to discounted product</em></span>";
							} else {
								$the_cart .= "<span class='filled_cart_prod_name'>$prod_qty X $prod_name - <em class='coupon_error'>coupon not applicable to this product type</em></span>";
							}
							$the_cart .= "<span class='filled_cart_prod_price'>$currency $item_price</span>";
							$discounted_total += $cur_sum; //Add up to discounted_total price
						}

						$total += $cur_sum;   //Add up to total price

						if (!$coupon_deal) {
							$prod_list .= "<li>$prod_qty X $prod_name - $currency $item_price -- <em class='coupon_error'>coupon not applicable to discounted product</em></li>";
						} elseif (!$coupon->belongs_to_product_category($prod_cat)) {
							$prod_list .= "<li>$prod_qty X $prod_name - $currency $item_price -- <em class='coupon_error'>coupon not applicable to this product type</em></li>";
						}
					 	
					 }

					else {
						$the_cart 				.= "<img src='/images/products/$prod_image' />";
						$the_cart 				.= "<span class='filled_cart_prod_name'>$prod_qty X $prod_name</span>";
						$the_cart 				.= "<span class='filled_cart_prod_price'>$currency $item_price</span>";
 
						$paystack_cur_prod_index = 'paystack-product-' . ++$paystack_attr_index;
						$paystack_cur_price_index = 'paystack-price-' . $paystack_attr_index;
$paystack_product_list .= "<input type='hidden' name='$paystack_cur_prod_index' value='$prod_qty X $prod_name' />";
$paystack_product_list .= "<input type='hidden' name='$paystack_cur_price_index' value='$item_price' />";

						$total 		+= $cur_sum; //Add up to total price
						$discounted_total += $cur_sum; //Add up to total price

						$prod_list .= "<li>$prod_qty X $prod_name - $currency $item_price</li>";
					}

					$the_cart .= "</p>";
				}

				switch ($user_state) {
					case 'Lagos':
						$_SESSION['shipping'] = $shipping = $shipn_price->price;
						break;

					
					default:
						$_SESSION['shipping'] = $shipping = $shipn_price->price;
						break;
				}

				if ($total < 5000 && $user_state != 'Lagos') {
					$_SESSION['shipping'] = $shipping;
				}

				if ($windshield_present) {
					if (isset($_SESSION['install_windshield']) && $_SESSION['install_windshield'] == 'yes') {
						$total += 5000;
						$discounted_total += 5000;
					}
				}

				if (!$windshield_present) {
					unset($_SESSION['install_windshield']);
				}

				$windshield_shipping = 0.00;
				//continue here...
				if ($num_prod_in_cart && $windshield_present ) {
					$_SESSION['w_shipping'] = $windshield_shipping = 1000;//original amount 1000
					$cs = 1888;
					//$discounted_total += $spam2;
				}

				if($coupon_verified && $coupon->get('cat_id') == 0) {
					$discounted_total = $coupon->get_discount_value($total);	//untouched, from old code   
					$grand_total = $discounted_total + $shipping; //grand total with discounted price	//untouched, from old code
					$coupon_applied = true;	//untouched, from old code
					$coupon_success_msg = "Coupon successfully applied";	//untouched, from old code
				} else if($discounted_total) {
					$grand_total = $discounted_total + $shipping; //grand total without discounted price
				} else {
					$grand_total = $total + $shipping; //grand total without discounted price
				}

				$grand_total += $windshield_shipping;

				$the_cart .= "<div class='filled_cart_prod coupon_wrapp'>";
				$the_cart .= "<form id='coupon_form' method='POST'>";
				$the_cart .= "Have any coupon code? <br /><br />";
				$the_cart .= "<p><input type='text' name='coupon-code' placeholder='Coupon code'/><input id='apply_coupon' name='submit' type='submit' value='APPLY' /></p>";

				if(isset($_SESSION['coupon_code']) && $_SESSION['coupon_code'] !== ""){
					$the_cart .= "<span>".(isset($coupon_error_msg) ? $coupon_error_msg : $coupon_success_msg)."</span></form>";
					unset($_SESSION['coupon_code']);
				}

				$the_cart .= "<div class='filled_cart_prod_price coupon_wrapp_final_prices_wrapp'>";

				$prod_list.= "<hr />";
				if (isset($_SESSION['install_windshield']) && $_SESSION['install_windshield'] == 'yes') {
					$the_cart .= "<span><span class='filled_cart_final_price_title'>Total <i style='color: red; font-weight: bolder;'>(Windshield installation included)</i></span> <span class='filled_cart_final_price'>$currency $total</span></span>";

					$prod_list .= "Total <i>(Windshield installation included)</i> - $currency $total<br />";
					$_SESSION['w_installation'] = 5000;
				}

				else {
					$the_cart .= "<span><span class='filled_cart_final_price_title'>Total</span> <span class='filled_cart_final_price'>$currency $total</span></span>";

					$prod_list .= "Total - $currency $total<br />";
				}

				if($coupon_applied){
					$the_cart .= "<span><span class='filled_cart_final_price_title'>Discount (".$coupon->coupon_value_to_s().")</span> <span class='filled_cart_final_price'>$currency" . ($discounted_total) . "</span></span>";

					$prod_list .= "Discount - $currency " . ($total - $coupon->coupon_value) . "<br />";
				}

				 if ( $num_prod_in_cart  && $windshield_present ) {
					$the_cart .= "<span><span class='filled_cart_final_price_title'>Shipping Cost</span> <span class='filled_cart_final_price  shipping_cost'>$currency $shipping</span></span>";
					$the_cart .= "<span>
					<span class='filled_cart_final_price_title'>Windshield Shipping Cost</span> 
					<span class='filled_cart_final_price'>$currency $windshield_shipping</span></span>";

					$prod_list .= "Shipping Cost - $currency $shipping<br />";
					$prod_list .= "Windshield Shipping Cost - $currency $windshield_shipping<br />";
				}

				else {
					$the_cart .= "<span><span class='filled_cart_final_price_title'>Shipping Cost</span> <span class='filled_cart_final_price  shipping_cost'>$currency $shipping </span></span>";

					$prod_list .= "Shipping Cost -$currency $shipping <br />";
				}

				if (!$heavy_product_present && $shock_count > 1) {
					$heavy_product_present = true;
				}
				
				
					
				
				$check_for_specific_product_count = array_count_values($table_count);
				if ($heavy_product_present && $user_state != 'Lagos') {
					
					
					if (isset($check_for_specific_product_count['batteries']) ||
							isset($check_for_specific_product_count['tyres'])
					   )
					{
						if ($check_for_specific_product_count['batteries'] >= 2 ||
								$check_for_specific_product_count['tyres'] >= 2
						   )
						{
							$the_cart .= "<span><span class='filled_cart_final_price_title'>Heavy/Large Product charge</span> <span class='filled_cart_final_price'>$currency 1500</span></span>";
							$prod_list .= "Heavy/Large Product charge - $currency 1500<br />";
							$grand_total += 1500;
						} else {
					$the_cart .= "<span><span class='filled_cart_final_price_title'>Heavy/Large Product charge</span> <span class='filled_cart_final_price'>$currency 1500</span></span>";
					$prod_list .= "Heavy/Large Product charge - $currency 1500<br />";
					$grand_total += 1500;
					}
					} else {
					$the_cart .= "<span><span class='filled_cart_final_price_title'>Heavy/Large Product charge</span> <span class='filled_cart_final_price'>$currency 1500</span></span>";
					$prod_list .= "Heavy/Large Product charge - $currency 1500<br />";
					$grand_total += 1500;
					}
				}

				elseif ($heavy_product_present && $user_state == 'Lagos') {
					
						
					if (isset($check_for_specific_product_count['batteries']) ||
							isset($check_for_specific_product_count['tyres'])
							)
					{
						if ($check_for_specific_product_count['batteries'] >= 2 ||
							$check_for_specific_product_count['tyres'] >= 2
								)
						{
							$the_cart .= "<span><span class='filled_cart_final_price_title'>Heavy/Large Product charge</span> <span class='filled_cart_final_price'>$currency 1000</span></span>";
							$prod_list .= "Heavy/Large Product charge - $currency 1000<br />";
							$grand_total += 1000;
						}  else {
						$the_cart .= "<span><span class='filled_cart_final_price_title'>Heavy/Large Product charge</span> <span class='filled_cart_final_price'>$currency 500</span></span>";
						$prod_list .= "Heavy/Large Product charge - $currency 500<br />";
						$grand_total += 500;
					   }
					} else {
						$the_cart .= "<span><span class='filled_cart_final_price_title'>Heavy/Large Product charge</span> <span class='filled_cart_final_price'>$currency 500</span></span>";
						$prod_list .= "Heavy/Large Product charge - $currency 500<br />";
						$grand_total += 500;
					}
				}

				$the_cart .= "<span><span class='filled_cart_final_price_title'>Payable Amount</span> <span 
				         id='filled_cart_final_price'
				         
				         class='filled_cart_final_price'

				         data-t=".$grand_total." 
				         
				         data-w=".$u." 
				         
				         
				         >$currency".sprintf("%01.2f", $grand_total)."</span></span>";
				$the_cart .= "</div></div>";

				$g_total = sprintf("%01.2f", $grand_total);
				$prod_list .= "Payable Amount - $currency $g_total<br />";
				
				$_SESSION['cart_total'] = $g_total;
			}

			//generate hidden form fields to hold paystack params
			$p_ref = time(); //generate unique transaction reference
			$paystack_coupon_code = ($coupon_applied ? $coupon_code : 'none');
			
			$the_cart .=<<<EOT
			<form>
			
			    <input type="hidden" name="coupon_code" value="$paystack_coupon_code" />
				<input type="hidden" name="paystack-total" value="$g_total" />
				<input type="hidden" name="paystack-user-email" value="$user_email" />
				<input type="hidden" name="paystack-ref" value="$p_ref" />
				<input type="hidden" name="paystack-coupon-code" value="$paystack_coupon_code" />

			</form>
EOT;

			echo $the_cart;

			$prod_list .= "</ul>";
			$_SESSION['product_list'] = $prod_list;
			unset($_SESSION['valid_coupon_code']);
		}
	}
?>