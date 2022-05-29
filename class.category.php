<?php require_once 'class.db.php';
	class Category extends DB{
		private $id;
    private $name;
    protected $table_name='product_cats';
    protected static $_instance = null;

    public function __construct() {
    	$this->id = null;
    	$this->name = '';
    }

    public function get($field) {
      return $this->$field;
    }

    public function set($field, $val) {
      $this->$field = $val;
    }

    public function get_by_id($id) {
      if($id == 99) {
        $this->set('name', 'ALL');
        return $this;
      }
      $query = sprintf("SELECT * FROM %s WHERE cat_id = %d", "product_cats", $id);
      return $this->fetch_row($query);
    }

    public function get_by_sub_cat_id($sub_id) {
      $query = sprintf("SELECT * FROM %s WHERE sub_cat_id = %d", "product_sub_cats", $sub_id);
      $data = mysqli_query($GLOBALS['dbc'], $query);
      if (mysqli_num_rows($data)) {
        $row = mysqli_fetch_assoc($data);
        $this->id = $row['cat_id'];
        $cat = new Category();
        $cat = $cat->get_by_id($row['cat_id']);
        $this->name = $cat->get('name');
        return $this;
      }

      else {
        return false;
      }
    }

    public function get_by_table_name($table_name) {
      switch ($table_name) {
        case 'spare_parts':
          $category_name = 'Spare Parts';
          break;

        case 'servicing_parts':
          $category_name = 'Servicing Parts';
          break;

        case 'accessories':
          $category_name = 'Accessories';
          break;

        case 'car_care':
          $category_name = 'Car Care, Gadgets/Tools';
          break;

        case 'grille_guards':
          $category_name = 'Grille Guards';
          break;

        case 'tyres':
          $category_name = 'Wheels/Tyres';
          break;

        case 'lubricants':
          $category_name = 'Lube/Fluids';
          break;

        case 'batteries':
          $category_name = 'Batteries';
          break;
        
        default:
          $category_name = '';
          break;
      }

      return $category_name;
    }

    public function get_table_name($table_name) {
      switch ($table_name) {
        case 'Spare Parts':
          $category_name = 'spare_parts';
          break;

        case 'Servicing Parts':
          $category_name = 'servicing_parts';
          break;

        case 'Accessories':
          $category_name = 'accessories';
          break;

        case 'Car Care/Tools & Multimedia':
          $category_name = 'car_care';
          break;

        case 'Grille Guards':
          $category_name = 'grille_guards';
          break;

        case 'Wheels/Tyres':
          $category_name = 'tyres';
          break;

        case 'Lube/Fluids':
          $category_name = 'lubricants';
          break;

        case 'Batteries':
          $category_name = 'batteries';
          break;
        
        default:
          $category_name = '';
          break;
      }

      return $category_name;
    }

    public function get_by_name($name) {
      $query = sprintf("SELECT * FROM %s WHERE name = '%s'", "product_cats", $name);
      return $this->fetch_row($query);
    }

    private function fetch_row($query) {
      $result = mysqli_query($GLOBALS['dbc'], $query) or die(mysqli_error($GLOBALS['dbc']));
      if(mysqli_num_rows($result)) {
        $row = mysqli_fetch_assoc($result);
        $this->id = $row['cat_id'];
        $this->name = $row['name'];
        return $this;
      } else {
        return false;
      }
    }

    public function subcategories() {
      if ($this->get('id') == '6' || $this->get('id') == '8') {
        return false;
      }
      else {
        $query = sprintf("SELECT * FROM %s WHERE cat_id = %d", "product_sub_cats", $this->get('id'));
        $dat = mysqli_query($GLOBALS['dbc'], $query);
        if(mysqli_num_rows($dat)) {
          return $dat;
        }
      }
    }
	}
?>