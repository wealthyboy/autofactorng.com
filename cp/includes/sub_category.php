<?php
$answer = '';
$status = '';

$sub_cat = ProductSubCat::getInstance()->find_where(Input::get('category_id'));
if(Input::get('update') == true){
	$details=ProductSubCat::getInstance()->find_by_id(Input::get('id'));
}
?>
  <div style="" ><?php   message(Session::get('msg'),Session::get('status'));?></div>
<form role="form" method="POST" action="modules/SubCategory/crud.php">

  <div class="box-body">
   
    <div class="row">
      <div class="col-md-6">
        <div class="form-group">
          <label>Name</label>
          <input class="form-control" required="required" name="name"  value="<?= !empty($details->name) ? $details->name : '' ?>"    type="text">
         <input type="hidden" name="cat_id" value="<?= Input::get('category_id')?>">
          <input type="hidden" name="category" value="<?= Input::get('category')?>">
         <input type="hidden" name="sub_cat_id" value="<?= Input::get('id')?>">
        </div>
      </div>
    
    </div><!--row-->
    
   <div class="col-md-4 pull-right">
	<input name="create_sub_cat" type="submit" value="Submit" class="btn btn-success btn-block" />
  </div>
  </div>
  
			   
			  
  </form>
  <div class="box-header with-border">
    <h3 class="box-title">Products For <?= Input::get('category') ?></h3>
    <div class="box-tools pull-right">
      <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
    </div>
  </div>
  <div class="box-body">
    <table id="uploaded_product_table" class="table table-bordered table-striped">
    
      <thead>
        <tr>
          <th>#</th>
          <th>Name </th>
          <th>Number of Products</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
          <?php foreach ($sub_cat as $details):?>
          <tr>
              <td><?= $details->sub_cat_id ?></td>
              <td><?= $details->name ?></td>
              <td><?= count(ProductSubCat::getInstance()->hasMany( $details->sub_cat_id)) ?></td>
              <td>
                 <button  onclick="location.href='index.php?p=addproduct&subcatid=<?=$details->sub_cat_id ?>&category=<?= $details->name?>' "  class="btn btn-sm btn-primary">
                 <i class="fa fa-plus" aria-hidden="true"></i>
                 &nbsp; Add Product</button>
                 <button onclick="location.href='index.php?p=sub_category&category=<?= Input::get('category') ?>&id=<?=$details->sub_cat_id ?>&update=true&category_id=<?= Input::get('category_id')?>' "  class="btn btn-sm btn-warning"><i class="fa fa-pencil-square-o"></i>&nbsp; Update </button>
              <button  onclick="location.href='modules/SubCategory/crud.php?id=<?= $details->sub_cat_id?>&action=delete' "   class="btn btn-sm btn-danger"><i class="fa fa-trash"></i>&nbsp; Delete </button>
         
             </td>
             </tr>
					  
		   <?php endforeach;?>	      
            
            
                
        </tbody>
      <tfoot></tfoot>
    
    </table>
  </div><!--box-body-->
  