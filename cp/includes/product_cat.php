<?php
$product = new ProductCats();
$answer = '';
$status = '';

if(Input::get('update') == true){
	$details=ProductCats::getInstance()->find_by_id(Input::get('id'));
}
?>

<form role="form" method="POST" action="modules/ProductCat/crud.php">

  <div class="box-body">
   
    <div class="row">
      <div class="col-md-6">
        <div class="form-group">
          <label>Name</label>
          <input class="form-control" required="required" <?= Input::get('update') == 'true' ? '' : 'disabled' ?> name="name"  value="<?= !empty($details->name) ? $details->name : '' ?>"    type="text">
         <input type="hidden" name="cat_id" value="<?= Input::get('category_id')?>">
          <input type="hidden" name="category" value="<?= Input::get('category')?>">
         <input type="hidden" name="cat_id" value="<?= Input::get('id')?>">
        </div>
      </div>
    
    </div><!--row-->
    
   <div class="col-md-4 pull-right">
	<input name="create" type="submit" <?= Input::get('update') == 'true' ? '' : 'disabled' ?> value="Submit" class="btn btn-success btn-block" />
  </div>
  </div>
  
			   
			  
  </form>
  
  <div class="box-header with-border">
    <h3 class="box-title">Product Cats</h3>
    <div class="box-tools pull-right">
      <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
    </div>
  </div>
  <div class="box-body">
    <table id="uploaded_product_table" class="table table-bordered table-striped">

      <thead>
        <tr>
          <th>#</th>
          <th>Name</th>
          <th>Number of sub categories</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
          <?php foreach ($product->all() as $details):?>
          <tr>
              <td><?= $details->cat_id ?></td>
              <td><?= $details->name ?></td>
              
               <td><?= count(ProductCats::getInstance()->hasMany( $details->cat_id)) ?></td>
              <td>  
                
                  <button  onclick="location.href='index.php?p=sub_category&category=<?= $details->name?>&category_id=<?= $details->cat_id?>'"  class="btn btn-sm btn-primary"> <i class="fa fa-plus" aria-hidden="true"></i>&nbsp; Add Sub Category</button>
                 <button onclick="location.href='index.php?p=category&update=true&id=<?= $details->cat_id?>'"  class="btn btn-sm btn-warning"><i class="fa fa-pencil-square-o"></i>&nbsp; Update </button>
          
             </td>
             </tr>
					  
		   <?php endforeach;?>	      
            
            
                
        </tbody>
      <tfoot></tfoot>
    
    </table>
  </div><!--box-body-->
  