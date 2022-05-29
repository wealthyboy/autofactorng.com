<form role="form" method="POST" action="modules/add_tyres.php" enctype="multipart/form-data">
<input type="hidden" name="sub-cat-id" value="<?php echo $sub_cat_id; ?>">
  <div class="box-body">
    <div class="row">
      <div class="col-md-3">
        <div class="form-group">
          <label>Select Product</label>
          <select name="prod-name" class="form-control select2" style="width: 100%;">
           
          <?php
            if ($sub_cat_id == 24) {
            	
              $data =ProductSubCat::getInstance()->hasMany($details->sub_cat_id);
            }

            elseif ($sub_cat_id == 25) {
            	$data = ProductCats::getInstance()->hasMany($cat_id);
            }
            foreach ($data as $details):?>
             <option value="<?php echo ucfirst($details->name); ?>"><?= ucfirst($details->name); ?></option>
          <?php endforeach; ?>
          </select>
        </div>
      </div>
      
       <div class="col-md-3">
        <div class="form-group">
          <label>Product Alt Text</label>
          <input type="text" class="form-control" name="image_alt_text" />
        </div>
      </div>
    </div> <!--row-->
    <div class="row">
      <div class="col-md-3">
        <div class="form-group">
          <label>Product Radius</label>
          <input type="text" class="form-control" name="prod-radius" />
        </div>
      </div>
      <div class="col-md-3">
        <div class="form-group">
          <label>Product Width</label>
          <input type="text" class="form-control" name="prod-width" />
        </div>
      </div>
      <div class="col-md-3">
        <div class="form-group">
          <label>Product Height</label>
          <input type="text" class="form-control" name="prod-height" />
        </div>
      </div>
    </div><!--row-->
    <div class="row">
      <div class="col-md-4">
        <div class="form-group">
          <label>Product Price</label>
          <input type="text" class="form-control" name="prod-price" />
        </div>
      </div>
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
      <button type="submit" class="btn btn-success btn-block">UPLOAD PRODUCT</button>
    </div>
  </div>
</form>