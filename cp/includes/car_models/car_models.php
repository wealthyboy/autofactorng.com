<?php
$cars = new Cars();
$answer = '';
$status = '';
if(Input::exists('get') && Input::get('id')  && !Input::get('update') ){
   if($cars->delete('id', Input::get('id')) ) { 
   	$answer = 'brand Deleted';
   	$status = 'success';
   } else { 
   	$answer=join('<br/>', $cars->errors);
   	$status = 'error';
   }	
}
if(Input::exists('post')){
if ($cars->saveModel()){
	 $answer = $cars->msg;
	 $status = 'success';
	 

} else {
	$answer=join('<br/>', $cars->errors);
	$status = 'error';
}
}

if(Input::exists('get') && Input::get('update')){
	$details=$cars->find('cars_id', Input::get('update'));
}


  $car_models = Cars::getInstance()->find_where(Input::get('make_id'));
  $make =  CarBrands::getInstance()->find_by_id(Input::get('make_id'));
  // dd($car_models);

?>

<div style="" ><?= message($answer,$status); ?></div>
<form role="form" method="POST" action="" enctype="multipart/form-data">
<input type="hidden" name="sub-cat-id" value="1">
  <div class="box-body">
   
    <div class="row">
      <div class="col-md-6">
        <div class="form-group">
          <label>Models For <?= $make->name ?></label>
          <input class="form-control" required="required" name="model"     type="text">
            <input class="form-control" required="required" name="make"  value="<?= $make->name ?>"    type="hidden">
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
    <form method="GET" action=""></form>
      <thead>
        <tr>
          <th>#</th>
          <th>Car brand</th>
          
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
          <?php foreach ($car_models as $details):?>
          <tr>
              <td><?= $details->id ?></td>
              <td><?= $details->model ?></td>
             
              
              <td>
                  <button onclick="location.href='index.php?p=model_year&model_id=<?= $details->id ?>&make_id=<?= Input::get('make_id') ?>'"  class="btn btn-sm btn-warning"><i class="fa fa-pencil-square-o"></i>&nbsp; View/Add Year</button>


                 <button  onclick="location.href='index.php?p=car_models&id=<?= $details->id ?>&make_id=<?= Input::get('make_id')?>'"  class="btn btn-sm btn-danger"><i class="fa fa-trash"></i>&nbsp; Delete </button>
          
             </td>
             </tr>
					  
		   <?php endforeach;?>	      
            
            
                
        </tbody>
      <tfoot></tfoot>
    
    </table>
  </div><!--box-body-->
  