<?php require_once '../classes/class.state.php';?>


<?php
      
    if ( isset($_POST['q']) ){
        $q  =  ltrim(trim($_POST['q']));
        
        
        if (ctype_digit($q)) {
           $m_get_sent_mails = DB::getInstance()->run_sql("
                     SELECT  *  FROM 
                                 order_email
                                WHERE 
                                 order_id = $q LIMIT 1
                            ");  
        } else {
        
        $m_get_sent_mails = DB::getInstance()->run_sql("
                     SELECT  *  FROM 
                                 order_email
                                WHERE 
                                 email LIKE '%$q%' ORDER BY id DESC
                                
                            "); 
        }
                            
        
                     
    } else {
        $m_get_sent_mails = DB::getInstance()->run_sql("
                     SELECT  * FROM order_email ORDER BY id DESC LIMIT 60");
    }
    
     
?>
         
    

<form role="form" method="GET" action="includes/order_email_preview.php">
<h3>&nbsp;Order Email</h3>
  <div class="box-body">
    <div class="row">
        <div class="col-md-3">
        <div class="form-group">
          <label>Qty</label>
          <input type="text" class="form-control" name="quantity[]" placeholder="Enter Quantity " />
        </div>
      </div>
      <div class="col-md-3">
        <div class="form-group">
          <label>Product Name</label>
          <input type="text" class="form-control" name="product[]" placeholder="Enter product name" />
        </div>
      </div>
      <div class="col-md-3">
        <div class="form-group">
          <label>Product Price</label>
          <input type="text" class="form-control" name="price[]" placeholder="Product price" />
        </div>
      </div>
      
      
      
      <div class="col-md-3">
        <div class="form-group">
          <label>User</label>
          <select required name="user" class="form-control">
            <option value="">Choose One</option>
            <option value="Damilola">Damilola</option>
            <option value="Micheal Rex">Micheal Rex</option>
            <option value="Korede Aboidun">Korede aboidun</option>
            <option value="Others">Others</option>

          </select>
        </div>
      </div>
      
       
    </div><!--row-->
  </div><!--box-body-->
  <div class="box-footer">
      <div class="">
          
          
          <div class="col-md-3">
            <div class="form-group">
              <label>Type</label>
              <select  name="discount_type" class="form-control">
                <option value="">Choose One</option>
                <option value="percent">Percentage</option>
                <option value="fixed">Fixed</option>
              
              </select>
            </div>
          </div>
      
          <div class="col-md-3">
            <div class="form-group">
              <label>Discount</label>
              <input type="text" class="form-control" name="discount" placeholder="Enter discount" />
            </div>
          </div>
     
      
     
    </div><!--row-->
         
      
      <div class="col-md-3  pull-right">
        <div class="form-group">
          <label>Shipping</label>
          <input type="text" class="form-control" name="shipping" placeholder="Enter Shipping" />
        </div>
      </div>
      <div class="clearfix"></div>
     
      
     
    <div class="col-md-3 pull-right">
      <button id="add-field" type="button" data-type="order_email" class="btn btn-default btn-block"><i class="glyphicon glyphicon-plus"></i> Add another product</button>
      <button type="submit" class="btn btn-success btn-block">Submit</button>
    </div>
  </div>
</form>
</div><!--close this div to create another box-->



<div class="box">
  <div class="box-header">
    <h3 class="box-title">Sent Order Emails</h3>
  </div>
  <div class="box-body">
      <div class=" text-center">
         <form role="form" method="POST" action="">

              <div class="col-lg-6 col-md-3">
                <div class="input-group">
                  <input type="text" name="q" class="form-control" placeholder="Search for...">
                  <span class="input-group-btn">
                    <button  class="btn btn-default" type="submit">
                        Search
                    </button>
                  </span>
                </div><!-- /input-group -->
              </div><!-- /.col-lg-6 -->
              <div class="col-lg-6 col-md-3">
                 <a href="">Back <<<</a>
              </div><!-- /.col-lg-6 -->
          </form>
          
          
        </div><!-- /.row -->
    <table id="data-table" class="data-table table table-striped table-hover">
      <thead>
        <tr>
          <th>Order Id</th>
          <th>Email</th>
          <th>User</th>

          
      
          <th>Date</th>
          <th>Order Status</th>
        </tr>
      </thead>
      <tbody>
               
    <?php  if (count($m_get_sent_mails)) {
     	
     
        foreach ($m_get_sent_mails as $m_get_sent_mail) { 
        $order = Order::getInstance()->find_by_id($m_get_sent_mail->order_id); 
       
        $user_state = State::getInstance()->find_state($m_get_sent_mail->state_id); 
        ?>
      
            <tr>
              <td><?= $m_get_sent_mail->order_id; ?></td>
              <td><?= $m_get_sent_mail->email; ?></td>
              <td><?= $m_get_sent_mail->admin_user; ?></td>

              <td><?= $order->order_date; ?></td>
              <td>
                <select name="order-status" class="form-control">
                  <option value="Confirmed" <?= ($order->order_status == 'Confirmed' ? 'selected="selected"' : ''); ?>>Confimed &amp; Processing</option>
                  <option <?= ($user_state->name == 'Lagos' ? 'disabled' : ''); ?> value="Processing" <?= ($order->order_status == 'Processing' ? 'selected="selected"' : ''); ?>>Processing &amp; Shipped</option>
                  <option value="Shipped" <?= ($order->order_status == 'Shipped' ? 'selected="selected"' : ''); ?>>Shipped</option>
                  <option value="Delivered" <?= ($order->order_status == 'Delivered' ? 'selected="selected"' : ''); ?>>Delivered</option>
                </select>
                <p class="text-center"><button data-order-id="<?= $order->order_id ?>" class="btn btn-warning btn-block order-status-update-button">Update</button></p>
              </td>
                <td><button onclick="location.href='index.php?p=view_order_email_products&id=<?= $order->order_id; ?>'" class="btn btn-default">View Product</button></td>
              <form action="includes/order_email_invoice.php">
                <input type="hidden" name="order-type" value="offline">
                <input type="hidden" name="order-id" value="<?= $m_get_sent_mail->id; ?>">
                <td><button class="btn btn-default">Invoice</button></td>
              </form>
            </tr>
      <?php
          }
        }
      ?>
      </tbody>
    </table>
  </div>
</div>



