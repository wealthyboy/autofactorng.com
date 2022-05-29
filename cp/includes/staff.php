<?php 	
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
require_once $_SERVER["DOCUMENT_ROOT"].'/init/init.php';
$request = \Illuminate\Http\Request::capture();
?>

<?php
    $staff = null;
    if ($request->query('id') && !$request->query('edit')){
        $staff = Staff::find($request->query('id'));
    } 
    

    $staffs  = Staff::all();

?>
         
    
<?php if (!empty($staff)){ ?>
<form role="form" method="POST" action="modules/staff.php?edit=true&id=<?=  $staff->id ?>">
<?php } else {?>

<form role="form" method="POST" action="modules/staff.php">

<?php } ?>

<h3>&nbsp;Staffs</h3>
  <div class="box-body">
    <div class="row">
        <div class="col-md-4">
        <div class="form-group">
          <label>Full Name</label>
          <input type="text" class="form-control" value=" <?= !empty($staff)  ? $staff->name : '' ?>" name="full_name" placeholder="Full Name " />
        </div>
      </div>
      <div class="col-md-4">
        <div class="form-group">
          <label>Phone Number</label>
          <input type="text" class="form-control" value="<?= !empty($staff) ? $staff->phone : '' ?>" name="phone_number" placeholder="Phone Number" />
        </div>
      </div>
      <div class="col-md-4">
        <div class="form-group">
          <label>Role</label>
          <input type="text" class="form-control" value="<?= !empty($staff) ? $staff->role : '' ?>" name="role" placeholder="Role" />
        </div>
      </div>
      <div class="col-md-12">
        <div class="form-group">
          <label>Address</label>
          <input type="text" value="<?= !empty($staff) ? $staff->address : '' ?>" class="form-control" name="address" placeholder="Address" />
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
    <h3 class="box-title">Staffs</h3>
  </div>
  <div class="box-body">
      <div class=" text-center">
        
          
          
        </div><!-- /.row -->
    <table id="data-table" class="data-table table table-striped table-hover">
      <thead>
        <tr>
          <th> Id</th>
          <th>Full Name</th>
          <th>Phone Number</th>

          
      
          <th>Address</th>
          <th>Role</th>
         <th></th>

        </tr>
      </thead>
      <tbody>
          
           <?php foreach($staffs as $staff){ ?>
          <tr>
              <td></td>
              <td><?= $staff->name ?></td>
              <td><?= $staff->phone ?></td>
              <td><?= $staff->address ?></td>
             <td><?= $staff->role ?></td>


             <td><a href="modules/staff.php?id=<?=  $staff->id ?>" class="btn btn-danger">Delete</a></td>
             <td><a href="https://autofactorng.com/cp/index.php?p=staff&id=<?=  $staff->id ?>" class="btn btn-info">Edit</a></td>
            </tr>
            <?php  }?>
               
    
      </tbody>
    </table>
  </div>
</div>



