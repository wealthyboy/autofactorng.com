
$(document).ready(function() {


	$('select#sub_cats_deals').on('change',function(){
	  var  params = {'sub_cat_id':$(this).val()  };
	  var output;
      $.ajax({
           url:'/cp/modules/product_deals/get_product.php',
           type:'post',
           data:params,
           success:function(data){
           	
           	var data = JSON.parse(data); 
               $('select#sub_cat_products_deals').empty();
               if(params.sub_cat_id == 11){
                   $('select#sub_cat_products_deals').append('<option value="">Select One</option><option value="KYB Shocks (Front)">KYB Shocks (Front)</option> <option value="Briscoe (Front) Shocks">Briscoe (Front) Shocks</option> <option value="KYB Shocks (Rear)">KYB Shocks (Rear)</option> <option value="Briscoe (Rear) Shocks">Briscoe (Rear) Shocks</option>')

               }else{ $('select#sub_cat_products_deals').append('<option value="">Select One</option>');}
              for (var i = 0; i < data.length; i++) {

              	    $('select#sub_cat_products_deals').append($("<option/>", {
					        value: data[i],
					        text: data[i],
                     }));
                }

            
           }
        });
	})

	$('#add-product-field').click(function(){
		var subcategory = $('#target').clone().insertAfter('#target');
		
      //  $('.target').after('<div class="row"><div class="col-md-4"><div class="form-group"><label>Product Name</label><input type="text" class="form-control" name="product_name[]" placeholder="Enter product name" /></div></div>');
	});
	$('a.out_of_stock').on('click',function(e){
        e.preventDefault();
        console.log()

        var params ={'tag':$(this).data('tag'),'table':$(this).data('table'),'product_id':$(this).data('prod-id')}
        
         console.log(params)
        $.ajax({
           url:'/cp/modules/tags/crud.php',
           type:'post',
           data:params,
           success:function(data){
           //	var data = JSON.parse(data); 
           	//location.reload();
           	 // if( $.trim(data.tag) == 1){
             //    $('a.out_of_stock'+params.product_id).text('Out of Stock');
             //     $('a#out_of_stock'+params.product_id).removeClass('btn-info').addClass('btn-warning');
             //    return;
           	 // }
           	 // if($.trim(data.tag) == 2){
             //    $('a#out_of_stock'+params.product_id).text('Disable pre order').removeClass('btn-warning').addClass('btn-info');
           	 // }
           }

        });
	});
	$('.order-status-update-button').click(function(e) {
		e.preventDefault();
		var order_id = $(this).data('order-id');
		var order_status = $(this).parent().siblings().val();

		$.get('modules/update_order_status.php', 'order-id='+order_id+'&order-status='+order_status, function(r){
			alert(r);
		});
	});


	$('#search-btn').click(function(e) {
		e.preventDefault();
		var cur_location = location.href;
		//console.log(cur_location);
		var q = $('input[name=q]').val();
		location.href = cur_location + '&q=' + q;
	});

	$('button[data-action=update]').click(function(e) {
		e.preventDefault();

		var prod_id = $(this).attr('data-prod-id');
		var cat_id = $(this).attr('data-cat-id');
		var sub_cat_id = $(this).attr('data-sub-cat-id');
		var name = $(this).attr('data-name');
		var page = $(this).attr('data-page');
		//console.log('SUBCAT => ' + sub_cat_id);
		var url = 'index.php?action=update-product&id='+prod_id+'&cat_id='+cat_id+'&sub_cat_id='+sub_cat_id+'&name='+ name +'&page='+page;

		location.href = url;
	});

	$('button[data-action=delete]').click(function(e) {
		e.preventDefault();

		var prod_id = $(this).attr('data-prod-id');
		var cat_id = $(this).attr('data-cat-id');
		var sub_cat_id = $(this).attr('data-sub-cat-id');
		var table = $(this).attr('data-table');

		/*console.log('product id: ' + prod_id);
		console.log('category id: ' + cat_id);
		console.log('subcategory id: ' + sub_cat_id);
		console.log('table name: ' + table);*/

		var url = 'modules/delete_product.php?id='+prod_id+'&cat_id='+cat_id+'&sub_cat_id='+sub_cat_id+'&tbl='+table;

		location.href = url;
	});

	$('button[data-tech-id]').click(function(e) {
		e.preventDefault();

		var id = $(this).attr('data-tech-id');

		var url = 'modules/add_delete_technician.php?id=' + id;

		location.href = url;
		//console.log(url);
	});

	$('button[data-tow-driver-id]').click(function(e) {
		e.preventDefault();

		var id = $(this).attr('data-tow-driver-id');

		var url = 'modules/add_delete_tow_truck_driver.php?id=' + id;

		location.href = url;
		//console.log(url);
	});

	$('button[data-merchant-id]').click(function(e) {
		e.preventDefault();

		var id = $(this).attr('data-merchant-id');

		var url = 'modules/add_delete_merchant.php?id=' + id;

		location.href = url;
		//console.log(url);
	});

	$('button[data-coupon-id]').click(function(e) {
		e.preventDefault();

		var id = $(this).attr('data-coupon-id');

		var url = 'modules/add_delete_coupon.php?coupon-id=' + id;

		location.href = url;
	});

	$('button[data-deal-id]').click(function(e) {
		e.preventDefault();

		var id = $(this).attr('data-deal-id');

		var url = 'modules/add_delete_deal.php?deal-id=' + id;

		location.href = url;
	});

	$('button#add-field').click(function(e) {
		e.preventDefault();

		addField($(this).attr('data-type'));
	});

	//########################### Price Update ##########################
	function updatePrice(arg) {
	  var id = $(arg).attr('data-prd-id');
	  var price = $(arg).text();
	  var product_table = $(arg).attr('data-prd-tbl');

	  $.get('modules/update_price.php', 'id='+id+'&price='+price+'&table='+product_table, function(data) {
	    alert(data);
	  });
	}

	var prevPrice = 0;
	$("#uploaded_product_table td").focus(function() {
	  prevPrice = $(this).text();
	});

	$("#uploaded_product_table td").blur(function() {
	  if($(this).text() !== prevPrice) {
	    updatePrice(this);
	  }
	});

	$('#update_price').click(function(e) {
		e.preventDefault();
		//var product_name = $(this).parents('form').find('#prod-names').val();
		var selected_product = $(this).parents('form').find('option:selected');
		var product_name = selected_product.attr('value');
		var product_table = selected_product.attr('data-table-name');
		var price_type = $(this).parents('form').find('input[name=price-type]:checked').val();
		var price = $(this).parents('form').find('input[name=price]').val();
		/*console.log('Product name ==> ' + product_name + '\n' +
								'Product table ==> ' + product_table + '\n' +
								'Price type ==> ' + price_type + '\n' +
								'Price ==> ' + price);*/
		$.post('modules/update_price.php', 'prod_name='+product_name+'&prod_table='+product_table+'&price_type='+price_type+'&price='+price, function(data) {
			alert(data);
			$('#update_price').parents('form').find('input[name=price]').val('');
		});
	});
});

