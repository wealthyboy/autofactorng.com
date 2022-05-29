<?php  session_start();
require_once $_SERVER["DOCUMENT_ROOT"].'/init/autoload.php';
  require_once('../../classes/class.db.php');
  require_once('../vars.php');
  require_once('../functions/upload_image.php');


  if($_SERVER['REQUEST_METHOD'] == 'POST') {
      
    $id = $_POST['prod-id'];
    $sub_cat_id = $_POST['sub-cat-id'];
    $manufacturer = $_POST['manufacturer'];
    $image_alt_text = $_POST['image_alt_text'];
    $model = $_POST['model'];
    $year_begin = $_POST['year-begin'];
    $year_end = $_POST['year-end'];
    $prod_name = $_POST['prod-name'] . ' for ' . $manufacturer . ' ' . $model . ' (' . $year_begin . ' - ' . $year_end . ')';
    $slug = SpareParts::makeSlug($prod_name);
    $prod_price = $_POST['prod-price'];
    $prod_desc = mysqli_real_escape_string($GLOBALS['dbc'], trim($_POST['prod-desc']));
    $phy_desc = mysqli_real_escape_string($GLOBALS['dbc'], trim($_POST['phy-desc']));
    $img1 = $_FILES['img1']['name'];
    $img2 = $_FILES['img2']['name'];
    $img3 = $_FILES['img3']['name'];

    $page = $_POST['page'];
    

    //echo "id => $id";
    $query = sprintf("UPDATE 
                 spare_parts SET
                 sub_cat_id = %d,
                  name = '%s',
                  manufacturer = '%s', 
                  model = '%s', 
                  price = %d, 
                  phy_desc = '%s',
                  prd_desc = '%s', 
                  year_begin = '%s', 
                  year_end = '%s', 
                  image_alt_text = '%s',
                  slug = '%s' ", 
                  $sub_cat_id, 
                  $prod_name, 
                  $manufacturer, 
                  $model, 
                  $prod_price, 
                  $phy_desc, 
                  $prod_desc, 
                  $year_begin, 
                  $year_end,
                  $image_alt_text,
                  $slug
      );

    if(!empty($img1)) {
      $img = str_replace(' ', '_', $img1);
      $query .= ", image1 = '$img'";
    }

    if(!empty($img2)) {
      $img = str_replace(' ', '_', $img2);
      $query .= ", image2 = '$img'";
    }

    if(!empty($img3)) {
      $img = str_replace(' ', '_', $img3);
      $query .= ", image3 = '$img'";
    }

    $query .= " WHERE id = $id ";

    $uploaded = mysqli_query($GLOBALS['dbc'], $query);
    
      

    if (!$uploaded) {
        echo('Update failed product exists.');
        die();
       // Redirect::back();
    } 
        //$arr = explode('/', $_SERVER['PHP_SELF']);
    //$return_url = 'http://' . $_SERVER['HTTP_HOST'].'/'.$arr[1] . '/cp';
    $return_url = 'http://' . $_SERVER['HTTP_HOST'].'/cp/index.php?tbl=spare_parts&cat_id=1&sub_cat_id='.$sub_cat_id.'&page='.$page;
    if ($uploaded) {
      update_image($_FILES['img1'], $_FILES['img2'], $_FILES['img3']);


     if ( count($_POST['update_product_name'])){
              
              foreach ($_POST['product_name'] as $key => $value) {
                 $table = $_POST['update_sub_category'][$key];
                 RelatedProducts::getInstance()->query("UPDATE related_products SET product_name = '{$value}' , tble_name = '{$table}' WHERE id =  $key ");
              }
              
        }
      if ( count($_POST['product_name'])){
           
              foreach ($_POST['sub_category'] as $key => $value) {
                  if($value == '' || $_POST['product_name'][$key] == ''){
                            continue;
                  }
                  RelatedProducts::getInstance()->product_name =  $_POST['product_name'][$key];
                  RelatedProducts::getInstance()->product_id   =   $id;
                  RelatedProducts::getInstance()->sub_cat_id   =  $sub_cat_id;
                  RelatedProducts::getInstance()->cat_id       =  Input::get('cat_id');
                  RelatedProducts::getInstance()->tble_name    =  $value;
                  RelatedProducts::getInstance()->Insert();
              
              }
              
         }
      $query = sprintf("UPDATE all_products SET product_name = '%s' WHERE product_id = %d AND table_name = '%s'", $prod_name, $id, 'spare_parts');

      $update_all_prod = mysqli_query($GLOBALS['dbc'], $query);

      if ($update_all_prod) {
        header('Location: ' . $return_url);
        //echo 'Products uploaded and updated';
      }
    }
  }
?>