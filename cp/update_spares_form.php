<form role="form" method="POST" action="modules/update_spares.php" enctype="multipart/form-data">
<input type="hidden" name="prod-id" value="<?php echo $_GET['id']; ?>">
<input type="hidden" name="sub-cat-id" value="<?php echo $sub_cat_id; ?>">
<input type="hidden" name="page" value="<?php echo $_GET['page']; ?>">
  <div class="box-body">
    <div class="row">
      <div class="col-md-3">
        <div class="form-group">
          <label>Select Product</label>
          <select name="prod-name" class="form-control select2" style="width: 100%;">
          <?php
            if ($sub_cat_id == 11) { ?>
             <optgroup label="Shocks (Front)">
                <option value="KYB Shocks (Front)">KYB Shocks (Front)</option>
                <option value="Shocks (Front)">Shocks (Front)</option>
                <option value="Briscoe (Front) Shocks">Briscoe Front Shocks</option>
                
              </optgroup>
              <optgroup label="Shocks (Rear)">
                <option value="KYB Shocks (Rear)">KYB Shocks (Rear)</option>
                <option value="Shocks (Rear)">Shocks (Rear)</option>
                 <option value="Briscoe (Rear) Shocks">Briscoe Rear Shocks</option>
   
              </optgroup>
          <?php
            }
            $data = mysqli_query($GLOBALS['dbc'], "SELECT * FROM product_types WHERE sub_cat_id = $sub_cat_id");
            while($row = mysqli_fetch_array($data)) {
              if ($row['name'] != 'Shocks (Front)' && $row['name'] != 'Shocks (Rear)') { ?>
                <option value="<?php echo $row['name']; ?>"><?= $row['name']; ?></option>
          <?php
              }
            } ?>
          </select>
        </div>
      </div>
    </div> <!--row-->
    <div class="row">
      <div class="col-md-3">
        <div class="form-group">
          <?php
            $data = mysqli_query($GLOBALS['dbc'], "SELECT * FROM spare_parts WHERE id = $prod_id");
            $row = mysqli_fetch_array($data);
          ?>
          <label>Car Manufacturer Name</label>
          <input type="text" class="form-control" name="manufacturer" value="<?php echo $row['manufacturer']; ?>" />
        </div>
      </div>
      <div class="col-md-3">
        <div class="form-group">
          <label>Car Model Name</label>
          <input type="text" class="form-control" name="model" value="<?php echo $row['model']; ?>" />
        </div>
      </div>
      <div class="col-md-3">
        <div class="form-group">
          <label>Year (From)</label>
          <input type="text" class="form-control" name="year-begin" value="<?php echo $row['year_begin']; ?>" />
        </div>
      </div>
      <div class="col-md-3">
        <div class="form-group">
          <label>Year (To)</label>
          <input type="text" class="form-control" name="year-end" value="<?php echo $row['year_end']; ?>" />
        </div>
      </div>
    </div><!--row-->
    <div class="row">
      <div class="col-md-4">
        <div class="form-group">
          <label>Product Price</label>
          <input type="text" class="form-control" name="prod-price" value="<?php echo $row['price']; ?>" />
        </div>
      </div>
      <div class="col-md-4">
        <div class="form-group">
          <label>Product Description</label>
          <textarea class="form-control" name="prod-desc" rows="3" placeholder="Enter product description">
            <?php echo $row['prd_desc']; ?>
          </textarea>
        </div>
      </div>
      <div class="col-md-4">
        <div class="form-group">
          <label>Physical Decsription</label>
          <textarea class="form-control" name="phy-desc" rows="3" placeholder="Enter physical description">
            <?php echo $row['phy_desc']; ?>
          </textarea>
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

     <h3>Related Items</h3><!--row-->
     <div class="row">
      
      <div class="col-md-4">
         
         <div class="form-group">
          <label>Product Name</label>
          <input type="text" class="form-control" name="product_name[]" placeholder="Enter product name" />
        </div>
      </div>
      <div class="col-md-4">
        <div class="form-group">
         <label>Product Name</label>
          <input type="text" class="form-control" name="product_name[]" placeholder="Product price" />
        </div>
      </div>
      <div class="col-md-4">
        <div class="form-group">
         <label>Product Name</label>
          <input type="text" class="form-control" name="product_name[]" placeholder="Product price" />
        </div>
      </div>
       <div class="col-md-4">
        <div class="form-group">
         <label>Product Name</label>
          <input type="text" class="form-control" name="product_name[]" placeholder="Product price" />
        </div>
      </div>
    </div><!--row-->
  </div><!--box-body-->
  <div class="box-footer">
    <div class="col-md-4 pull-right">
      <button type="submit" class="btn btn-warning btn-block"><i class="fa fa-pencil-square-o"></i>&nbsp; UPDATE PRODUCT</button>
    </div>
  </div>
</form>