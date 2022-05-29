<?php
$answer = '';
$status = '';

$cat_products = Product_Products::getInstance()->find_where(Input::get('category_id'));
if(Input::get('update') == true){
	$details=Product_Products::getInstance()->find_by_id(Input::get('id'));
}
?>
  <div style="" ><?php   message(Session::get('msg'),Session::get('status'));?></div>
<form role="form" method="POST" action="modules/ProductProducts/crud.php">

  <div class="box-body">
   
    <div class="row">
      <div class="col-md-6">
        <div class="form-group">
          <label>Name</label>
          <input class="form-control" required="required" name="name"  value="<?= !empty($details->name) ? $details->name : '' ?>"    type="text">
       
          <input type="hidden" name="category" value="<?= Input::get('category')?>">
           <input type="hidden" name="product_id" value="<?= Input::get('category_id')?>">
        
          <input type="hidden" name="id" value="<?= Input::get('id')?>">
        </div>
      </div>
    
    </div><!--row-->
    
   <div class="col-md-4 pull-right">
	<input name="create" type="submit" value="Submit" class="btn btn-success btn-block" />
  </div>
  </div>
  
			   
			  
  </form>
  <div class="box-header with-border">
    <h3 class="box-title">Add Product For <?= Input::get('category') ?></h3>
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
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
          <?php foreach ($cat_products as $details):?>
          <tr>
              <td><?= $details->id ?></td>
              <td><?= $details->name ?></td>
              <td>
               
                 <button onclick="location.href='index.php?p=product_products&category=<?= Input::get('category') ?>&category_id=<?= Input::get('category_id')?>&id=<?=$details->id ?>&update=true' "  class="btn btn-sm btn-warning"><i class="fa fa-pencil-square-o"></i>&nbsp; Update </button>
              <button  onclick="location.href='modules/ProductProducts/crud.php?id=<?= $details->id?>&action=delete' "   class="btn btn-sm btn-danger"><i class="fa fa-trash"></i>&nbsp; Delete </button>
         
             </td>
             </tr>
					  
		   <?php endforeach;?>	      
            
            
                
        </tbody>
      <tfoot></tfoot>
    
    </table>
  </div><!--box-body-->
  