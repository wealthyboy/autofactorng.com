<?php
$cars = new Cars();
$answer = '';
$status = '';
$model =  Cars::getInstance()->find_by_id(Input::get('model_id'));

if (Input::exists('get') && Input::get('value')) {
     $year_to_delete = explode(',', $model->year);
     $key = array_search(Input::get('value'),$year_to_delete);
     if($key == 0 || $key >0){
         $new_year = array_splice($year_to_delete, $key);
         Cars::getInstance()->update(Input::get('model_id'),[
         'year'=>implode(',',$year_to_delete)
         ]);
     }
     

}

if(Input::exists('post')){
if ($cars->saveYear()){
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


  $car_models = CarBrands::getInstance()->hasMany(Input::get('make_id'));
  $make =  CarBrands::getInstance()->find_by_id(Input::get('make_id'));

   $model =  Cars::getInstance()->find_by_id(Input::get('model_id'));

?>

<div style="" ><?= message($answer,$status); ?></div>
<form role="form" method="POST" action="" enctype="multipart/form-data">
<input type="hidden" name="sub-cat-id" value="1">
  <div class="box-body">
   
    <div class="row">
      <div class="col-md-6">
        <div class="form-group">
          <label>Add Year</label>
          <input class="form-control" required="required" name="year"  type="text">
           
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
    <h3 class="box-title">Add Year</h3>
    <div class="box-tools pull-right">
      <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
    </div>
  </div>
  <div class="box-body">
    <div class="col-md-6">
      
      <table id="uploaded_product_table" class="table table-bordered table-striped">
    <form method="GET" action="modules/add_delete_cars.php"></form>
      <thead>
        <tr>
         
          <th>Make</th>
          
          <th>Model</th>
        </tr>
      </thead>
      <tbody>
         
          <tr>
              <td><?= $make->name ?></td>
              <td><?= $model->model ?></td>
          </tr>
            
        </tbody>
      <tfoot></tfoot>
    
    </table>
    </div>
    <div class="col-md-6">
      
      <table id="uploaded_product_table" class="table table-bordered table-striped">
    <form method="GET" action="modules/add_delete_cars.php"></form>
      <thead>
        <tr>
          
          <th>Year</th>
          
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
          <?php  $years  = explode(',',$model->year);
                      sort($years); 
                 foreach ( $years as $value) {
                   # code...
          ?>

          <tr>
              
              <td><?= $value ?></td>
              <td>
                  

                 <button  onclick="location.href='/cp/modules/delete_year.php?model_id=<?= Input::get('model_id') ?>&make_id=<?=Input::get('make_id') ?>&value=<?= $value?>'"  class="btn btn-sm btn-danger"><i class="fa fa-trash"></i>&nbsp; Delete </button>
             </td>
             </tr>
          <?php } ?>
            
          
            
            
                
        </tbody>
      <tfoot></tfoot>
    
    </table>
    </div>
    
  </div><!--box-body-->
  