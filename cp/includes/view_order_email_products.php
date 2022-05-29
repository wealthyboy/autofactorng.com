<?php require_once '../classes/class.state.php';
      require_once '../classes/class.ordered_product.php';
  ?>


</div><!--close this div to create another box-->

<div class="box">
  <div class="box-header">
    <h3 class="box-title">Product</h3>
  </div>
  <div class="box-body">
    <table class="table table-striped table-hover">
      <thead>
        <tr>
          <th>Order Id</th>
          <th>Item Name</th>
          <th>Item Price</th>
        
        </tr>
      </thead>
      <tbody>
      <?php
      if (isset($_GET['id'])) {
      	$order_id=Ordered_Product::getInstance()->prep($_GET['id']);
      }
        $m_get_sent_mail = Ordered_Product::getInstance()->run_sql("SELECT * FROM ordered_product WHERE order_id = '$order_id' ");
         
     
     
         if (count($m_get_sent_mail)) {
         	
         
          foreach ($m_get_sent_mail as $details) { 
          	
             ?>
            <tr>
              <td><?= $details->order_id; ?></td>
              <td><?= $details->item_name; ?></td>
              
              
              <td><?= $details->item_price; ?></td>
              
               
             
            </tr>
      <?php
          }
        }
      ?>
      </tbody>
    </table>
  </div>
</div>