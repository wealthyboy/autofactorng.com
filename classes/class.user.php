<?php  require_once 'class.db.php';
	class User extends DB{
		private $user_id;
		private $first_name;
		private $last_name;
		private $email;
		private $phone;
		private $address;
		private $state_id;
		private $city;
		private $landmark;
		private $username;
		private $password;
		protected $table_name='users';
		protected static $_instance;

		public function __construct() {
			$this->user_id = null;
			$this->first_name = '';
			$this->last_name = '';
			$this->email = '';
			$this->phone = '';
			$this->address = '';
			$this->state_id = null;
			$this->city = '';
			$this->landmark = '';
			$this->username = '';
			$this->password = null;
		}

		public function get($field) {
			return $this->$field;
		}

		public function set($field, $val) {
			$this->$field = $val;
		}
		
		public function find_by_id($id){
			return $this->find('id', $id);
		}
		

		public function get_by_id($id) {
      $query = sprintf("SELECT * FROM %s WHERE id = %d", "users", $id);
      return $this->fetch_row($query);
    }

    public function get_by_username($username) {
      $query = sprintf("SELECT * FROM %s WHERE username = '%s'", "users", $username);
      return $this->fetch_row($query);
    }
    
    

    public function get_state($id) {
      $query = sprintf("SELECT * FROM %s WHERE id = %d", "state", $id);
      $result = mysqli_query($GLOBALS['dbc'], $query) or die(mysqli_error($GLOBALS['dbc']));
      $state = mysqli_fetch_assoc($result);
      return $state;
    }

    private function fetch_row($query) {
      $user = new User();
      $result = mysqli_query($GLOBALS['dbc'], $query) or die(mysqli_error($GLOBALS['dbc']));
      if(mysqli_num_rows($result)) {
        $row = mysqli_fetch_assoc($result);
        $user->user_id    = $row['id'];
        $user->first_name = $row['first_name'];
        $user->last_name  = $row['last_name'];
        $user->email      = $row['email'];
        $user->phone      = $row['phone'];
        $user->address    = $row['address'];
        $user->state_id   = $row['state_id'];
        $user->city       = $row['city'];
        $user->landmark   = $row['landmark'];
        $user->username   = $row['username'];
        $user->password   = $row['password'];
      	return $user;
      } else {
        return false;
      }
    }

    public function likes_product($cat_id, $prod_id) {
    	$user_id = $this->get("user_id");
    	$data = mysqli_query($GLOBALS['dbc'], "SELECT * FROM product_likes WHERE cat_id = $cat_id AND product_id = $prod_id AND user_id = $user_id");
    	if (mysqli_num_rows($data) > 0) {
    		return true;
    	}
    	return false;
    }
	}
?>