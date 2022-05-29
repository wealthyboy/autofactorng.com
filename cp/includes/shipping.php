<?php 	
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
require_once $_SERVER["DOCUMENT_ROOT"].'/init/init.php';
?>

<?php
      
    $states = State::all();
    $shipping = Shipping::all();

?>
         
    

<form role="form" method="POST" action="modules/shipping.php">
<h3>&nbsp;SHIPPING</h3>
  <div class="box-body">
    <div class="row">
        
      
      <div class="col-md-3">
        <div class="form-group">
          <label>Price</label>
          <input type="text" class="form-control" name="price" placeholder="Shipping price" />
        </div>
      </div>
      <div class="col-md-3">
        <div class="form-group">
          <label>State</label>
          <select required name="state_id" class="form-control">
           
            <?php foreach($states as $state){ ?>
                <option value="<?= $state->id ?>"><?= $state->name ?></option>
            <?php } ?>
          </select>
        </div>
      </div>
      
       
    </div><!--row-->
  </div><!--box-body-->
  <div class="box-footer">
    <div class="col-md-3 pull-right">
      <button type="submit" class="btn btn-success btn-block">Submit</button>
    </div>
  </div>
</form>
</div><!--close this div to create another box-->



<div class="box">
  <div class="box-header">
    <h3 class="box-title">Shipping</h3>
  </div>
  <div class="box-body">
      
    <table id="data-table" class="data-table table table-striped table-hover">
      <thead>
        <tr>
          <th>Id</th>
          <th>Price</th>
          <th>State</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
          <?php foreach($shipping as $ship){ ?>
          <tr>
              <td></td>
              <td><?= $ship->price ?></td>
              <td><?= $ship->state->name ?></td>
             <td><a href="modules/shipping.php?id=<?=  $ship->id ?>" class="btn btn-danger">Delete</a></td>
              
            </tr>
            <?php  }?>
               
   
      </tbody>
    </table>
  </div>
</div>



