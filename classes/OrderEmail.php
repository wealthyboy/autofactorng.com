<?php
require_once 'class.db.php';

	class OrderEmail  extends DB{
		public $id;
		public $email;
		public $order_id;
		public $state_id;
		public $fullname;
		public $phone;
		public $address;
		public $city;
		public $landmark;
		
		public $fielde ='id';
	
	    protected $table_name='order_email';
	    protected static $_instance;

	

		
    public function __get($property) {
    	if (property_exists($this, $property)) {
    		return $this->$property;
    	}
    }
    
    public function __set($property, $value) {
    	if (property_exists($this, $property)) {
    		$this->$property = $value;
    	}
    
    	return $this;
    }
		public function get($field) {
			return $this->$field;
		}

	public function set($field, $val) {
			if ($field == 'item_name' || $field == 'item_price' || $field == 'item_category') {
				$this->{$field}[] = $val;
			}

			else {
				$this->$field = $val;
			}
	}

	public function get_by_id($id) {
      $query = sprintf("SELECT * FROM %s WHERE order_id = %d", "orders", $id);
      return $this->fetch_row($query);
    }
    
    public function find_by_id($id){
    	return $this->find('id', $id);
    }

    public function get_by_tracking($number) {
      $query = sprintf("SELECT * FROM %s WHERE tracking_number = '%s'", "orders", $number);
      return $this->fetch_row($query);
    }

    public function update_status($status) {
    	$order_id = $this->order_id;
    	$data = mysqli_query($GLOBALS['dbc'], "UPDATE orders SET order_status = '$status' WHERE order_id = $order_id");
    	if ($data) {
    		$this->set('order_status', $status);
    		return true;
    	} return false;
    }

    public function upToHrs($h) {
    	$order_date_time = new DateTime(str_replace('/', '-', $this->order_date).' '.$this->order_time);
    	$order_time_stamp = $order_date_time->getTimeStamp();
    	// $order_date_time = new DateTime(strtotime($this->order_date).' '.$this->order_time);
    	// $interval = $today->diff($order_date_time);
    	$time_diff = time() - $order_time_stamp;
    	return ( ($time_diff/3600) >= $h );
    }

		/*public function timeDiff($time) {
			// $time = time() - $time; // to get the time since that moment

			$tokens = array (
				31536000 => 'year',
				2592000 => 'month',
				604800 => 'week',
				86400 => 'day',
				3600 => 'hour',
				60 => 'minute',
				1 => 'second'
			);

			foreach ($tokens as $unit => $text) {
				if ($time < $unit) continue;
				return $time;
			}

			/*foreach ($tokens as $unit => $text) {
				if ($time < $unit) continue;
				$numberOfUnits = floor($time / $unit);
				return $numberOfUnits.' '.$text.(($numberOfUnits>1)?'s':'');
			}
		}*/
    

    
    
		public function fetch_row($query) {
      $order = new Order();
      $result = mysqli_query($GLOBALS['dbc'], $query) or die(mysqli_error($GLOBALS['dbc']));
      if(mysqli_num_rows($result)) {
        $row = mysqli_fetch_assoc($result);
        $order->order_id       			= $row['order_id'];
        $order->tracking_number       = $row['tracking_number'];
        $order->user_id        = $row['user_id'];
        $order->order_day      = $row['order_day'];
        $order->order_date     = $row['order_date'];
        $order->order_time     = $row['order_time'];
       
        $order->payment_method = $row['payment_method'];
        $order->order_type 		 = $row['order_type'];
        $order->order_status 		 = $row['order_status'];
     
      	return $order;
      } else {
        return false;
      }
    }

		public function list_info() {
			$order_details = <<<EOT
			USER ID ==> $this->user_id <br /><br />
			ORDER DAY ==> $this->order_day <br /><br />
			ORDER DATE ==> $this->order_date <br /><br />
			ORDER TIME ==> $this->order_time <br /><br />
			PAYMENT METHOD ==> $this->payment_method <br /><br />
EOT;

			return $order_details;
		}
		
		public  function store(){
			
		}

		public function save() {
			$items = $this->item_name;
			$prices = $this->item_price;
			$categories = $this->item_category;

			$items_string = implode(', ', $items);
			$prices_string = implode(', ', $prices);
			$categories_string = implode(', ', $categories);

			$query = sprintf("INSERT INTO orders(tracking_number, user_id, order_day, order_date, order_time, item_name, item_price, payment_method, order_type, item_category, coupon_id) VALUES('%s', %d, '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', %d)", 
				$this->tracking_number, $this->user_id, $this->order_day, $this->order_date, $this->order_time, $items_string, $prices_string, $this->payment_method, $this->order_type, $categories_string, $this->coupon_id);

			$data = mysqli_query($GLOBALS['dbc'], $query);

			if ($data) {
				return true;
			}

			else {
				return false;
			}
		}
	}
?>