<div class="box">
  <div class="box-header">
    <h3 class="box-title">List Of Uploaded Products</h3>
    <div class="box-tools pull-right">
      <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
    </div>
  </div>
  <div class="box-body table-responsive">
    <table id="uploaded_product_table" class="table table-bordered table-striped table-hover">
    <form method="GET" action="modules/batch_delete.php">
      <input type="hidden" name="cat-id" value="<?php echo $cat_id; ?>" />
      <input type="hidden" name="sub-cat-id" value="<?php echo $sub_cat_id; ?>" />
      <input type="hidden" name="tbl" value="<?php echo $table; ?>" />
      <button class="btn btn-sm btn-danger"><i class="fa fa-trash-o"></i>&nbsp; Delete Selected</button>
      <thead>
        <tr>
          <th></th>
          <th>Product Name</th>
          <th>Product Price</th>
          <th>Edit</th>
          <th>Delete</th>
        </tr>
      </thead>
      <tbody>
     <?php
        $skip = ($cur_page - 1) * 20;

        if (!empty($_GET['q'])) {
          $search_query = mysqli_real_escape_string($GLOBALS['dbc'], trim($_GET['q']));
          $query = "SELECT * FROM $table WHERE sub_cat_id = $sub_cat_id AND";
          $query2 = "SELECT * FROM $table WHERE";
          $clean_search = str_replace(',', ' ', $search_query);
          $search_words = explode(' ', $clean_search);
          $final_search_words = array();

          if (count($search_words) > 0) {
            foreach ($search_words as $word) {
              if (!empty($word)) {
                $final_search_words[] = $word;
              }
            }
          }

          $where_list = array();
          if (count($final_search_words) > 0) {
            foreach($final_search_words as $word) {
              $where_list[] = "name LIKE '%$word%'";
            }
          }

          $where_clause = implode(' AND ', $where_list);
          if (!empty($where_clause)) {
            $query .= " $where_clause";
            $query2 .= " $where_clause";
          }

          if($cat_id == '1') {
            $data = mysqli_query($GLOBALS['dbc'], $query);
            $total_num_prod = mysqli_num_rows($data);

            $data = mysqli_query($GLOBALS['dbc'], $query . " ORDER BY id DESC LIMIT $skip, 20");
          }

          else {
            $data = mysqli_query($GLOBALS['dbc'], $query2);
            $total_num_prod = mysqli_num_rows($data);

            $data = mysqli_query($GLOBALS['dbc'], $query2 . " ORDER BY id DESC LIMIT $skip, 20");
          }
        }

        else {
          if($cat_id == '1') {
            $data = mysqli_query($GLOBALS['dbc'], "SELECT * FROM $table WHERE sub_cat_id = $sub_cat_id");
            $total_num_prod = mysqli_num_rows($data);

            $data = mysqli_query($GLOBALS['dbc'], "SELECT * FROM $table WHERE sub_cat_id = $sub_cat_id ORDER BY id DESC LIMIT $skip, 20");
          }

          else {
            $data = mysqli_query($GLOBALS['dbc'], "SELECT * FROM $table");
            $total_num_prod = mysqli_num_rows($data);

            $data = mysqli_query($GLOBALS['dbc'], "SELECT * FROM $table ORDER BY id DESC LIMIT $skip, 20");
          }
        }
        
        $num_pages = ceil($total_num_prod / 20);

        while($row = mysqli_fetch_array($data)) {
        $id = $row['id']; 

        ?>
        <tr>
          <td><input type="checkbox" name="to-delete[]" value="<?php echo $id; ?>" /></td>
          <td><?php echo $row['name']; ?></td>
          <td data-prd-id="<?php echo $id; ?>" data-prd-tbl="<?php echo $table; ?>" contenteditable="true"><?php echo $row['price']; ?></td>
          <td>
           <button data-action="update" data-name="<?php echo $row['name'] ?>" data-prod-id="<?php echo $id; ?>" data-cat-id="<?php echo $cat_id; ?>" data-sub-cat-id="<?php echo $row['sub_cat_id']; ?>" data-page="<?php echo (empty($_GET['page']) ? '1' : $_GET['page']); ?>" class="btn btn-sm btn-warning"><i class="fa fa-pencil-square-o"></i>&nbsp; Update Product
           </button>
          </td>
          <td>
             <a href="#"  data-tag="1" data-table="<?php echo $table; ?>" data-prod-id="<?php echo $id; ?>"  class="btn out_of_stock out_of_stock<?php echo $id; ?>   btn-sm <?php echo Tags::checkStatus($id,Input::get('tbl')) == 1  ? 'btn-info': 'btn-primary'; ?>">&nbsp;<?php echo !empty(Tags::checkStatus($id,Input::get('tbl')))  && Tags::checkStatus($id,Input::get('tbl')) == 1  ? 'Out of stock': 'In stock'; ?></a>

              <a href="#" id="out_of_stock<?php echo $id; ?>" data-tag="2" data-table="<?php echo $table; ?>" data-prod-id="<?php echo $id; ?>" 
               class="btn out_of_stock out_of_stock<?php echo $id; ?>  btn-sm <?php echo Tags::checkStatus($id,Input::get('tbl')) == 2  ? 'btn-info': 'btn-warning'; ?>">
                &nbsp;<?php echo !empty(Tags::checkStatus($id,Input::get('tbl'))) && Tags::checkStatus($id,Input::get('tbl')) == 2 ? 'Disable Pre Order': 'Enable pre order'; ?></a>
              <?php if($table == 'spare_parts'){?>
               <a href="index.php?p=product_deal&table=<?php echo $table;  ?>&id=<?= $id; ?>&subcatid=<?= Input::get('sub_cat_id') ?>&catid=<?= Input::get('cat_id') ?>"   class="btn  btn-sm btn-info"><i class="fa fa-plus"></i>&nbsp;<?php echo  Deals::productHasDeal($id) ? 'Deal Present' :'Add Deal' ?></a>
              <?php  }?>
             <button data-action="delete" data-table="<?php echo $table; ?>" data-prod-id="<?php echo $id; ?>" data-cat-id="<?php echo $cat_id; ?>" data-sub-cat-id="<?php echo $row['sub_cat_id']; ?>" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i>&nbsp; Delete Product</button>
          </td>
        </tr>
      <?php } ?>
      </tbody>
      <tfoot>
      </tfoot>
    </form>
    </table>
  </div>
  <div class="box-footer">
    <div class="row">
      <div class="col-md-4 pull-right">
        <ul class="pagination">
          <?php
            //print_r($_SERVER);
            //print_r($_SERVER['REQUEST_URI']);
            echo pagination($num_pages, $cur_page, $table, $cat_id, $sub_cat_id);
          ?>
        </ul>
      </div>
    </div>
  </div>
</div><!--box-->

<script type="text/javascript">
  
  $(document).ready(function(){
    alert();
  });
</script>