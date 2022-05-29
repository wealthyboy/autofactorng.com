<form role="form" method="POST" action="modules/add_car_care.php" enctype="multipart/form-data">
  <div class="box-body">
    <div class="row">
      <div class="col-md-3">
        <div class="form-group">
          <label>Select Product</label>
          <select name="sub-cat-id" class="form-control select2" style="width: 100%;">
         <?php
          /* first check to see if the category has a subcat*/
            $data = ProductCats::getInstance()->hasMany($cat_id);
            
             foreach ($data as $details):
             	if($prod= ProductSubCat::getInstance()->hasMany($details->sub_cat_id)){ ?>
             	   <optgroup label="<?= $details->name ?>">
                    
              <?php  foreach ($prod as $details2): ?> 
		                <option value="<?= $details2->name ?>"><?=  $details2->name ?></option>
		        <?php endforeach;?>
                </optgroup>
             
             <?php	}?>
          
             	<?php if(ProductSubCat::getInstance()->hasMany($details->sub_cat_id)){  
             		 continue;
             	}?>
                <option value="<?php echo ucfirst($details->name); ?>"><?= ucfirst($details->name); ?></option>
          <?php endforeach; ?>
          </select>
        </div>
      </div>
       <div class="col-md-3">
        <div class="form-group">
          <label>Product Alt Text</label>
          <input type="text" class="form-control" name="image_alt_text"  />
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
  <div class="box-footer">
    <div class="col-md-4 pull-right">
       <button onclick="addRow();" id="" type="button" data-type="order_email" class="btn add-product-field btn-default btn-block"><i class="glyphicon glyphicon-plus"></i> Add another product</button>
      <button type="submit" name="upload-prod" class="btn btn-success btn-block">UPLOAD PRODUCT</button>
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