<form role="form" method="POST" action="modules/update_cybersale.php" enctype="multipart/form-data">
<input type="hidden" name="prod-id" value="<?php echo $_GET['id']; ?>">
<input type="hidden" name="page" value="<?php echo $_GET['page']; ?>">
  <div class="box-body">
    <div class="row">
      <div class="col-md-3">
        <div class="form-group">
          <?php
            $data = mysqli_query($GLOBALS['dbc'], "SELECT * FROM cybersale WHERE id = $prod_id");
            $row = mysqli_fetch_array($data);
          ?>
          <label>Product Name</label>
          <input type="text" class="form-control" name="prod-name" value="<?php echo $row['name']; ?>" />
        </div>
      </div>
      <div class="col-md-3">
        <div class="form-group">
          <label>Product Price</label>
          <input type="text" class="form-control" name="prod-price" value="<?php echo $row['price']; ?>" />
        </div>
      </div>
      <div class="col-md-3">
        <div class="form-group">
          <label>Product Weight</label>
          <input type="text" class="form-control" name="prod-weight" value="<?php echo $row['weight']; ?>" />
        </div>
      </div>
    </div><!--row-->
    <div class="row">
      <div class="col-md-4">
        <div class="form-group">
          <label>Product Description</label>
          <textarea class="form-control" name="prod-desc" rows="3" placeholder="Enter product description">
            <?php echo $row['prd_desc']; ?>
          </textarea>
        </div>
      </div>
      <div class="col-md-4">
        <div class="form-group">
          <label>Physical Decsription</label>
          <textarea class="form-control" name="phy-desc" rows="3" placeholder="Enter physical description">
            <?php echo $row['phy_desc']; ?>
          </textarea>
        </div>
      </div>
    </div><!--row-->
    <div class="row">
      <div class="col-md-4">
        <div class="form-group">
          <label>Product Image 1</label>
          <input type="file" class="form-control" name="img1" />
        </div>
      </div>
      <div class="col-md-4">
        <div class="form-group">
          <label>Product Image 2</label>
          <input type="file" class="form-control" name="img2" />
        </div>
      </div>
      <div class="col-md-4">
        <div class="form-group">
          <label>Product Image 3</label>
          <input type="file" class="form-control" name="img3" />
        </div>
      </div>
    </div><!--row-->
  </div><!--box-body-->
  <div class="box-footer">
    <div class="col-md-4 pull-right">
      <button type="submit" class="btn btn-warning btn-block"><i class="fa fa-pencil-square-o"></i>&nbsp; UPDATE PRODUCT</button>
    </div>
  </div>
</form>