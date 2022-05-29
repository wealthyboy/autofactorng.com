<?php
  require_once('../../classes/class.db.php');
  require_once('../vars.php');
  require_once('../functions/upload_image.php');

  if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['prod-id'];
    $manufacturer = $_POST['manufacturer'];
    $model = $_POST['model'];
    $year_begin = $_POST['year-begin'];
    $year_end = $_POST['year-end'];
    $prod_name = 'Service pack for ' . $manufacturer . ' ' . $model . ' (' . $year_begin . ' - ' . $year_end . ')';
    $prod_price = $_POST['prod-price'];
    $prod_desc = mysqli_real_escape_string($GLOBALS['dbc'], trim($_POST['prod-desc']));
    $phy_desc = mysqli_real_escape_string($GLOBALS['dbc'], trim($_POST['phy-desc']));
    $img = (!empty($_FILES['img']['name']) ? $_FILES['img']['name'] : 'no_image.png');

    $page = $_POST['page'];

    //echo "id => $id";
    $query = sprintf("UPDATE service_pack SET name = '%s', manufacturer = '%s', model = '%s', price = %d, 
      phy_desc = '%s', prd_desc = '%s', year_begin = '%s', year_end = '%s'", 
      $prod_name, $manufacturer, $model, $prod_price, $phy_desc, $prod_desc, $year_begin, $year_end);

    if(!empty($img)) {
      $img = str_replace(' ', '_', $img);
      $query .= ", image1 = '$img'";
    }

    $query .= " WHERE id = $id LIMIT 1";

    $uploaded = mysqli_query($GLOBALS['dbc'], $query);

    //$arr = explode('/', $_SERVER['PHP_SELF']);
     $return_url = 'http://' . $_SERVER['HTTP_HOST'].'/cp/index.php?tbl=service_pack&cat_id=9&page='.$page;
    if ($uploaded) {
      update_image($_FILES['img']);

      $query = sprintf("UPDATE all_products SET product_name = '%s' WHERE product_id = %d AND table_name = '%s'", $prod_name, $id, 'service_pack');

      $update_all_prod = mysqli_query($GLOBALS['dbc'], $query);

      if ($update_all_prod) {
        header('Location: ' . $return_url);
        //echo 'Products uploaded and updated';
      }
    }
  }
?>