 
    <?php
    $count = DB::getInstance()->run_sql("SELECT users.*, state.name AS state_name FROM users INNER JOIN state ON (users.state_id = state.id) WHERE users.is_verified = 1 ");
    
    

    $rowsperpage ='';
         // number of rows to show per page
    $rowsperpage = 20;
    // find out total pages
    $totalpages = ceil(count($count) / $rowsperpage);

    // get the current page or set a default
    if (isset($_GET['page']) && is_numeric($_GET['page'])) {
       // cast var as int
       $currentpage = (int) $_GET['page'];
    } else {
       // default page num
       $currentpage = 1;
    } // end if

    // if current page is greater than total pages...
    if ($currentpage > $totalpages) {
       // set current page to last page
       $currentpage = $totalpages;
    } // end if
    // if current page is less than first page...
    if ($currentpage < 1) {
       // set current page to first page
       $currentpage = 1;
    } // end if

    // the offset of the list, based on current page 
     $offset = ($currentpage - 1) * $rowsperpage;
     $data = DB::getInstance()->run_sql("SELECT users.*, state.name AS state_name FROM users INNER JOIN state ON (users.state_id = state.id) WHERE users.is_verified = 1 ORDER BY users.id desc limit $offset, $rowsperpage");  ?>

    <table id="data-table" class="table table-bordered table-striped">
      <thead>
        <tr>
          <th>Name</th>
          <th>Address</th>
          <th>Landmark</th>
          <th>Phone</th>
          <th>Email</th>
           <th>Action</th>

        </tr>
      </thead>
      <tbody>
        <?php if(!empty($data) ){
          foreach($data as $details) {?>
         <tr>
          <td style="max-width: 200px;"><?= $details->first_name . ' ' .$details->last_name ?></td>
          <td style="max-width: 200px;"><?= $details->address ?> , <?= $details->state_name ?></td>
          <td style="max-width: 200px;"><?= $details->landmark ?></td>
          <td ><?= $details->phone ?></td>
          <td style="max-width: 200px;"><?= $details->email ?></td>
          <td >
            <button type="button" class="btn btn-info" data-toggle="modal" data-target="#modal-info<?= $details->id ?>">
               View
            </button> 
            <button type="button" class="btn btn-default" data-toggle="modal" data-target="#modal-default<?= $details->id ?>">
                delete
            </button>
          </td>
        </tr>


        <?php }  
         }
       ?>
      </tbody>
     
    </table>
  <div style="margin-left: 20px; width: 50%; " class="">
     <ul  class="pagination">

        
       



<?php     
// range of num links to show
$range = 3;

// if not on page 1, don't show back links
if ($currentpage > 1) {
   // show << link to go back to page 1
   echo " <li><a class='page_link' href='{$_SERVER['PHP_SELF']}?p=user&page=1'><<</a><li> ";
   // get previous page num
   $prevpage = $currentpage - 1;
   // show < link to go back to 1 page
   echo " <li><a class='page_link' href='{$_SERVER['PHP_SELF']}?p=user&page=$prevpage'><</a><li> ";
} // end if 

// loop to show links to range of pages around current page
for ($x = ($currentpage - $range); $x < (($currentpage + $range) + 1); $x++) {
   // if it's a valid page number...
   if (($x > 0) && ($x <= $totalpages)) {
      // if we're on current page...
      if ($x == $currentpage) {
         // 'highlight' it but don't make a link
         echo " <li><a  class='active' >$x</a><li> ";
      // if not current page...
      } else {
         // make it a link
         echo " <li><a  class='page_link' href='{$_SERVER['PHP_SELF']}?p=users&page=$x'>$x</a><li> ";
      } // end else
   } // end if 
} // end for

// if not on last page, show forward and last page links        
if ($currentpage != $totalpages) {
   // get next page
   $nextpage = $currentpage + 1;
    // echo forward link for next page 
   echo " <li><a  class='page_link' href='{$_SERVER['PHP_SELF']}?p=users&page=$nextpage'>></a><li> ";
   // echo forward link for lastpage
   echo " <li><a class='page_link' href='{$_SERVER['PHP_SELF']}?p=users&page=$totalpages'>>></a><li> ";
} // end if
/****** end build pagination links ******/ ?>
</ul>
</div>
  </div><!--box-body-->
