<?php require_once 'class.db.php';

class Coupon  extends DB {
    public $coupon_id;
    public $id;
    public $coupon_code;
    public $coupon_value;
    public $coupon_type;
    public $valid_to;
    public $cat_id;
    public $type;

    
    public $status;
    
    protected $table_name='coupons';
    protected static $_instance = null;


    public function find_by_id($id){
    	return $this->find('id', $id);
    }

  
  }
?>