<?php require_once 'class.db.php';

class UserStage  extends DB {

    public $id;
    public $email;
    public $token;
    public $time;
     public $first_name;
    public $last_name;
    public $password;
  

    
    public $status;
    
    protected $table_name='user_stage';
    protected static $_instance = null;


    public function find_by_id($id){
    	return $this->find('id', $id);
    }

  
  }
?>