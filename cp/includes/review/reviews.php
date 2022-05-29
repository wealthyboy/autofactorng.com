<?php
$answer = '';
$status = '';

$reviews = new Reviews();

if(Input::exists('get') && Input::get('id')  && !Input::get('update') ){
   if($reviews->delete('id', Input::get('id')) ) {
     Reply::getInstance()->delete('review_id',Input::get('id')); 
     $answer = 'Deleted';
     $status = 'success';
   } else { 
    $answer=join('<br/>', $reviews->errors);
    $status = 'error';
   }  
}

if(Input::exists('get') && Input::get('review_id')){

   $review=$reviews->find('id', Input::get('review_id'));
   $reply = Reply::getInstance()->find('review_id',Input::get('review_id'));
}
?>
<div style="" ><?= message($answer,$status); ?></div>

<?php if(Input::get('view')){ ?>
<form role="form" method="POST" action="/cp/modules/reply/crud.php" enctype="multipart/form-data">
<input type="hidden" name="sub-cat-id" value="1">
  <div class="box-body">
   
    <div class="row">
       <div class="col-md-6">
        <div class="form-group">
          <label>Product Name</label>
          <input disabled="disabled" class="form-control" name="title" value="<?= !empty($review->product_name) ? $review->product_name : '' ?>" type="text">
        </div>
        <div class="form-group">
          <label>Review Title</label>
          <input disabled="disabled" class="form-control" name="title" value="<?= !empty($review->title) ? $review->title : '' ?>" type="text">
        </div>

        <div class="form-group">
          <label>Review Description</label>
          <textarea  disabled="disabled" class="form-control" name="" type="text"><?=  !empty($review->description) ? $review->description : ''  ?></textarea>
        </div>
       </div>

     </div> 
    <div class="row"> 
     
      
       <div class="col-md-6">
         <div class="form-group">
          <label>Reply Message</label>
          <textarea   class="form-control" name="reply" type="text"><?php echo Input::get('update') == true ?  $reply->reply : '';  ?></textarea>
           <input class="form-control" name="action" type="hidden" value="create" /> 
          <input class="form-control" name="review_id" type="hidden" value="<?= Input::get('review_id')?>" /> 
          <input class="form-control" name="reply_id" type="hidden" value="<?=  $reply->id ?>" /> 
        </div>
       <button type="submit" class="btn btn-success btn-block">SUBMIT</button>
      </div>
    </div>
  
         
        
  </form>
<?php }?>

<?php if(!Input::get('view')){ ?>

  <div class="box-header with-border">
    <h3 class="box-title">All Reviews</h3>
    
  </div>
  <div class="box-body">
    <table id="uploaded_product_table" class="table table-bordered table-striped">
    
      <thead>
        <tr>
          <th>#</th>
          <th>Product Image</th>
          <th>Product Name</th>
          <th>Product Price</th>
          <th>Review Title</th>
          <th>Replies</th>
          
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php  if (count($reviews->all() ) ){ ?>
          <?php foreach ($reviews->all() as $details):?>
          <tr>
              <td><?= $details->id ?></td>
              <td><img width="50" height="50" src="/images/products/<?= $details->product_image ?>" /></td>
              <td><?= $details->product_name ?></td>
              <td><?= $details->product_price ?></td>
              <td><?= $details->title ?></td>
               <td> <a href="/cp/index.php?p=reviews&view=true&review_id=<?=$details->id ?>&update=true"><span class="label label-primary "><?php  echo Reply::replies($details->id) ?></span></a></td>

              <td>
                 <a  href='/cp/index.php?p=reviews&view=true&review_id=<?=$details->id ?>'  class="btn btn-sm btn-primary">
                 <i class="fa fa-plus" aria-hidden="true"></i>
                 &nbsp; View/Reply</a> 
                <button  onclick="location.href='/cp/index.php?p=reviews&id=<?=$details->id?>'"   class="btn btn-sm btn-danger"><i class="fa fa-trash"></i>&nbsp; Delete </button>
         
             </td>
             </tr>
					  
		   <?php endforeach;?>	      
            
           <?php } ?> 
                
        </tbody>
      <tfoot></tfoot>
    
    </table>
  </div><!--box-body-->
  <?php } ?>