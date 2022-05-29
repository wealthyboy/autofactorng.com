<?php  require_once $_SERVER["DOCUMENT_ROOT"].'/init/autoload.php'; 
  $errorBag = ['ww','A Subcategory that has this product  already exsits','Product already has a deal','Product already has a deal'];
  $answer = '';
  $status = '';

  switch (Input::get('error') ) {
    case '1':
      $answer = $errorBag[1];
      $status = 'error';
      break;
    case '2':
      $answer = $errorBag[2];
      $status = 'error';
      break;
    
    default:
     $answer = '';
     $status = '';
      break;
  }

  if ( Input::get('delete_id')){
     Deals::getInstance()->destroy(Input::get('delete_id'));
     $answer = 'Deal Removed';
     $status = 'success';
  }


?>
<div style="" ><?= message($answer,$status);  ?></div>
<form role="form" method="POST" action="modules/product_deals/crud.php">
  <div class="box-body">
    <div class="row">
      <div class="col-md-4">
        <div class="form-group">
          <label>Deal Value</label>
          <input type="text" class="form-control" name="deal-value" placeholder="Deal value" required="required" />
        </div>
      </div>
      <div class="col-md-4">
        <div class="form-group">
          <label>Expires</label>
          <input type="date" class="form-control" name="deal-expiry" required="required" />
         
          <input type="hidden" class="form-control" name="cat_id" value="<?= Input::get('catid') ?>"/ />
          <input type="hidden" class="form-control" name="type" value="multiple_product"/ />
        </div>
      </div>

      <div class="col-md-4">
        <div class="form-group">
          <label>Select product Category / Subcategory</label>
          <select name="sub_cat_id" id="sub_cats_deals" class="form-control">
         
          <?php $product_sub_cats =  ProductSubCat::getInstance()->all();

                if (count($product_sub_cats)) {
                   foreach ($product_sub_cats as  $details) { ?>
                     <option value="<?= $details->sub_cat_id  ?>"><?= $details->name ?></option>
            <?php }
                }
                ?>
          </select>
        </div>
      </div>


         <div class="col-md-4">
        <div class="form-group">
          <label>Products </label>
          <select id="sub_cat_products_deals"  name="product_name" class="form-control">
              <option value="">Select One</option>
          </select>
        </div>
      </div>
      
    </div><!--row-->
  </div><!--box-body-->
  <div class="box-footer">
    <div class="col-md-3 pull-right">
      <button type="submit" class="btn btn-success btn-block"><i class="fa fa-tag"></i>&nbsp; Create a Deal</button>
    </div>
  </div>
</form>
</div><!--box....included to nest another row div within included page-->

<div class="box box-default">
  <div class="box-header with-border">
    <h3 class="box-title">Product Deals List</h3>
    <div class="box-tools pull-right">
      <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
    </div>
  </div>
  <div class="box-body">
    <table id="uploaded_product_table" class="table table-bordered table-striped">
    <form method="GET" action="modules/add_delete_deal.php">
      <thead>
        <tr>
          <th>#</th>
          <th>Deal Value</th>
          <th>Expires</th>
          <th>Category</th>
          <th>Subcategory</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
      <?php
        if ($products = Deals::allSubCatProductDeals()){
         foreach ($products as $details) {   ?>
            
            <tr>
              <td><?= $details->id; ?></td>
              <td><?= $details->deal_value ?></td>
              <td><?= $details->valid_to ?></td>
              <td>#</td>
              <td><?= ProductSubCat::getInstance()->find_by_id($details->sub_cat_id)->name ?></td>
              <td>
                <a  href="<?= $_SERVER['PHP_SELF'] ?>?<?= $_SERVER['QUERY_STRING'] ?>&delete_id=<?= $details->id; ?> "class="btn btn-sm btn-danger"><i class="fa fa-trash"></i>&nbsp; Delete</a>
              </td>
            </tr>
        
        <?php 
          
        }
      }
      
      ?>
      </tbody>
      <tfoot></tfoot>
    </form>
    </table>
  </div><!--box-body-->
</div><!--box-->