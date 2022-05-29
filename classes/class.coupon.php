<?php
  require_once 'class.db.php';
  
  class Coupon extends DB{
    public $coupon_id;
    public $id;
    public $coupon_code;
    public $coupon_value;
    public $coupon_type;
    public $valid_to;
    public $cat_id;
    
    public $status;
    
    protected $table_name='coupons';
    protected static $_instance = null;

    

    public function get($field) {
      return $this->$field;
    }
    
    public function find_by_id($id){
    	return $this->find('id', $id);
    }

    public function set($field, $val) {
      $this->$field = $val;
    }

    public function get_by_id($id) {
      $query = sprintf("SELECT * FROM %s WHERE id = %d", "coupons", $id);
      return $this->fetch_row($query);
    }

    public function get_by_code($code) {
      $query = sprintf("SELECT * FROM %s WHERE coupon_code = '%s' LIMIT 1", "coupons", $code);
      return $this->fetch_row($query);
    }
    
    

    private function fetch_row($query) {
      $coupon = new Coupon();
      $result = mysqli_query($GLOBALS['dbc'], $query) or die(mysqli_error($GLOBALS['dbc']));
      if(mysqli_num_rows($result)) {
        $row = mysqli_fetch_assoc($result);
        $coupon->coupon_id    = $row['id'];
        $coupon->coupon_code  = $row['coupon_code'];
        $coupon->coupon_value = $row['coupon_value'];
        $coupon->coupon_type  = $row['coupon_type'];
        $coupon->valid_to     = $row['valid_to'];
        $coupon->cat_id       = $row['cat_id'];
        $coupon->status       = $row['status'];
        return $coupon;
      } else {
        return false;
      }
    }

    public function is_valid() {
      $today = new DateTime(date('Y-m-d'));
      $expire = new DateTime($this->valid_to);

      return $today < $expire && $this->status == "active";
    }

    public function is_valid_for($user_id) {
      if(!$user_id) { return false; }
      $query = sprintf("SELECT * FROM %s WHERE user_id = %d AND coupon_id = '%d'",
        "users_coupons", $user_id, $this->coupon_id);
      $result = mysqli_num_rows(mysqli_query($GLOBALS['dbc'], $query));
      return $result == 0;
    }

    public function no_deal($qty, $price, $prd_id, $prd_table) {
      $data = mysqli_query($GLOBALS['dbc'], "SELECT price FROM $prd_table WHERE id = $prd_id");
      $row = mysqli_fetch_assoc($data);
      if ($price == $row['price']) {
        return true;
      }
      return false;
    }

    public function belongs_to_product_category($product_category) {
      //99 denotes all category
      if ($this->cat_id == 99) {
        if ($product_category == 'CyberSale') {
          return false;
        }
        return true;
      }
      else {
        $query = sprintf("SELECT cat_id FROM %s WHERE name = '%s'", "product_cats", $product_category);
        $result = mysqli_query($GLOBALS['dbc'], $query) or die(mysqli_error($GLOBALS['dbc']));
        $row = mysqli_fetch_assoc($result);
        if($row['cat_id'] == $this->cat_id) {
          return true;
        } else {
          return false;
        }
      }
    }

    public function get_discount_value($amount) {
    	$discount='';
      if($this->coupon_type == "percentage") {
        $discount = $amount * ($this->coupon_value / 100);
      } elseif($this->coupon_type == "fixed") {
        $discount = $this->coupon_value;
      }
      return $amount - (int)$discount;
    }
    
    public function apply_coupon($amount,$coupon_id) {
    	
    	$coupon   = $this->find_by_id($coupon_id);
    	if (!$coupon) {
    		return $amount;
    	}else {
    		$this->coupon_type = $coupon->coupon_type;
    		$this->coupon_value = $coupon->coupon_value;
    		return $this->get_discount_value($amount);
    	}
    	
    	return false;
    	
    }
    public function coupon_value_to_s() {
      if($this->coupon_type == "percentage") {
        $to_string = $this->coupon_value."% off";
      } else {
        $to_string = "&#8358;".$this->coupon_value." off";
      }
      return $to_string;
    }

    public function save() {
      if(!$this->get_by_code($this->coupon_code)) {
        $query = sprintf("INSERT INTO coupons (coupon_code, coupon_value, coupon_type, valid_to, cat_id) VALUES ('%s', '%s', '%s', '%s', %d)",
          mysqli_real_escape_string($GLOBALS['dbc'], $this->coupon_code),
          mysqli_real_escape_string($GLOBALS['dbc'], $this->coupon_value),
          mysqli_real_escape_string($GLOBALS['dbc'], $this->coupon_type),
          mysqli_real_escape_string($GLOBALS['dbc'], $this->valid_to), $this->cat_id);

      } else { return false; }
      return mysqli_query($GLOBALS['dbc'], $query) or die(mysqli_error($GLOBALS['dbc']));
    }

    public function save_for_user($user_id) {
      if($this->is_valid_for($user_id)) {
      	$c = new Coupon();
        $query = $this->query("INSERT INTO users_coupons (user_id, coupon_id) VALUES ('{$user_id}', '{$this->coupon_id}') ");
       return true;
      } else {
        return false;
      }
    }

    public function delete($col=null,$val=null) {
      $query = sprintf("UPDATE %s SET status = '%s' WHERE id = %d", "coupons", "deleted", $this->coupon_id);
      return mysqli_query($GLOBALS['dbc'], $query);
    }
  }
?>