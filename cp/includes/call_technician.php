<div class="box box-default">
  <div class="box-header with-border">
    <h3 class="box-title">Technician Request</h3>
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
          <th>Email</th>
          <th>City</th>
          <th>Problem</th>
          <th>Day</th>
          <th>Date</th>
          <th>Time</th>
        </tr>
      </thead>
      <tbody>
      <?php
        $data = mysqli_query($GLOBALS['dbc'], "SELECT * FROM call_a_tech");

        if (mysqli_num_rows($data) == 0) {
          echo 'Empty record';
        }

        else {
          while ($row = mysqli_fetch_array($data)) { ?>
            <tr>
              <td><?= $row['id']; ?></td>
              <td><?= $row['name']; ?></td>
              <td><?= $row['phone']; ?></td>
              <td><?= $row['email']; ?></td>
              <td><?= $row['city']; ?></td>
              <td><?= $row['problem']; ?></td>
              <td><?= $row['day']; ?></td>
              <td><?= $row['date']; ?></td>
              <td><?= $row['time']; ?></td>
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