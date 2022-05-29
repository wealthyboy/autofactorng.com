    <?php 
          if ( isset($_POST['q']) ){
        $q  =  $_POST['q'];
        $m_get_sent_mails = DB::getInstance()->run_sql("
                     SELECT  * FROM order_email WHERE email LIKE '%$q%' OR id LIKE '%$q%' ORDER BY id DESC ");  
        $data = DB::getInstance()->run_sql("SELECT orders.* , users.* FROM orders INNER JOIN users ON orders.user_id = users.id WHERE orders.order_type != 'offline'  AND users.email LIKE '%$q%'  ORDER BY orders.order_id DESC"); 
                     
    } else {
        $data = DB::getInstance()->run_sql("SELECT orders.* , users.* FROM orders INNER JOIN users ON orders.user_id = users.id WHERE orders.order_type != 'offline'  ORDER BY orders.order_id DESC LIMIT 20"); 
        
    }?>
        
       <div class="row text-center">
         <form role="form" method="POST" action="">

              <div class="col-lg-6 col-md-3">
                <div class="input-group">
                  <input type="text" name="q" class="form-control" placeholder="Search for...">
                  <span class="input-group-btn">
                    <button  class="btn btn-default" type="submit">Search</button>
                  </span>
                </div><!-- /input-group -->
              </div><!-- /.col-lg-6 -->
               <div class="col-lg-6 col-md-3">
                 <a href="">Back <<<</a>
              </div><!-- /.col-lg-6 -->
          </form>
          
          
        </div><!-- /.row -->
    
    <table id="uploaded_product_table" class="table table-bordered table-hover table-striped">
      <thead>
        <tr>
          <th>Order ID</th>
          <th>Customer Name</th>
          <th>Address</th>
          <th>Phone</th>
          <th>Email</th>
          <th>Order Date</th>
          <th>Order Time</th>
          <th>Payment Type</th>
          <th>Order Status</th>
          <th>View Order</th>
          <th>Invoice</th>
        </tr>
      </thead>
      <tbody>
      <?php

        if (empty($data)) {
          echo 'Empty record';
        }

        else {
          foreach ($data as $details){
        

          $payment_method = ($details->payment_method == 'cash' ? 'Cash on Delivery' : 'Credit Card'); ?>
            <tr>
              <td><?= $details->order_id ?></td>
              <td><?= $details->first_name . ' ' . $details->last_name; ?></td>
              <td><?= $details->address; ?></td>
              <td><?= $details->phone; ?></td>
              <td><?= $details->email; ?></td>
              <td><?= $details->order_date; ?></td>
              <td><?= $details->order_time; ?></td>
              <td><?= $details->payment_method; ?></td>
              <td>
                <select name="order-status" class="form-control">
                  <option value="Confirmed" <?= ($details->order_status== 'Confirmed' ? 'selected="selected"' : ''); ?>>Confimed &amp; Processing</option>
                  <option  value="Processing" <?= ($details->order_status == 'Processing' ? 'selected="selected"' : ''); ?>>Processing &amp; Shipped</option>
                  <option value="Shipped" <?= ($details->order_status== 'Shipped' ? 'selected="selected"' : ''); ?>>Shipped</option>
                  <option value="Delivered" <?= ($details->order_status == 'Delivered' ? 'selected="selected"' : ''); ?>>Delivered</option>
                </select>
                <p class="text-center"><button data-order-id="<?= $details->order_id?>" class="btn btn-warning btn-block order-status-update-button">Update</button></p>
              </td>
              <td><a href="modules/view_orders.php?order_id=<?php echo $details->order_id ?>">View Order</a></td>
              <td>
                <form method="GET" action="includes/invoice_preview.php">
                  <input type="hidden" name="order-id" value="<?= $details->order_id; ?>">
                  <p>Shipping</p>
                  <p><input type="number" name="invoice-shipping" value="1000" placeholder="e.g 1800"></p>
                  <button data-order-id="<?= $details->order_id ?>" class="btn btn-sm btn-default">Create Invoice</button>
                </form>
              </td>
            </tr>
        <?php }
        }
      ?>
      </tbody>
      <tfoot></tfoot>
    </table>
  </div><!--box-body-->
</div><!--box-->