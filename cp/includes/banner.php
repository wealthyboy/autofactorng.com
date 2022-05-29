<?php
$banner = new Banner();
$answer = '';
$status = '';
if(Input::exists('get') && Input::get('id')  && !Input::get('update') ){
   if($banner->delete('banner_id', Input::get('id')) ) { 
   	$answer = 'Banner Deleted';
   	$status = 'success';
   } else { 
   	$answer=join('<br/>', $banner->errors);
   	$status = 'error';
   }	
}
if(Input::exists('post')){
if ($banner->save()){
	 $answer = $banner->msg;
	 $status = 'success';
	 

} else {
	$answer=join('<br/>', $banner->errors);
	$status = 'error';
}
}

if(Input::exists('get') && Input::get('update')){
	$details=$banner->find('banner_id', Input::get('update'));
}

?>

<div style="" ><?= message($answer,$status); ?></div>
<form role="form" method="POST" action="/cp/index.php?tbl=banner" enctype="multipart/form-data">
<input type="hidden" name="sub-cat-id" value="1">
  <div class="box-body">
   
    <div class="row">
      <div class="col-md-3">
        <div class="form-group">
          <label>Title</label>
          <input class="form-control" required="required" name="title"  value="<?= !empty($details->title) ? $details->title : '' ?> "    type="text">
        </div>
      </div>
      <div class="col-md-3">
        <div class="form-group">
          <label>Link</label>
          <input class="form-control" required="required"  name="link" value="<?= !empty($details->link) ? $details->link : ''?>" type="text">
        </div>
      </div>
      <div class="col-md-3">
        <div class="form-group">
          <label>Sort Order</label>
          <input class="form-control" required="required"  value="<?= !empty($details->sort_order) ? $details->sort_order: ''?>" name="sort_order" type="number">
          <input type="hidden" name="banner_id" value="<?php echo Input::get('update')  ?>">
        </div>
      </div>  <div class="col-md-3">
        <div class="form-group">
         <label>Image </label>
          <input class="form-control" accept="image/*"  <?= !empty($details->image) ? '': 'required'?>  name="image" type="file">
          <input type="hidden" name="file_in_database" value="<?= !empty($details->image) ? $details->image: ''?>">
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
    <h3 class="box-title">Banner</h3>
    <div class="box-tools pull-right">
      <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
    </div>
  </div>
  <div class="box-body">
    <table id="uploaded_product_table" class="table table-bordered table-striped">
    <form method="GET" action="modules/add_delete_banner.php"></form>
      <thead>
        <tr>
          <th>#</th>
          <th>Title</th>
          <th>image</th>
          <th>Sort Order</th>
          <th>Link</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
          <?php foreach ($banner->all() as $details):?>
          <tr>
              <td><?= $details->banner_id ?></td>
              <td><?= $details->title ?></td>
              <td><img  width="50" height="50" src="/images/banner/<?= $details->image;?>" /></td>
              <td><?= $details->sort_order ?></td>
              <td><?= $details->link?></td>
              
              <td>
                 
                 <button onclick="location.href='index.php?tbl=banner&update=<?= $details->banner_id ?>'"  class="btn btn-sm btn-warning"><i class="fa fa-pencil-square-o"></i>&nbsp; Update </button>
          
                 <button  onclick="location.href='index.php?tbl=banner&id=<?= $details->banner_id ?>'"  class="btn btn-sm btn-danger"><i class="fa fa-trash"></i>&nbsp; Delete </button>
          
             </td>
             </tr>
					  
		   <?php endforeach;?>	      
            
            
                
        </tbody>
      <tfoot></tfoot>
    
    </table>
  </div><!--box-body-->
  