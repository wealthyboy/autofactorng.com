
<form role="form" method="POST" action="/cp/modules/add_funds.php?id=<?php  echo $_GET['id']; ?>">
<h3>&nbsp;Add Funds</h3>
  <div class="box-body">
    <div class="row">
        <div class="col-md-6">
        <div class="form-group">
          <label>Amount</label>
          <input type="text" class="form-control" name="amount" placeholder="Enter Amount " />
        </div>
      </div>
      
        <div class="col-md-6">
        <div class="form-group">
          <label>Type</label>
          <select required name="type" class="form-control">
            <option value="">Type</option>
            <option value="1">Add</option>
            <option value="0">Substract</option>
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





