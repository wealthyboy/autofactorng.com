 <form role="form" method="POST" action="modules/add_spares.php" enctype="multipart/form-data">
<input type="hidden" name="sub-cat-id" value="<?php echo $sub_cat_id; ?>">
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
                <option value="Briscoe (Front) Shocks">Briscoe (Front) Shocks</option>
                
              </optgroup>
              <optgroup label="Shocks (Rear)">
                <option value="KYB Shocks (Rear)">KYB Shocks (Rear)</option>
                <option value="Shocks (Rear)">Shocks (Rear)</option>
                 <option value="Briscoe (Rear) Shocks">Briscoe (Rear) Shocks</option>
   
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
          <label>Car Manufacturer Name</label>
          <input type="text" class="form-control" name="manufacturer" />
        </div>
      </div>
      <div class="col-md-3">
        <div class="form-group">
          <label>Car Model Name</label>
          <input type="text" class="form-control" name="model" />
        </div>
      </div>
      <div class="col-md-3">
        <div class="form-group">
          <label>Year (From)</label>
          <input type="text" class="form-control" name="year-begin" />
        </div>
      </div>
      <div class="col-md-3">
        <div class="form-group">
          <label>Year (To)</label>
          <input type="text" class="form-control" name="year-end" />
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
    </div>
     <h3>Related Items</h3><!--row-->
     <div id="target" class="row target">
      
      <div class="col-md-4">
         
         <div class="form-group">
          <label>Product Name</label>
          <input type="text" class="form-control" name="product_name[]" placeholder="Enter product name" />
        </div>
      </div>
   
      <div id="sub_cat_field" class="col-md-4">
        <div  class="form-group">
           <label>Select product Category</label>
          <select name="sub_category[]" id="" class="form-control">
             <option selected="selected" value="">Select One</option>
            
          <?php  foreach (ProductCats::getInstance()->all() as $details) {?>
            
                   <option value="<?php echo   (new Category)->get_table_name($details->name) ?>"><?=  $details->name ?></option>

          <?php  } 
           ?>
           <option value="wheels">Wheels</option>
          </select>
        </div>
      </div>

       <div style="margin-top:  25px;" id="sub_cat_field" class="col-md-4">
     
    </div>

    <div id="target2" class=""></div>
      
    </div><!--row-->

  </div><!--box-body-->
 <?php $test = ProductCats::getInstance()->all() ?>
  <div class="box-footer">
    <div class="col-md-4 pull-right">
       <button onclick="addRow();" id="" type="button" data-type="order_email" class="btn add-product-field btn-default btn-block"><i class="glyphicon glyphicon-plus"></i> Add another product</button>
      <button type="submit" class="btn btn-success btn-block">UPLOAD PRODUCT</button>
    </div>
  </div>
</form>


  <script type="text/javascript"><!--
var row = 1;



function addRow() {
  <?php $cat = ProductCats::getInstance()->all() ?>
  html  = '<div  class="row" id="route-row' + row + '">';
  html += ' <div class="col-md-4">';
  html += '<div class="form-group"><label>Product Name</label>';
  html += '<input type="text" class="form-control" name="product_name[]" placeholder="Enter product name" />';
  html += '</div></div>';
  html +='<div id="sub_cat_field" class="col-md-4"><div  class="form-group">';
  html +='<label>Select product Category</label>';
  html +='<select  name="sub_category[]" id="" class="form-control">';
  html +='<option selected="selected" value="">Select One</option>';
  <?php foreach ($cat as $details) { ?>
   html +='<option  value="<?php echo (new Category)->get_table_name($details->name) ?>"><?php echo $details->name  ?></option>';
  <?php } ?>
  html +='<option value="wheels">Wheels</option></select> </div> </div>';
 
  html += '<div style="margin-top:25px;" class="col-md-4"><button type="button" onclick="$(\'#route-row' + row + '\').remove();" data-toggle="tooltip" title="Remove" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></div>';
  html += '</div>';
  
  $(html).insertAfter('#target');
  
  row++;
}

</script>