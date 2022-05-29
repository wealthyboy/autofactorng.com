<form role="form" method="POST" action="modules/add_cybersale.php" enctype="multipart/form-data">
  <div class="box-body">
    <div class="row">
      <div class="col-md-3">
        <div class="form-group">
          <label>Product Name</label>
          <input type="text" class="form-control" name="prod-name" />
        </div>
      </div>
      <div class="col-md-3">
        <div class="form-group">
          <label>Product Price</label>
          <input type="text" class="form-control" name="prod-price" />
        </div>
      </div>
      <div class="col-md-3">
        <div class="form-group">
          <label>Product Weight</label>
          <input type="text" class="form-control" name="prod-weight" />
        </div>
      </div>
      <div class="col-md-3">
        <div class="form-group">
          <label>Deal Value</label>
          <input type="text" class="form-control" name="deal-value" />
        </div>
      </div>
    </div><!--row-->
    <div class="row">
      <div class="col-md-4">
        <div class="form-group">
          <label>Product Description</label>
          <textarea class="form-control" name="prod-desc" rows="3" placeholder="Enter product description"></textarea>
        </div>
      </div>
      <div class="col-md-4">
        <div class="form-group">
          <label>Physical Decsription</label>
          <textarea class="form-control" name="phy-desc" rows="3" placeholder="Enter physical description"></textarea>
        </div>
      </div>
    </div><!--row-->
    <div class="row">
      <div class="col-md-4">
        <div class="form-group">
          <label>Product Image 1</label>
          <input type="file" class="form-control" name="img1" />
        </div>
      </div>
      <div class="col-md-4">
        <div class="form-group">
          <label>Product Image 2</label>
          <input type="file" class="form-control" name="img2" />
        </div>
      </div>
      <div class="col-md-4">
        <div class="form-group">
          <label>Product Image 3</label>
          <input type="file" class="form-control" name="img3" />
        </div>
      </div>
    </div><!--row-->
  </div><!--box-body-->
  <div class="box-footer">
    <div class="col-md-4 pull-right">
      <button type="submit" name="upload-prod" class="btn btn-success btn-block">UPLOAD PRODUCT</button>
    </div>
  </div>
</form>