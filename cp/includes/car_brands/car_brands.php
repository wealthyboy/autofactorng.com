<?php
$car_brand = new CarBrands();
$answer = '';
$status = '';
if(Input::exists('get') && Input::get('id')  && !Input::get('update') ){
   if($car_brand->delete('id', Input::get('id')) ) { 
   	$answer = 'brand Deleted';
   	$status = 'success';
   } else { 
   	$answer=join('<br/>', $car_brand->errors);
   	$status = 'error';
   }	
}
if(Input::exists('post')){
if ($car_brand->save()){
	 $answer = $car_brand->msg;
	 $status = 'success';
	 

} else {
	$answer=join('<br/>', $car_brand->errors);
	$status = 'error';
}
}

if(Input::exists('get') && Input::get('update')){
	$details=$car_brand->find('car_brand_id', Input::get('update'));
}

?>

<div style="" ><?= message($answer,$status); ?></div>
<form role="form" method="POST" action="/cp/index.php?p=cars" enctype="multipart/form-data">
<input type="hidden" name="sub-cat-id" value="1">
  <div class="box-body">
   
    <div class="row">
      <div class="col-md-6">
        <div class="form-group">
          <label>Car Brand</label>
          <input class="form-control" required="required" name="name"     type="text">
        </div>
      </div>
     
    
      
    </div><!--row-->
    
   <div class="col-md-4 pull-right">
	<button type="submit" class="btn btn-success btn-block">SUBMIT</button>
  </div>
  </div>
  
			   
			  
  </form>
  
  <hr/>
  
  <div class="box-header with-border">
    <h3 class="box-title">Car Brand</h3>
    <div class="box-tools pull-right">
      <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
    </div>
  </div>
  <div class="box-body">
    <table id="uploaded_product_table" class="table table-bordered table-striped">
    <form method="GET" action="modules/add_delete_car_brand.php"></form>
      <thead>
        <tr>
          <th>#</th>
          <th>Car brand</th>
          
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
          <?php foreach ($car_brand->all() as $details):?>
          <tr>
              <td><?= $details->id ?></td>
              <td><?= $details->name ?></td>
             
              
              <td>
                  <button onclick="location.href='index.php?p=car_models&make_id=<?= $details->id ?>'"  class="btn btn-sm btn-warning"><i class="fa fa-pencil-square-o"></i>&nbsp; Add Model </button>

                 <button  onclick="location.href='index.php?p=cars&id=<?= $details->id ?>'"  class="btn btn-sm btn-danger"><i class="fa fa-trash"></i>&nbsp; Delete </button>
          
             </td>
             </tr>
					  
		   <?php endforeach;?>	      
            
            
                
        </tbody>
      <tfoot></tfoot>
    
    </table>
  </div><!--box-body-->
  