 <?php   $errorBag = ['ww','The Subcategory already has a deal!!','Product already has a deal','Product already has a deal'];
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
<form role="form" method="POST" action="modules/add_delete_deal.php">
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
        </div>
      </div>
      <div class="col-md-4">
        <div class="form-group">
          <label>Select product Category / Subcategory</label>
          <select name="deal-subcategory" class="form-control">
          <?php
            $data = mysqli_query($GLOBALS['dbc'], "SELECT cat_id, UPPER(name) AS name FROM product_cats");
            while($row = mysqli_fetch_array($data)) {
              $cat_name = $row['name'];
              $cat_id = $row['cat_id'];
              echo "<optgroup label='$cat_name'>";
                if ($cat_id != 6 && $cat_id != 8) {
                echo "<option value='$cat_name'>ALL $cat_name</option>";
                $data2 = mysqli_query($GLOBALS['dbc'], "SELECT * FROM product_sub_cats WHERE cat_id = $cat_id");
                while ($row2 = mysqli_fetch_array($data2)) { ?>
                  <option value="<?= $row2['sub_cat_id']; ?>"><?= $row2['name']; ?></option>
          <?php  
                }
              echo "</optgroup>";
              }
              else {
                echo "<option value='$cat_name'>ALL $cat_name</option>";
              }
            } 
          ?>
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
    <h3 class="box-title">Deals List</h3>
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
        $data = mysqli_query($GLOBALS['dbc'], "SELECT * FROM deals WHERE deal_type = 'sub_category' ORDER BY id DESC ");

        if (mysqli_num_rows($data) == 0) {
          echo 'Empty record';
        }

        else {
          $c = new Category();

          while ($row = mysqli_fetch_array($data)) { 
            $c = $c->get_by_id($row['cat_id']);
            $cat_name = $c->get('name');
            if($row['sub_cat_id'] == '0') {
               $sub_cat_name = 'ALL';
            }

            else {
              $sub_categories = $c->subcategories();
              if($sub_categories) {
                while($row2 = mysqli_fetch_array($sub_categories)) {
                  if ($row['sub_cat_id'] == $row2['sub_cat_id']) {
                    $sub_cat_name = $row2['name'];
                  }
                }
              }
              else {
                $sub_cat_name = 'ALL';
              }
            }
            ?>
            <tr>
              <td><?= $row['id']; ?></td>
              <td><?= $row['deal_value']; ?></td>
              <td><?= $row['valid_to']; ?></td>
              <td><?= $cat_name; ?></td>
              <td><?= $sub_cat_name; ?></td>
              <td>
                <button data-deal-id="<?= $row['id']; ?>" type="submit" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i>&nbsp; Delete</button>
              </td>
            </tr>
        <?php }
        }
      ?>
      </tbody>
      <tfoot></tfoot>
    </form>
    </table>
  </div><!--box-body-->
</div><!--box-->