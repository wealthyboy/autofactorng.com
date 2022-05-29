<form role="form" method="GET" action="includes/cancel_order_preview.php">
<h3>&nbsp;Order Cancellation Email</h3>
  <div class="box-body">
    <div class="row">
      <div class="col-md-4">
        <div class="form-group">
          <label>Customer Name</label>
          <input type="text" class="form-control" name="customer-name" placeholder="Customer name" />
        </div>
      </div>
      <div class="col-md-4">
        <div class="form-group">
          <label>Email Address</label>
          <input type="text" class="form-control" name="email" placeholder="Customer email" />
        </div>
      </div>
    </div><!--row-->
    <div class="row">
      <div class="col-md-4">
        <div class="form-group">
          <label>Subject</label>
          <input type="text" class="form-control" name="subject" placeholder="Subject" />
        </div>
      </div>
      <div class="col-md-4">
        <div class="form-group">
          <label>Shipping Cost</label>
          <input type="number" class="form-control" name="shipping-cost" />
        </div>
      </div>
    </div><!--row-->
    <div class="row">
      <div class="col-md-4">
        <div class="form-group">
          <label>Product Name</label>
          <input type="text" class="form-control" name="product1" placeholder="Enter product name" />
        </div>
      </div>
      <div class="col-md-1">
        <div class="form-group">
          <label>Quantity</label>
          <input type="text" class="form-control" name="qty1" />
        </div>
      </div>
      <div class="col-md-3">
        <div class="form-group">
          <label>Product Price</label>
          <input type="text" class="form-control" name="price1" placeholder="Product price" />
        </div>
      </div>
    </div><!--row-->
  </div><!--box-body-->
  <div class="box-footer">
    <div class="col-md-3 pull-right">
      <button id="add-field" data-type="cancel_order" class="btn btn-default btn-block"><i class="glyphicon glyphicon-plus"></i> Add another product</button>
      <button type="submit" class="btn btn-success btn-block">Send</button>
    </div>
  </div>
</form>