<?php if(!empty($data) ){
          foreach($data as $details) {?>
  <div class="modal fade" id="modal-default<?php echo $details->id?>">
      <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title">Enter Password</h4>
            </div>
            <div class="modal-body">
             <form method="post"  action="/cp/modules/users/delete_user.php" role="form">
              <div class="box-body">
                
                <div class="form-group">
                  <label for="exampleInputPassword1">Password</label>
                  <input class="form-control" name='password' id="exampleInputPassword1" placeholder="Password" type="password">
                   <input class="form-control" name='id' value="<?php echo $details->id ?>"  type="hidden">
                </div>
                
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <button type="submit" id="delete_user" class="btn btn-primary pull-right">Submit</button>
              </div>
            </form>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn pul btn-default pull-left" data-dismiss="modal">Close</button>
              
            </div>
          </div>
          <!-- /.modal-content -->
      </div>
          <!-- /.modal-dialog -->
  </div>
        <!-- /.modal -->
 <?php }  
    }
  ?>
  <?php //$ls = LogSecurity::getInstance()->find('user_id',2060);  dd($ls)?>
  <?php if(!empty($data) ){

          foreach($data as $details) {
  ?>
  <div class="modal modal-primary fade" id="modal-info<?php echo $details->id?>">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">User Details</h4>
            </div>
            <?php $ls = LogSecurity::getInstance()->find('user_id',$details->id); ?>
            <div class="modal-body">
               <?php   if (!empty($ls)) { ?>
                      
                      <p><b>Ip:</b> &nbsp; &nbsp; &nbsp;   <?= $ls->ip  ?>     </p>
                      <hr/>
                      <p><b>City:</b>  &nbsp; &nbsp; &nbsp; <?= $ls->city  ?>    </p>
                      <hr/>
                      <p><b>Region:</b> &nbsp; &nbsp; &nbsp;<?= $ls->region  ?>    </p>
                      <hr/>
                      <p><b>Region Code:</b>&nbsp; &nbsp; &nbsp; <?= $ls->region_code  ?>  </p>
                      <hr/>
                      <p><b>Country Name:</b> &nbsp; &nbsp; &nbsp;<?= $ls->country_name  ?>   </p>
                      <hr/>
                      <p><b>Country Code:</b> &nbsp; &nbsp; &nbsp; <?= $ls->country_code  ?> <?= $ls->ip  ?>  </p>
                      <hr/>
                      <p><b>Continent name:</b> &nbsp; &nbsp; &nbsp; <?= $ls->continent_name  ?>  </p>
                      <hr/>
                      <p><b>Continent Code:</b> &nbsp; &nbsp; &nbsp; <?= $ls->continent_code  ?> </p>
                      <hr/>
                      <p><b>Latitude:</b> &nbsp; &nbsp; &nbsp; <?= $ls->latitude  ?> </p>
                      <hr/>
                      <p><b>Longitude:</b> &nbsp; &nbsp; &nbsp; <?= $ls->longitude  ?> </p>
                      <hr/>
                      <p><b>Organisation:</b>  &nbsp; &nbsp; &nbsp;<?= $ls->organisation  ?> </p>
                      <hr/>
                      <p><b>Postal :</b>&nbsp; &nbsp; &nbsp; <?= $ls->postal  ?> </p>
                      <hr/>
                      <p><b>Currency:</b> &nbsp; &nbsp; &nbsp;<?= $ls->currency  ?> </p>
                      <hr/>
                      <p><b>Currency Symbol:</b> &nbsp; &nbsp; &nbsp;<?= $ls->currency_symbol ?></p>
                      <hr/>
                      <p><b>Calling Code:</b>  &nbsp; &nbsp; &nbsp;<?= $ls->calling_code ?></p>
                      <hr/>
                      <p><b>Flag:</b> &nbsp; &nbsp; &nbsp; <img src="<?= $ls->flag ?>"  /></p>
                      <hr/>
                      <p><b>Emoji_flag :</b> &nbsp; &nbsp; &nbsp; <?= $ls->calling_code ?></p>
                      <hr/>
                      <p><b>Time Zone :</b>&nbsp; &nbsp; &nbsp;  <?= $ls->time_zone ?></p>
                      <hr/>
                      <p><b>User Ugent :</b> &nbsp; &nbsp; &nbsp; <?= $ls->user_agent ?></p>
                      <hr/>
                     <?php  } else { ?>
                       No information at the moment 
                   <?php    }
                ?>
                      
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
               
              </div>
            </div>
            <!-- /.modal-content -->
      </div>
          <!-- /.modal-dialog -->
  </div>
        <!-- /.modal -->
        <?php }  
    }
  ?>
</div><!--box-->
