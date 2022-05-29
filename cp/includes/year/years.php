<?php
$year = new Year();
$answer = '';
$status = '';
if(Input::exists('get') && Input::get('id')  && !Input::get('update') ){
   if($year->delete('id', Input::get('id')) ) { 
   	$answer = 'year Deleted';
   	$status = 'success';
   } else { 
   	$answer=join('<br/>', $year->errors);
   	$status = 'error';
   }	
}
if(Input::exists('post')){
if ($year->save()){
	 $answer = $year->msg;
	 $status = 'success';
	 

} else {
	$answer=join('<br/>', $year->errors);
	$status = 'error';
}
}

if(Input::exists('get') && Input::get('update')){
	$details=$year->find('year_id', Input::get('update'));
}

?>

<div style="" ><?= message($answer,$status); ?></div>
<form role="form" method="POST" action="/cp/index.php?p=years" enctype="multipart/form-data">
<input type="hidden" name="sub-cat-id" value="1">
  <div class="box-body">
   
    <div class="row">
      <div class="col-md-6">
        <div class="form-group">
          <label>Year</label>
          <input class="form-control" required="required" name="years"   type="text">
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
    <h3 class="box-title">year</h3>
    <div class="box-tools pull-right">
      <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
    </div>
  </div>
  <div class="box-body">
    <table id="uploaded_product_table" class="table table-bordered table-striped">
    <form method="GET" action="modules/add_delete_year.php"></form>
      <thead>
        <tr>
          <th>#</th>
          <th>Year</th>
          
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
          <?php foreach ($year->all() as $details):?>
          <tr>
              <td><?= $details->id ?></td>
              <td><?= $details->year ?></td>
             
              
              <td>
                
                 <button  onclick="location.href='index.php?p=years&id=<?= $details->id ?>'"  class="btn btn-sm btn-danger"><i class="fa fa-trash"></i>&nbsp; Delete </button>
          
             </td>
             </tr>
					  
		   <?php endforeach;?>	      
            
            
                
        </tbody>
      <tfoot></tfoot>
    
    </table>
  </div><!--box-body-->
  