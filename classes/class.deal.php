<?php

  class Deal {
    public $deal_id;
    public $deal_value;
    public $valid_to;
    public $cat_id;
    public $sub_cat_id;
    public $product_id;
    public $tble_name;
    public $deal_type;


    protected static $_instance;
    public  $errors=[];

    public function __construct() {
      $this->deal_id    = null;
      $this->deal_value = '';
      $this->valid_to   = null;
      $this->cat_id     = null;
      $this->sub_cat_id = null;
      $this->product_id = null;
      $this->deal_type  =null;
    }

    public function get($field) {
      return $this->$field;
    }

    public function set($field, $val) {
      $this->$field = $val;
    }

    public function get_by_id($id) {
      $query = sprintf("SELECT * FROM %s WHERE id = %d", "deals", $id);
      return $this->fetch_row($query);
    }

    public function get_by_subcategory_or_category($subcat_id) {
      $query = sprintf("SELECT * FROM %s WHERE sub_cat_id = %d", "deals", $subcat_id);
      $result = mysqli_query($GLOBALS['dbc'], $query) or die(mysqli_error($GLOBALS['dbc']));
      if(mysqli_num_rows($result)) {
        return $this->fetch_row($query);
      } else {
        $c = new Category();
        $category = $c->get_by_sub_cat_id($subcat_id);
        $query = sprintf("SELECT * FROM %s WHERE cat_id = %d AND sub_cat_id = 0", "deals", $category->get('id'));
        return $this->fetch_row($query);
      }
    }

    public function get_by_cat_id($cat_id) {
      $query = sprintf("SELECT * FROM %s WHERE cat_id = %d", "deals", $cat_id);
      return $this->fetch_row($query);
    }

    public function get_by_sub_cat_id($subcat_id) {
      $query = sprintf("SELECT * FROM %s WHERE sub_cat_id = %d", "deals", $subcat_id);
      return $this->fetch_row($query);
    }

    public function get_by_table_name($table_name) {
      $c = new Category();
      $category = $c->get_by_table_name($table_name);
      $d = new Deal();
      $deal = $d->get_by_cat_id($category->get('id'));
      if ($deal) {
        return $deal;
      } else {
        return false;
      }
    }

    public function get_by_product_id($id) {
      $query = "SELECT * FROM deals WHERE product_id = $id";
      return $this->fetch_row($query);
    }

    public function list_all() {
      $query = sprintf("SELECT * FROM %s", "deals");
      return mysqli_query($GLOBALS['db'], $query);
    }

    public function save() {
      $query = sprintf("INSERT INTO deals (deal_value, valid_to, cat_id, sub_cat_id,deal_type) VALUES ('%s', '%s', %d, %d,'%s')",
        mysqli_real_escape_string($GLOBALS['dbc'], $this->deal_value),
        mysqli_real_escape_string($GLOBALS['dbc'], $this->valid_to), $this->cat_id, $this->sub_cat_id,$this->deal_type);
      return mysqli_query($GLOBALS['dbc'], $query) or die(mysqli_error($GLOBALS['dbc']));
    }

    public function delete() {
      $query = sprintf("DELETE FROM %s WHERE id = %d", "deals", $this->deal_id);
      return mysqli_query($GLOBALS['dbc'], $query);
    }

    public function belongs_to_product_category($product_category) {
      $query = sprintf("SELECT cat_id FROM %s WHERE slug = '%s'", "subcategories", $product_category);
      $result = mysqli_query($GLOBALS['db'], $query) or die(mysqli_error($GLOBALS['db']));
      $row = mysqli_fetch_assoc($result);
      if($row['cat_id'] == $this->cat_id) {
        return true;
      } else {
        return false;
      }
    }

    public function get_price($price) {
      return $price - ($price * ($this->deal_value / 100));
    }
    public function get_discounted_price($price,$deal_value) {
      return  $price * ($deal_value / 100);
    }

    private function fetch_row($query) {
      $deal = new Deal();
      $result = mysqli_query($GLOBALS['dbc'], $query) or die(mysqli_error($GLOBALS['dbc']));
      if(mysqli_num_rows($result)) {
        $row = mysqli_fetch_assoc($result);
        $deal->deal_id    = $row['id'];
        $deal->deal_value = $row['deal_value'];
        $deal->valid_to   = $row['valid_to'];
        $deal->cat_id     = $row['cat_id'];
        $deal->sub_cat_id = $row['sub_cat_id'];
        $deal->product_id = $row['product_id'];
      return $deal;
      } else {
        return false;
      }
    }
  }
?>
