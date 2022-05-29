<form role="form" method="POST" action="modules/update_price.php">
<h3>&nbsp;Product Price Update</h3>
  <div class="box-body">
    <div class="row">
      <div class="col-md-4">
        <div class="form-group">
          <label>Select Product</label>
          <select id="prod-names" name="prod-name" class="form-control select2" style="width: 100%;">
          <optgroup label="SPARE PARTS">
          <?php
            $query = "SELECT name FROM product_types WHERE cat_id = 1 ORDER BY name ASC";
            $data = mysqli_query($GLOBALS['dbc'], $query);
            while($row = mysqli_fetch_array($data)) { ?>
              <option value="<?= $row['name']; ?>" data-table-name="spare_parts"><?= $row['name']; ?></option>
          <?php  }
          ?>
          <option value="KYB Shocks (Front)" data-table-name="spare_parts">KYB Shocks (Front)</option>
          <option value="KYB Shocks (Rear)" data-table-name="spare_parts">KYB Shocks (Rear)</option>
          </optgroup>
          <optgroup label="SERVICING PARTS">
          <?php
            $query = "SELECT name FROM product_sub_cats WHERE cat_id = 2 ORDER BY cat_id, name ASC";
            $data = mysqli_query($GLOBALS['dbc'], $query);
            while($row = mysqli_fetch_array($data)) { ?>
              <option value="<?= $row['name']; ?>" data-table-name="servicing_parts"><?= $row['name']; ?></option>
          <?php  }
          ?>
          </optgroup>
          <optgroup label="ACCESSORIES">
            <option value="3" data-table-name="accessories">All Accessories</option>
          </optgroup>
          <optgroup label="CAR CARE, GADGETS/TOOLS">
            <option value="4" data-table-name="car_care">All car care, gadgets/tools</option>
          </optgroup>
          <optgroup label="GRILLE GUARDS">
          <?php
            $query = "SELECT name FROM product_sub_cats WHERE cat_id = 5 ORDER BY cat_id, name ASC";
            $data = mysqli_query($GLOBALS['dbc'], $query);
            while($row = mysqli_fetch_array($data)) { ?>
              <option value="<?= $row['name']; ?>" data-table-name="grille_guards"><?= $row['name']; ?></option>
          <?php  }
          ?>
          </optgroup>
          <optgroup label="WHEELS/TYRES">
            <option value="6" data-table-name="tyres">All Tyres</option>
            <option value="6" data-table-name="wheels">All Wheels</option>
          </optgroup>
          <optgroup label="LUBRICANTS/FLUIDS">
            <option value="7" data-table-name="lubricants">All lubricants/fluids</option>
          </optgroup>
          <optgroup label="BATTERIES">
          <?php
            $query = "SELECT name FROM product_sub_cats WHERE cat_id = 8 ORDER BY cat_id, name ASC";
            $data = mysqli_query($GLOBALS['dbc'], $query);
            while($row = mysqli_fetch_array($data)) { ?>
              <option value="<?= $row['name']; ?>" data-table-name="batteries"><?= $row['name']; ?></option>
          <?php  }
          ?>
          </optgroup>
          </select>
        </div>
      </div>
      <!--<div class="col-md-4">
        <div class="form-group">
          <label>Email Address</label>
          <input type="text" class="form-control" name="email" placeholder="Customer email" />
        </div>
      </div>-->
    </div><!--row-->
    <div class="form-group">
      <div class="radio">
        <label>
          <input type="radio" name="price-type" value="fixed" required="required" />
          Fixed
        </label>
      </div>
      <div class="radio">
        <label>
          <input type="radio" name="price-type" value="percentage" required="required" />
          Percentage
        </label>
      </div>
    </div>
    <div class="row">
      <div class="col-md-4">
        <div class="form-group">
          <label>Update price by</label>
          <input type="number" class="form-control" name="price" placeholder="e.g 2500, -500, 5%, -2%" />
        </div>
      </div>
    </div><!--row-->
  </div><!--box-body-->
  <div class="box-footer">
    <div class="col-md-3 pull-right">
      <button type="submit" id="update_price" class="btn btn-success btn-block">Update Price</button>
    </div>
  </div>
</form>