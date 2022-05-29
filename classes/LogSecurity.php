<?php 
require_once 'class.db.php';
require_once $_SERVER["DOCUMENT_ROOT"].'/init/autoload.php';

class LogSecurity  extends DB{
	
   protected  $api = 'https://api.ipdata.co/%s';

   public $user_id;
   public $all_data;
   public $user_agent;
   public $created_at;
   public $session_id;
   public $insert_id; 
   protected static $_instance = null;
   protected   $table_name='user_details',
   $field='id';


   protected $properties = [];

   public function __get($key){
        if(isset($this->properties[$key])){
          return $this->properties[$key];
        }
   }

   public function request(){
   	    $ip   = $this->get_ip_address();
        $url  = sprintf($this->api, '154.120.91.109');
        $data = $this->sendRequest($url);
        $this->properties[] = json_decode($data,true);
        return !empty($data) ? json_decode($data,true) : false; 
   }

   public function sendRequest($url){
        $ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_HEADER, FALSE);

		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		  "Accept: application/json"
		));

		$response = curl_exec($ch);
		curl_close($ch);

		return $response;

   }

   public  function get_ip_address() {
        $ip_keys = array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR');
          foreach ($ip_keys as $key) {
            if (array_key_exists($key, $_SERVER) === true) {
              foreach (explode(',', $_SERVER[$key]) as $ip) {
                // trim for safety measures
                $ip = trim($ip);
                // attempt to validate IP
                if ($this->validate_ip($ip)) {
                    return $ip;
                }
            }
        }
    }
    return isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : false;
}


/**
 * Ensures an ip address is both a valid IP and does not fall within
 * a private network range.
 */
   public  function validate_ip($ip)
   {
	if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 | FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) === false) {
	    return false;
	}
	return true;
    }


}