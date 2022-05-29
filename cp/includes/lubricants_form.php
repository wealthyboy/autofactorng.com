<form role="form" method="POST" action="modules/add_lubricants.php" enctype="multipart/form-data">
  <div class="box-body">
    <div class="row">
      <div class="col-md-3">
        <div class="form-group">
        <?php  $data = ProductCats::getInstance()->hasMany($cat_id); ?>
          <label>Select Product</label>
          <select name="sub-cat-id" class="form-control select2" style="width: 100%;">
          <?php
          /* first check to see if the category has a subcat*/
            

             foreach ($data as $details):
             	if($prod= ProductSubCat::getInstance()->hasMany($details->sub_cat_id)){ ?>
             	   <optgroup label="<?= $details->sub_cat_id ?>">
                    
              <?php  foreach ($prod as $details2): ?> 
		                <option value="<?= $details2->sub_cat_id ?>"><?=  $details2->name ?></option>
		        <?php endforeach;?>
                </optgroup>
             
             <?php	}?>
          
             	<?php if(ProductSubCat::getInstance()->hasMany($details->sub_cat_id)){  
             		 continue;
             	}?>
                <option value="<?php echo $details->sub_cat_id; ?>"><?= ucfirst($details->name); ?></option>
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