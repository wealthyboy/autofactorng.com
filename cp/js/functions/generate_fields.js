var fieldNum = 2;
var productFieldName = '';
var priceFieldName = '';
var quantityFieldName = '';

//order_email
function addField(arg) {
  productFieldName = 'product' + fieldNum;
  amountFieldName = 'price' + fieldNum;
  quantityFieldName = 'qty' + fieldNum;
  
  if (arg == 'order_email') {
  	$("div.row:last").after(
  		'<div class="row">' +
  		'<div class="col-md-4">' +
        	'<div class="form-group">' +
          	'<label>Qty</label>' +
        		'<input type="text" class="form-control" name="quantity[]" placeholder="Enter quantity" />'+
        	'</div>'+
      	'</div>'+
      	'<div class="col-md-4">' +
        	'<div class="form-group">' +
          	'<label>Product Name</label>' +
        		'<input type="text" class="form-control" name="product[]" placeholder="Enter product name" />'+
        	'</div>'+
      	'</div>'+
      	'<div class="col-md-4">'+
        	'<div class="form-group">'+
          	'<label>Product Price</label>'+
          	'<input type="text" class="form-control" name="price[]" placeholder="Product price" />'+
        	'</div>'+
      	'</div>'+
    	'</div><!--row-->'
  	);
  }

  else if (arg == 'cancel_order') {
    $("div.row:last").after(
    '<div class="row">' +
      '<div class="col-md-4">' +
        '<div class="form-group">' +
          '<label>Product Name</label>' +
          '<input type="text" class="form-control" name="'+productFieldName+'" placeholder="Enter product name" />'+
        '</div>'+
      '</div>'+
      '<div class="col-md-1">'+
          '<div class="form-group">'+
            '<label>Quantity</label>'+
            '<input type="text" class="form-control" name="'+quantityFieldName+'" />'+
          '</div>'+
        '</div>'+
      '<div class="col-md-3">'+
        '<div class="form-group">'+
          '<label>Product Price</label>'+
          '<input type="text" class="form-control" name="'+amountFieldName+'" placeholder="Product price" />'+
        '</div>'+
      '</div>'+
    '</div><!--row-->'
    );
  }	
		
  fieldNum += 1;
}




	