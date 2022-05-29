<?php  session_start(); 

	require_once('classes/class.db.php');
	require_once $_SERVER["DOCUMENT_ROOT"].'/init/autoload.php';
	

	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		$user_name = DB::getInstance()->prep(Input::get('uname'));
		$password =  DB::getInstance()->prep(Input::get('pword'));
		$response = '';
	    $data = User::getInstance()->run_sql("SELECT id, first_name, last_name, address, state_id, phone FROM users where email = '$user_name' OR username = '$user_name' AND password = '$password' AND is_verified = 1 LIMIT 1");

		$data = !empty($data ) ? array_shift($data) : null;
		

		if ($data) {
		   
		    $_SESSION['user_id'] = $data->id;
			$user = array(
				'id' => $data->id,
				'logged_in' => true
			);
			setcookie('user', json_encode($user),  time() + (60 * 30), '/'); //cookie expires in 20yrs
		    echo  $_SESSION['user_id'];

			echo $response = trim('logged in');
		}

		else {
			echo $response = trim('failed');
		}

		//echo $response;

		//echo 'DATA => ' . mysqli_num_rows($data);
	}

	if ($_SERVER['REQUEST_METHOD'] == 'GET') {
		if (isset($_COOKIE['user'])) {
			setcookie('user', '', time() - 3600, '/'); //set cookie to one hour to the past; expired
			echo 'logged out';
		}
	}
?>