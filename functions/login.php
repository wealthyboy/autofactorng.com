<?php
	function isLoggedIn() {
		if (isset($_COOKIE['user']) && !empty($_COOKIE['user'])) {
			return true;
		}

		else {
			return false;
		}
	}


	/*function isLoggedIn() {
		if (isset($_COOKIE['user'])) {
			$user = json_decode($_COOKIE['user'], true);
			if ($user['logged_in'] == true) {
				return true;
			}

			else {
				return false;
			}
		}

		else {
			return false;
		}
	}*/
?>