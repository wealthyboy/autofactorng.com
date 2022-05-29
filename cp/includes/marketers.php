 
    <?php
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
     $users = DB::getInstance()->run_sql("SELECT * FROM  marketers  ");  ?>

    <table id="data-table" class="table table-bordered table-striped">
      <thead>
        <tr>
          <th>Name</th>
          <th>Last Name</th>
          <th>Referral</th>
          <th>Phone</th>
          <th>Email</th>
           <th>Action</th>

        </tr>
      </thead>
      <tbody>
        <?php if(!empty($users) ){
          foreach($users as $user) {?>
         <tr>
          <td style="max-width: 200px;"><?= $user->first_name . ' ' .$user->last_name ?></td>
          <td style="max-width: 200px;"><?= $user->last_name ?> , <?= $user->state_name ?></td>
          <td style="max-width: 200px;"><?= $user->referral ?></td>
          <td ><?= $user->phone_number ?></td>
          <td style="max-width: 200px;"><?= $user->email ?></td>
          <td >
             
            <a href="/cp/modules/marketers/delete.php?id=<?= $user->id ?>" id="delete" class="btn btn-default">
                delete
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
    window.onload = function(){
        $.ajax({
          url: '/', success: function (response) {
            console.log(response)
          }
        })
    }
   
</script>
