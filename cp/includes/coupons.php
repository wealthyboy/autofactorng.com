<form role="form" method="POST" action="/cp/modules/add_delete_coupon.php">
  <div class="box-body">
    <div class="row">
      <div class="col-md-3">
        <div class="form-group">
          <label>Coupon Code</label>
          <input type="text" class="form-control" name="coupon-code" placeholder="Coupon code" required="required" />
        </div>
      </div>
      <div class="col-md-3">
        <div class="form-group">
          <label>Coupon Value</label>
          <input type="text" class="form-control" name="coupon-value" placeholder="Coupon value" required="required" />
        </div>
      </div>
    </div><!--row-->
    <div class="form-group">
      <div class="radio">
        <label>
          <input type="radio" name="coupon-type" value="fixed" required="required" />
          Fixed
        </label>
      </div>
      <div class="radio">
        <label>
          <input type="radio" name="coupon-type" value="percentage" required="required" />
          Percentage
        </label>
      </div>
    </div>
    <div class="row">
      <div class="col-md-4">
        <div class="form-group">
          <label>Expires</label>
          <input type="date" class="form-control" name="coupon-expiry" required="required" />
        </div>
      </div>
      <div class="col-md-4">
        <div class="form-group">
          <label>Select Type</label>
          <select name="type" class="form-control" required>
          
              <option value="general">General</option>
              <option value="specific">Specific</option>

          </select>
        </div>
      </div>
      <div class="col-md-4">
        <div class="form-group">
          <label>Select product Category</label>
          <select name="coupon-category" class="form-control">
          <?php
            $data = mysqli_query($GLOBALS['dbc'], "SELECT * FROM product_cats");
            while ($row = mysqli_fetch_array($data)) { ?>
              <option value="<?= $row['cat_id']; ?>"><?= $row['name']; ?></option>
          <?php  
            } 
          ?>
          <option value="99">All</option>
          </select>
        </div>
      </div>
    </div><!--row-->
  </div><!--box-body-->
  <div class="box-footer">
    <div class="col-md-3 pull-right">
      <button type="submit" class="btn btn-success btn-block"><i class="fa fa-tag"></i>&nbsp; Create Coupon</button>
    </div>
  </div>
</form>
</div><!--box....included to nest another row div within included page-->

<div class="box box-default">
  <div class="box-header with-border">
    <h3 class="box-title">List of Coupons</h3>
    <div class="box-tools pull-right">
      <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
    </div>
  </div>
  <div class="box-body">
    <table id="uploaded_product_table" class="table table-bordered table-striped">
    <form method="GET" action="/modules/add_delete_coupon.php">
      <thead>
        <tr>
          <th>#</th>
          <th>Coupon Code</th>
          <th>Value</th>
          <th>Discount Type</th>
          <th>Type</th>

          <th>Expires</th>
          <th>Category</th>
          <th>Status</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
      <?php
        $data = mysqli_query($GLOBALS['dbc'], "SELECT * FROM coupons ORDER BY id DESC");

        if (mysqli_num_rows($data) == 0) {
          echo 'Empty record';
        }

        else {
          $c = new Category();
          while ($row = mysqli_fetch_array($data)) { 
            $cat = $c->get_by_id($row['cat_id']); ?>
            <tr>
              <td><?= $row['id']; ?></td>
              <td><?= $row['coupon_code']; ?></td>
              <td><?= $row['coupon_value']; ?></td>
              <td><?= $row['coupon_type']; ?></td>
              <td><?= $row['type']; ?></td>
              <td><?= $row['valid_to']; ?></td>
              <td><?= $cat->get('name'); ?></td>
              <td><?= $row['status']; ?></td>
              <td>
              <?php
                if ($row['status'] == 'active') { ?>
                  <input type="hidden" name="coupon-id" value="<?= $row['id']; ?>">
                  <button data-coupon-id="<?= $row['id']; ?>" type="submit" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i>&nbsp; Delete</button>
              <?php
                }
              ?> 
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