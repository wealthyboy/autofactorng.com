<?php 
  session_start();
  
  require_once('includes/header.php');
?>
<!--
BODY TAG OPTIONS:
=================
Apply one or more of the following classes to get the
desired effect
|---------------------------------------------------------|
| SKINS         | skin-blue                               |
|               | skin-black                              |
|               | skin-purple                             |
|               | skin-yellow                             |
|               | skin-red                                |
|               | skin-green                              |
|---------------------------------------------------------|
|LAYOUT OPTIONS | fixed                                   |
|               | layout-boxed                            |
|               | layout-top-nav                          |
|               | sidebar-collapse                        |
|               | sidebar-mini                            |
|---------------------------------------------------------|
-->
<body class="hold-transition skin-red sidebar-mini">
<?php

require_once('../classes/class.db.php');
require_once('../classes/class.category.php');
require_once('../classes/class.order.php');
//require_once('../classes/class.user.php');
require_once('functions/pagination.php');
require_once $_SERVER["DOCUMENT_ROOT"].'/init/autoload.php';

//remove Expired product deals
Deals::RemoveExpiredProductDeals();
$banner =new Banner();
?>
<div class="wrapper">

  <!-- Main Header -->
  <header class="main-header">

    <!-- Logo -->
    <a href="index.php" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>A</b>CP</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>Autofactorng</b> CP</span>
    </a>

    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top" role="navigation">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>
      <!-- Navbar Right Menu -->
      </div>
    </nav>
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

      <!-- Sidebar user panel (optional) -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="../images/afng.png" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p>Autofactorng</p>
          <!-- Status -->
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>

      <!-- search form (Optional) -->
      <form action="<?php htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="get" class="sidebar-form">
        <div class="input-group">
          <input type="text" name="q" class="form-control" placeholder="Search...">
              <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
        </div>
      </form>
      <!-- /.search form -->

      <!-- Sidebar Menu -->
      <ul class="sidebar-menu">
        <li class="header">MENU</li>
        <li><a href="#"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>
        <!-- Optionally, you can add icons to the links -->
        <li class="treeview">
          <a href="#"><i class="fa fa-bars"></i> <span>Spare Parts</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
          <?php
            $table = $_GET['tbl'];
            $cat_id = $_GET['cat_id'];
            $sub_cat_id = (!empty($_GET['sub_cat_id']) ? $_GET['sub_cat_id'] : NULL);
            $cur_page = (!empty($_GET['page']) ? $_GET['page'] : 1);

            $data = mysqli_query($GLOBALS['dbc'], "SELECT * FROM product_sub_cats WHERE cat_id = 1");
            while($row = mysqli_fetch_array($data)) {
              echo '<li><a href="index.php?tbl=spare_parts&cat_id=1&sub_cat_id='.$row['sub_cat_id'].'">'.$row['name'].'</a></li>';
            }
          ?>
          </ul>
        </li>
        <li><a href="index.php?tbl=servicing_parts&cat_id=2"><i class="fa fa-arrow-circle-right"></i> <span>Servicing Parts</span></a></li>
        <li><a href="index.php?tbl=accessories&cat_id=3"><i class="fa fa-arrow-circle-right"></i> <span>Accessories</span></a></li>
        <li><a href="index.php?tbl=car_care&cat_id=4"><i class="fa fa-arrow-circle-right"></i> <span>Car Care, Gadgets, Tools</span></a></li>
        <li><a href="index.php?tbl=grille_guards&cat_id=5"><i class="fa fa-arrow-circle-right"></i> <span>Grille Guards</span></a></li>

        <li class="treeview">
          <a href="#"><i class="fa fa-bars"></i> <span>Wheels/Tyres</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <!-- hardcoding this because tyres/wheels are of different tables -->
            <li><a href="index.php?tbl=tyres&cat_id=6&sub_cat_id=24">Tyres</a></li>
            <li><a href="index.php?tbl=wheels&cat_id=6&sub_cat_id=25">Wheels</a></li>
          </ul>
        </li>

        <li><a href="index.php?tbl=lubricants&cat_id=7"><i class="fa fa-arrow-circle-right"></i> <span>Lubricants &amp; Fluids</span></a></li>
        <li><a href="index.php?tbl=batteries&cat_id=8"><i class="fa fa-arrow-circle-right"></i> <span>Batteries</span></a></li>
        <li><a href="index.php?tbl=service_pack&cat_id=9"><i class="fa fa-arrow-circle-right"></i> <span>Service Pack</span></a></li>
        <li><a href="index.php?tbl=cybersale&cat_id=10"><i class="fa fa-arrow-circle-right"></i> <span>Deals Of The Week</span></a></li>
         <li><a href="index.php?p=blog"><i class="fa fa-arrow-circle-right"></i> <span>Blog</span></a></li>
         <li><a href="index.php?p=reviews"><i class="fa fa-arrow-circle-right"></i> <span>Reviews</span></a></li>
        <li><a href="index.php?p=price_update"><i class="fa fa-gears"></i> <span>Price Update</span></a></li>
        <li><a href="index.php?p=coupons"><i class="fa fa-gears"></i> <span>Coupons</span></a></li>
        <li><a href="index.php?p=deals"><i class="fa fa-gears"></i> <span>Deals</span></a></li>
        <li><a href="index.php?p=product_deals"><i class="fa fa-gears"></i> <span>Products Deals</span></a></li>
        <li class="treeview">
          <a href="#"><i class="fa fa-bars"></i> <span>Design</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            
            <li><a href="index.php?tbl=banner">Banner</a></li>

          </ul>
        </li>
        <li class="treeview">
          <a href="#"><i class="fa fa-bars"></i> <span>Local</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
         
            <li>
            <a href="index.php?p=category">  <i class="fa fa-circle-o"></i> Categories   </a></li>

          </ul>
        </li>

         <li class="treeview">
          <a href="#"><i class="fa fa-bars"></i> <span>Car Search</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
         
            <li>
              <a href="index.php?p=cars">  <i class="fa fa-circle-o"></i> Car Search  </a>
            </li>

            <li>
            <a href="index.php?p=years">  <i class="fa fa-circle-o"></i> Year  </a></li>

          </ul>
        </li>
        
        
        <li><a href="index.php?p=call_technician"><i class="fa fa-phone"></i> <span>Call a Technician</span></a></li>
        <li><a href="index.php?p=technicians"><i class="fa fa-wrench"></i> <span>Technicians</span></a></li>
        <li><a href="index.php?p=cars"><i class="fa fa-arrow-circle-right"></i> <span>Car Search</span></a></li>
        <li><a href="index.php?p=Marketers"><i class="fa fa-arrow-circle-right"></i> <span>Marketers</span></a></li>
       
        <li><a href="index.php?p=merchants"><i class="fa fa-user"></i> <span>Merchants</span></a></li>
        <li><a href="index.php?p=call_tow_truck"><i class="fa fa-phone"></i> <span>Tow Truck Request</span></a></li>
        <li><a href="index.php?p=tow_truck_drivers"><i class="fa fa-user"></i> <span>Tow Truck Drivers</span></a></li>
        <li><a href="index.php?p=order_email"><i class="fa fa-envelope"></i> <span>Order Email</span></a></li>
        <li><a href="index.php?p=cancel_order"><i class="fa fa-envelope"></i> <span>Cancel Order</span></a></li>
        <li><a href="index.php?p=orders"><i class="fa fa-arrow-circle-right"></i> <span>Orders</span></a></li>
        <!--<li><a href="#"><i class="glyphicon glyphicon-menu-right"></i> <span>Cancel Orders</span></a></li>-->
        <li><a href="index.php?p=users"><i class="fa fa-users"></i> <span>Users</span></a></li>
        <li><a href="index.php?p=staff"><i class="fa fa-users"></i> <span>Staff</span></a></li>
        <li><a href="index.php?p=shipping"><i class="fa fa-users"></i> <span>Shipping</span></a></li>
      </ul>
      <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-dashboard"> Dashboard</i>
        <!--<small>Optional description</small>-->
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Level</a></li>
        <li class="active">Here</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
    <?php
      if (isset($_GET['action'])) {
        if ($_GET['action'] == 'update-product') {
          $prod_id = $_GET['id'];
          $cat_id = $_GET['cat_id'];
          $sub_cat_id = $_GET['sub_cat_id'];

          switch ($cat_id) {
            case 1:
              require_once('includes/update_spares_form.php');
              break;

            case 2:
              require_once('includes/update_servicing_form.php');
              break;

            case 3:
              require_once('includes/update_accessories_form.php');
              break;

            case 4:
              require_once('includes/update_car_care_form.php');
              break;

            case 5:
              require_once('includes/update_grille_form.php');
              break;

            case 6:
              if ($sub_cat_id == 24) {
                require_once('includes/update_tyres_form.php');
              } else {
                require_once('includes/update_wheels_form.php');
              }
              break;

            case 7:
              require_once('includes/update_lubricants_form.php');
              break;

            case 8:
              require_once('includes/update_batteries_form.php');
              break;

            case 9:
              require_once('includes/update_service_pack_form.php');
              break;

            case 10:
              require_once('includes/update_cybersale_form.php');
              break;
            
            default:
              //echo 'Form not included';
              break;
          }
        }
      }

      else {
        require_once('includes/main_content.php');
      }
    ?>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Main Footer -->

  <!-- Control Sidebar -->
  
  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
</div>
<!-- ./wrapper -->

<!-- REQUIRED JS SCRIPTS -->

<!-- jQuery 2.2.3 -->
<script src="plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="bootstrap/js/bootstrap.min.js"></script>

<script src="/cp/js/jquery.dataTables.min.js"></script>
<script src="/cp/js/dataTables.bootstrap.min.js"></script>
<!-- AdminLTE App -->
<script src="js/app.min.js"></script>
<script src="js/summernote.min.js"></script>
<script src="js/functions/generate_fields.js"></script>
<script src="js/script.js?<?php echo time(); ?>"></script>

<script>
  $(function () {
      $('#data-table').DataTable({
         "ordering": false
     });
  });
</script>
</body>
</html>
