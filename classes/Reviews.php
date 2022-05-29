<?php 
require_once 'class.db.php';
require_once $_SERVER["DOCUMENT_ROOT"].'/init/autoload.php';
require $_SERVER["DOCUMENT_ROOT"].'/modules/phpmailer/PHPMailerAutoload.php';

class Reviews  extends DB { 
	
	public $id;
	public $product_id;
	public $title;
	public $description;
	public $user_id;
	public $rating_title;
	public $rating_title_value;
	public $product_name;
	public $product_price;
	public $product_image;
	protected $refrence_id='product_id';
	
	protected $table_name='reviews';
	protected static $_instance;
	public  $errors=[];
	
	public function find_by_id($id){
		return $this->find('id', $id);
	}
	
	public function all($col=[]){
		 
		if (!$col) {
			return $result = $this->run_sql("SELECT * FROM ".$this->table_name ." ORDER BY id DESC ");
		}
	
		if (!empty($col)) {
			return $result = $this->run_sql("SELECT ".implode(', ', $col)."FROM ".$this->table_name ." ORDER BY id DESC ");
		}
	
	}
	
	
	public function edit(){
		
	
	}

	public static function productReviews($product_id){
       $result = Reviews::getInstance()->find_where($product_id);
       return !empty($result) ? $result : false;
	}

	public static function findUser($user_id){
       $result = Reviews::getInstance()->run_sql("SELECT first_name,last_name,email FROM users WHERE id = '{$user_id}' LIMIT 1 ");
       return !empty($result) ? array_shift($result) : false;
	}

	public static function hasReply($review_id){
       $result = Reply::getInstance()->find_where($review_id);
		return !empty($result) ? array_shift($result) : false;
	}
	public function saveAndMail(){
	    
	        $user  =  User::getInstance()->find('id',Input::get('user_id'));
			
			$this->rating =Input::get('rating');
			$this->title = Input::get('title');
			$this->description = Input::get('desc');
			$this->product_id =  Input::get('product_id');
			$this->user_id      = Input::get('user_id');
			$this->product_name =  Input::get('product_name');
	        $this->product_price =  Input::get('product_price');
	        $this->product_image =  Input::get('product_image');
	        $this->rating_title =  Input::get('rating_title');
	        $this->rating_title_value=  Input::get('rating_title_value');

	     //    if(!preg_match('/^[A-ZA-Z0-9_-]*$/', $this->title)){
      //         $this->errors[] = "Title not accepted";
	     //    }
		   
		    // if(!preg_match('/^[A-ZA-Z0-9_-]/', $this->description)){
      //         $this->errors[] = "Description not accepted";
	     //    }

	     //    if (count($this->errors)) {
	     //    	echo json_encode($this->errors);
	     //    	return false;
	     //    }
			if ($this->Insert()) {
				$mail = new PHPMailer;

								

				$mail->isSMTP();
				$mail->Host = 'smtp.zoho.com';
				$mail->Port = 465;
				$mail->SMTPAuth = true;
				$mail->Username = 'reviews@autofactorng.com';
				$mail->Password = 'AFNGreviews0808';
				$mail->SMTPSecure = 'ssl';

				$mail->From = 'reviews@autofactorng.com';
				$mail->FromName = 'Autofactorng Team';
				$mail->addAddress('reviews@autofactorng.com', 'Autofactor');
				//$mail->AddCC('orders@autofactorng.com', 'Order');

				//$mail->addReplyTo('orders@autofactorng.com', 'Orders');

				$mail->WordWrap = 50;
				$mail->isHTML(true);

				$mail->Subject = 'New Review';

				$bodyc = "<h1 style= 'text-align: center ; color: #D43A16;'> New Review</h1>";
                $bodyc .= "<p style= ''>Product Name: $this->product_name </p>";
                $bodyc .= "<p >Price:  $this->product_price</p>";
                $bodyc .= "<p style= ''>Review Tilte: $this->title </p>";
                $bodyc .= "<p style= ''>Review: $this->description</p>";
                
                $bodyc .= "<p style= ''>Reviewer Email: $user->email</p>";

                $bodyc.= "";
				$mail->Body = "$bodyc";

				if ($mail->send() ) { 
                	echo "1";
				} else {
					 echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
				}
				$this->msg="Created";


				
			}
			
		
		
		return  false;
	}
	
}







?>