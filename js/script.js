function responseMessage(msg) {
 
  $('#rating_result').html("<span>" + msg + "</span>").show();
}


$('a#track_my_order_link').on('click',function(e){
	  
    $('html, body').animate({scrollTop: 0},'slow',function(){
    	$("button.login_btn_t" ).trigger('click');
    });

});
	

$(document).ready(function() {
	//############## windshield ################
	


	// Reviews

      $('.slick').slick({
      	 prevArrow:"<button type='button' class='slick-prev back-button'> < </button>",
      	 nextArrow:"<button type='button' class='slick-prev next-button'> > </button>",
         centerMode: true,
		 centerMode: true,
         centerPadding: '60px',
         slidesToShow: 3,
         responsive: [
       {
         breakpoint: 768,
         settings: {
         arrows: false,
         centerMode: true,
         centerPadding: '40px',
         slidesToShow: 3
      }
    },
    {
         breakpoint: 480,
	      settings: {
	        arrows: false,
	        centerMode: true,
	        centerPadding: '40px',
	        slidesToShow: 1
	      }
    }
  ]
      });

  
  
  
  /* 1. Visualizing things on Hover - See next part for action on click */
  $('.star-rating').on('mouseover', function(){
    var onStar = parseInt($(this).data('rating-value'), 10); 
   // The star currently mouse on
   
    // Now highlight all the stars that's not after the current hovered star
    $(this).parent().children('.star-rating').each(function(e){
    	$('#rating_result').removeClass('hide').addClass('show');
      if (e < onStar) {
         $(this).addClass('checked');
         $(this).removeClass('selected');
         $('#rating_result').html($(this).data('title'));
         $('#rating_result').removeClass('hide').addClass('show');
      }
      else {
         $(this).removeClass('selected');
      }
    });
    
  }).on('mouseout', function(){
  	    $('#rating_error').fadeOut('fast');
  	   

        $(this).parent().children('.star-rating').each(function(e){
        // $('#rating_result').fadeOut(5000);
        $(this).removeClass('checked');
       
    });
  });
  
  
 
   /* 2. Action to perform on click */
  $('.star-rating').on('click', function(){
    var onStar = parseInt($(this).data('rating-value'), 10); // The star currently selected
    var stars = $(this).parent().children('.star-rating');

    for (i = 0; i < stars.length; i++) {
      $(stars[i]).removeClass('checked');
    }
    
    for (i = 0; i < onStar; i++) {
      $(stars[i]).addClass('selected');
    }
    
    // JUST RESPONSE (Not needed)
    var ratingValue = $('.selected').last().data('title');
    var msg = "";
       $('form#add-reviews input#rating_title').val($(this).data('title'));
       $('form#add-reviews input#rating_title_value').val($(this).data('rating-value'));
   
      // $('#rating_result').fadeIn().html("Thanks! For Your Rating");

      return;
    
  });





    $('.required').on('keypress',function(){
     	 $(this).css({
           	   'border':'1px solid #cccccc',
          });
     }).bind('paste',function(){
          $(this).css({
           	   'border':'1px solid #cccccc',
          });
     });
    

	$('form#add-reviews').submit(function(e){
		e.preventDefault();

	 var errors = [];

      var title = $('input#title').val();
      var desc  = $('textarea#desc').val();
      var product_name  = $('input#product_name').val();
      var product_image = $('input#product_image').val();
      var product_price = $('input#product_price').val();
      var rating_title = $('input#rating_title').val();
      var rating_title_value = $('input#rating_title_value').val();
      var user_id       = $('input#user_id').val();
      var product_id    = $('input#product_id').val();

      if (rating_title == '') {
      	 $('#rating_error').fadeIn(200).html("Choose a rating").css({'color':'red'});
         
          errors.push(1);
         
      }
      if(user_id == 0) {
          alert("You have to log in to make a review");
            $('html, body').animate({scrollTop: 0},'slow',function(){
            	$("button.login_btn_t" ).trigger('click');
            });
            return;
      } 

     $('.required').each(function(){
     	 if($(this).val() == "") {
		  $(this).css({
           	   'border':'2px solid red',
          });

         errors.push(1);
       }
     });



     if(errors.length > 0) {
			return false;
		}

      var params = {'rating_title_value':rating_title_value,'rating_title':rating_title,'product_id':product_id,'title':title,'desc':desc,'product_price':product_price,'product_image':product_image ,'product_name':product_name,'user_id':user_id};
        $.ajax({
        	 method: "post",
		     url: "/modules/reviews.php",
		     data: params,
		     beforeSend: function() {
	           $('button#addreview').attr('disabled','disabled').html('Saving.......');
		     },
		     success: function(data) {
		     if ( $.trim(data) == 1){
                location.reload();
		     }
             console.log(data);
             //location.reload();
  		  },

        });
      return false;
	});

	$('#track_my_order').click(function(e) {
		setTimeout(function(){
			$('button[data-dropdown="#header_login"]').trigger('click');
		}, '500');
		// console.log(e.namespace);
		
	});

	$('#track_order_button, #track_order_button2').click(function(e) {
		e.preventDefault();
		if ($(this).prop('id') == 'track_order_button') {
			var order_number = $('#order_number').val();
			var track_email = $('#track_email').val();
		} else if ($(this).prop('id') == 'track_order_button2') {
			var order_number = $('#tracking_number').val();
			var track_email = $('#tracking_email').val();
		}
		
		if (order_number == '' || track_email == '') {
			$('.track_order_msg_output').text('You must enter your order number and email');
		} else {
			var query = 'tracking-number='+order_number+'&track-email='+track_email;
			$.get('/modules/validate_order_tracking.php', query, function(r) {
				if (r == 'Failed') {
					$('.track_order_msg_output').text('Invalid tracking number/email address');
				} else {
					location.href = '/modules/validate_order_tracking.php?'+query;
				}
			});

			/*$.ajax({ type: "GET",
				url: "/modules/validate_order_tracking.php",
				data: query,
				dataType: "text",
				success: function(r){
					console.log(r);
				}
		 	});*/
		}
		
	});

	$('#order_history').accordion();

	//######################### like button ######################
	$('.like_button').click(function() {
		var p_id = getParameterByName('id');
		var p_tbl = getParameterByName('tbl');

		if ($(this).attr('style') == '') {
			
			$.get('/modules/product_like.php', 'source=like_button&action=like&prod_id='+p_id+'&tbl='+p_tbl, function() {
				$('.like_button').css('color', 'red');
				console.log('Like');
				$('.like_button').attr('title', 'Unlike this product');
			});
		} else if ($(this).attr('style') != '') {
			$.get('/modules/product_like.php', 'source=like_button&action=unlike&prod_id='+p_id+'&tbl='+p_tbl, function() {
				$('.like_button').attr('style', '');
				console.log('Unlike');
				$('.like_button').attr('title', 'Like this product');
			});
		}
	});
	// -------------------------------------------------------------------

	$('#top_header_wrapp').on('click', '.close_dropdown', function() {
		$.sweetDropdown.hideAll();
	});

	var prevChoice = 'no';
  $('#windshield_form :radio').click(function() {
    if ($(this).prop('value') != prevChoice){
      $.get('/modules/set_windshield_installation.php', 'windshield-installation='+$(this).prop('value'), function(data){
        console.log(data);
      });
      //console.log($(this).prop('value'));
      prevChoice = $(this).prop('value');
    }
  });

	//############## gtb filter ##################
	var initial_width = $(window).width();
	var cur_bg_image = $('#gtb_filter').css('background');

	if (initial_width < 1000) {
		$('#gtb_filter').css('background', 'none');
	}

	$(window).resize(function() {
		var cur_width = $(window).width();

	  if (cur_width < 1000) {
	    $('#gtb_filter').css('background', 'none');
	  }

	  else {
	  	$('#gtb_filter').css('background', cur_bg_image);
	  }
	});

	//########## Log in ##########
	$('#login_button').click(function(e) {
		e.preventDefault();
		$.post('/login_logout.php', $('#login_form').serialize(), function(data) {
			if ($.trim(data) == 'failed') {
				$('#login_status').text('Could not login, incorrect username/email or password');
				$('#pword').val('');
			}

			else if ($.trim(data) == 'logged in') {
				location.reload();
			}
		});
	});
	$('.login_button').click(function(e) {
		e.preventDefault();
		$.post('/login_logout.php', $('.login_form').serialize(), function(data) {
			
			if (data == 'failed') {
				$('#login_status').text('Could not login, incorrect username/email or password');
				$('#pword').val('');
			}

			else if ($.trim(data) == 'logged in') {
				location.reload();
			}
		});
	});

	$('#logout_button').click(function(e) {
		e.preventDefault();
		$.get('/login_logout.php', ' ', function(dat) {
			if ($.trim(dat) == 'logged out') {
				location.reload();
			}
		});
	});

	//############# nav menu ################
	$('#nav_menu_toggle').click(function() {
		var menu = $('#nav_menu_list');

		if (menu.css('display') == 'block') {
			menu.css('display', 'none');
		}

		else {
			menu.css('display', 'block');
		}
		
	});

	//################# Product search #################
	$('#search_bar').autocomplete({
		source: '/search_product.php',
		minLength: 2,
		select: function(event, ui) {
			var url = ui.item.id;
			if(url != '#') {

	          location.href = url;
			}
		}, //html: true,
		open: function(event, ui) {
			$(".ui-autocomplete").css("z-index", 100000000);
		}
	});
	//######################### Product zoom ######################### 
	$('.sp-wrap').smoothproducts();
	//######################### Slider ######################### 
	var $slider = $('.banner').unslider({
		autoplay: true,
		arrows: false,
		infinite: true,
		speed: 400,
		delay: 3000
	});
	$slider.on('mouseover', function() {
    $slider.data('unslider').stop();
	}).on('mouseout', function() {
	    $slider.data('unslider').start();
	});
	//######################### Add to cart ######################### 
	$.cookie.json = true;   //auto conversion btw string and json
	updateCartCount();

	if (isCartSet()) {
		updateAddCartButton();
	}

	$('.add_cart_button').click(function(e) {
		e.preventDefault();
		
		var prod = $(this).parent().serializeArray();
		$(this).text('Adding...');

		if (isCartSet()) {
			var cur_cart = $.cookie('cart');
			var num_prod_in_cart = cur_cart.length;
			cur_cart.push(prod);
			$.cookie('cart', cur_cart, {expires: 7, path: '/'});
			console.log($.cookie('cart'));
		}

		else {
			var cart = [];
			cart.push(prod);
			$.cookie('cart', cart, {expires: 7, path: '/'});
			console.log($.cookie('cart'));
		}

		$(this).text('ITEM ADDED');
		$(this).prop('disabled', 'disabled');

		updateCartCount();

		//schedule abandoned cart mail
		if ($.cookie('user') != undefined ) {
			var cart_str = 'action=add';
			cart_str += '&';
			cart_str += 'user-id='+$.cookie('user').id;

			console.log(cart_str);
			$.get('/modules/check_abandoned_cart.php', cart_str, function(response) {
				console.log(response);
			});
		}
	});

	$('#cart_wrapp button').click(function() {
		//console.log('clicked the cart_wrapp');
		$('#cart_dropdown').html('<img id="ajax_loader" src="/images/ajax-loader5.gif" />');

		//simulate ajax connection duration of 1sec, remove setTimeout after testing!
		$('#cart_dropdown').load('/process_cart.php', 'source=cart_dropdown', function() {
			$('.cart_dropdown_prod_pop').click(function() {
			  var prod_delete = $(this).index('.cart_dropdown_prod_pop');
			  var c = $.cookie('cart');
			  c.splice(prod_delete, 1);
			  $.cookie('cart', c, {expires: 7, path: '/'});
			  updateCartCount();
			  updateAddCartButton();

			  //schedule/unschedule abandoned cart mail
			  if ($.cookie('user') != undefined ) {
					var cart_str = 'action=remove';
					cart_str += '&';
					cart_str += 'user-id='+$.cookie('user').id;

					console.log(cart_str);
					$.get('/modules/check_abandoned_cart.php', cart_str, function(response) {
						console.log(response);
					});
				}

			  $('#header').trigger('click');
			  //$('#cart_wrapp button').trigger('click');
			  //console.log('prod pop clicked');
			});
		});
	});

	//######################### checkout #########################
	$('#cart_checkout').load('/process_cart.php', 'source=checkout_cart');

	$('#checkout_button button').click(function(e) {
		e.preventDefault();

		if (isCartSet()) {
			var c = $.cookie('cart');
			if (c.length == 0) {
				alert('Shopping cart empty');
				return false;
			}
			
			if (!$('input[name=payment-type]:checked').val()) {
				alert('Please select a payment option');
				$('html, body').animate({scrollTop: 200},'slow');
				return false;
			}
			
			$(this).prepend('<i class="fa fa-refresh fa-spin fa-lg"></i> ');
			$(this).prop('disabled', 'disabled');
			
			var payment_method = $('input[name=payment-type]:checked').val();
		
			var coupon_code = $('input[name=coupon_code]').val();
			
			//alert(coupon_code);
		
			if (payment_method == 'cash') {
				
				$.post('/log_orders.php', 'payment_method='+payment_method +'&coupon_code='+coupon_code, function(resp) {
					console.log(resp);
					if ($.trim(resp) == 'Inserted') {
						window.location.href = "/thankyou.php"
					} else if ($.trim(resp) == 'Failed') {
						alert('Error checking out, try again later');
						$('#checkout_button button').find('.fa-spin').remove();
				         $('#checkout_button button').prop('disabled', false);
					//	location.reload();
					}
				});
				return;
			} 
			
			if (payment_method == 'wallet') {
			    
			    var prices = $(document).find("#filled_cart_final_price");
			    var total =  parseInt(prices.data('t'));
			    var wallet = parseInt(prices.data('w'));
			    
			     if (isNaN(wallet)){
			       alert("Your wallet has Insufficient funds") ;
			       $('#checkout_button button').find('.fa-spin').remove();
				   $('#checkout_button button').prop('disabled', false);
			       return false;
			    }
			    

			   
			    if (total > wallet){
			       alert("Your wallet has Insufficient funds") ;
			       $(this).html('Checkout >>>');
		          $(this).prop('disabled', false);
			       return false;
			    }
	

				$.post('/log_orders.php', 'payment_method='+payment_method +'&coupon_code='+coupon_code, function(resp) {
				    console.log(resp)
					if ($.trim(resp) == 'Inserted') {
					   window.location.href = "/thankyou.php"
					} else if ($.trim(resp) == 'Failed') {
					     $('#checkout_button button').find('.fa-spin').remove();
				         $('#checkout_button button').prop('disabled', false);
						alert('Error checking out, try again later');
						location.reload();
					}
				});
				return false;
			} 
			
			if (payment_method == 'card') {
				var p_total_amount = $('input[name=paystack-total]').val();
				      var p_user_email   = $('input[name=paystack-user-email]').val();
				      var p_ref          = $('input[name=paystack-ref]').val();
				
				      var p_prod_list 	 = $("[name|='paystack']:gt(3)").serializeArray();
				
				      var handler = PaystackPop.setup({
				        key: 'pk_live_f781064afdc5336a6210015e9ff17014d28a4f8b',
				        email: p_user_email,
				        amount: p_total_amount * 100, /* amount in kobo */
				        ref: p_ref,
				        metadata: {
				        	product_list : p_prod_list
				        },
				        callback: function(response) {
				        	
				        	$.post('/log_orders.php', 'payment_method='+payment_method, function(resp) {
				        		
				        		if ($.trim(resp) == 'Inserted') {
				        			window.location.href = "/thankyou.php";
				        		}
				        	});
				        },
				        onClose: function(){
				         //alert('window closed');
				         
				         $('#checkout_button button').find('.fa-spin').remove();
				         $('#checkout_button button').prop('disabled', false);
				       }
				      });
             handler.openIframe();
             return;
			}

			
		} else {
			alert('Shopping cart empty');
		}
	});

	//Apply coupon
	$(this).on('click', '#apply_coupon', function(e) {
		e.preventDefault();

		var coupon_form = $('#coupon_form');
		var coupon_code = $('input[name=coupon-code]').val();
		$('input[name=coupon_code]').val(coupon_code);

		if (coupon_code == '') {
			alert('Coupon field cannot be empty');
		}

		else {
			$.get('modules/set_coupon.php', 'coupon-code='+coupon_code, function(data) {
				location.reload();
				//console.log(data);
			});
		}
	});

	//######################### footer social icons #########################
	$('.hover_icon').mouseover(function() {
		var temp = $(this).prop('src');
		$(this).prop('src', $(this).attr('data-hover'));
		$(this).attr('data-hover', temp);
	});

	$('.hover_icon').mouseout(function() {
		var temp = $(this).prop('src');
		$(this).prop('src', $(this).attr('data-hover'));
		$(this).attr('data-hover', temp);
	});
});