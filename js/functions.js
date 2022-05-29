function getParameterByName(name, url) {
  if (!url) {
    url = window.location.href;
  }
  name = name.replace(/[\[\]]/g, "\\$&");
  var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
      results = regex.exec(url);
  if (!results) return null;
  if (!results[2]) return '';
  return decodeURIComponent(results[2].replace(/\+/g, " "));
}

function isCartSet() {
	if ($.cookie('cart') == undefined) {
		return false;
	}
	else {
		return true
	}
}

function updateCartCount() {
	if (isCartSet()) {
		var cart_size = '';
		cart_size = $.cookie('cart').length;
		console.log(cart_size)
		$('#prod_count').text(cart_size);

		if (cart_size > 0) {
			$('#cart_icon').html('<img src="/images/filled_cart.png" />');
		}

		else {
			$('#cart_icon').html('<img src="/images/empty_cart.png" />');
		}
	}
}

function updateAddCartButton() {

	if ($.cookie('cart').length == 0) {
		$('.add_cart_button').text('ADD TO CART');
		$('.add_cart_button').prop('disabled', false);
	}

	else {
		$('.add_cart_button').each(function() {
			var disableButton = false;
			for (var i = 0; i < $.cookie('cart').length; i++) {
				if ( $(this).siblings()['3']['value'] == $.cookie('cart')[i]['3']['value'] ) {
					disableButton = true;
				}
			}

			if (disableButton) {
				$(this).text('ITEM ADDED');
				$(this).prop('disabled', 'disabled');
			}

			else {
				$(this).text('ADD TO CART');
				$(this).prop('disabled', false);
			}
		});
	}

}

function paystack_log_order() {
	$.post('/log_orders.php', 'payment_method=card', function(resp) {
		//console.log(resp);
		//alert('success. transaction ref is ' + response.reference);
		if (resp == 'success') {
			window.location.href = "thankyou.php";
		}
	});
}