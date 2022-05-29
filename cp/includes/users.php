 
    <?php
   
    
   require_once $_SERVER["DOCUMENT_ROOT"].'/init/init.php';
   


    // $count = DB::getInstance()->run_sql("SELECT users.*, state.name AS state_name FROM users INNER JOIN state ON (users.state_id = state.id) WHERE users.is_verified = 1 ");
    
    

    // $rowsperpage ='';
    //      // number of rows to show per page
    // $rowsperpage = 20;
    // // find out total pages
    // $totalpages = ceil(count($count) / $rowsperpage);

    // // get the current page or set a default
    // if (isset($_GET['page']) && is_numeric($_GET['page'])) {
    //    // cast var as int
    //    $currentpage = (int) $_GET['page'];
    // } else {
    //    // default page num
    //    $currentpage = 1;
    // } // end if

    // // if current page is greater than total pages...
    // if ($currentpage > $totalpages) {
    //    // set current page to last page
    //    $currentpage = $totalpages;
    // } // end if
    // // if current page is less than first page...
    // if ($currentpage < 1) {
    //    // set current page to first page
    //    $currentpage = 1;
    // } // end if

    // // the offset of the list, based on current page 
    //  $offset = ($currentpage - 1) * $rowsperpage;
     $users = User::orderBy('id','desc')->get() ?>

    <table id="data-table" class="table table-bordered table-striped">
      <thead>
        <tr>
          <th>Name</th>
          <th>Address</th>
          <th>Landmark</th>
          <th>Phone</th>
          <th>Email</th>
          <th>Funds</th>

           <th>Action</th>

        </tr>
      </thead>
      <tbody>
        <?php if(!empty($users) ){
          foreach($users as $user) {
               $fname = $user->first_name ? $user->first_name : '---';
               $lname = $user->last_name ? $user->last_name :  '---'
          ?>
         <tr>
           
          <td style=""><?= $fname. '  ' .$lname ?></td>
          <td style="max-width: 100px;"><?= $user->address ?  $user->address : 'not set ' ?> , <?= $user->state_name  ? $user->state_name :'not set' ?></td>
          <td style=""><?= $user->landmark ? $user->landmark :  'not set' ?></td>
          <td ><?= $user->phone ? $user->phone :  'not set' ?></td>
          <td style=""><?= $user->email ?></td>
          <td style="max-width: 100px;"><?= $user->fund(); ?></td>


          <td>
              <a href="/cp/modules/users/delete_user.php?id=<?= $user->id ?>" id="delete" class="btn btn-default">
                delete
            </a>
            
            <a href="/cp/index.php?p=add_funds&id=<?= $user->id ?>" id="" class="btn btn-default">
                Add Funds
            </a>
          </td>
        </tr>


        <?php }  
         }
       ?>
      </tbody>
     
    </table>
  <div style="margin-left: 20px; width: 50%; " class="">
     <ul  class="pagination">

        
</ul>
   <?php //echo $users->links() ?>
</div>
  </div><!--box-body-->
  
  <div class="modal fade" id="modal-default">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">User Full infomation</h4>
              </div>
              <div class="modal-body">
                <p>----</p>
              </div>
              <div class="modal-footer">
               
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->

 
</div><!--box-->


<script>
   
   
</script>
