<form role="form" method="POST" action="modules/add_delete_tow_truck_driver.php">
  <div class="box-body">
    <div class="row">
      <div class="col-md-4">
        <div class="form-group">
          <label>Name</label>
          <input type="text" class="form-control" name="driver-name" placeholder="Driver name" />
        </div>
      </div>
      <div class="col-md-4">
        <div class="form-group">
          <label>Phone</label>
          <input type="text" class="form-control" name="driver-phone" placeholder="Phone number" />
        </div>
      </div>
      <div class="col-md-4">
        <div class="form-group">
          <label>Location</label>
          <input type="text" class="form-control" name="driver-location" placeholder="Location" />
        </div>
      </div>
    </div><!--row-->
  </div><!--box-body-->
  <div class="box-footer">
    <div class="col-md-3 pull-right">
      <button type="submit" class="btn btn-success btn-block">SAVE</button>
    </div>
  </div>
</form>
</div><!--box....included to nest another row div within included page-->

<div class="box box-default">
  <div class="box-header with-border">
    <h3 class="box-title">List of Tow Truck Drivers</h3>
    <div class="box-tools pull-right">
      <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
    </div>
  </div>
  <div class="box-body">
    <table id="uploaded_product_table" class="table table-bordered table-striped">
    <form method="GET">
      <thead>
        <tr>
          <th>#</th>
          <th>Name</th>
          <th>Phone</th>
          <th>Location</th>
          <th>Delete</th>
        </tr>
      </thead>
      <tbody>
      <?php
        $data = mysqli_query($GLOBALS['dbc'], "SELECT * FROM tow_truck_drivers");

        if (mysqli_num_rows($data) == 0) {
          echo 'Empty record';
        }

        else {
          while ($row = mysqli_fetch_array($data)) { ?>
            <tr>
              <td><?= $row['id']; ?></td>
              <td><?= $row['name']; ?></td>
              <td><?= $row['phone']; ?></td>
              <td><?= $row['location']; ?></td>
              <td>
                <button data-tow-driver-id="<?= $row['id']; ?>" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i>&nbsp; Delete</button>
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