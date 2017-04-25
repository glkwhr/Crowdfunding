<?php
class UserModel extends Model {

	public function isInvalid($data) {
		$errors = array();
		foreach ($data as $type => $value) {
			switch ($type) {
				case 'uname':
					// validate username
					if (empty($value)) {
						$errors['unameError'] = "username cannot be empty";
					} else {
						if ($this->hasUname($value)) {
							$errors['unameError'] = "username already exists";
						}
					}
					break;
				case 'upwd':
					// TODO validate password
					if (empty($value)) {
						$errors['upwdError'] = "password cannot be empty";
					} else {

					}
					break;
				case 'name':
					// TODO validate realname
					if (empty($value)) {
						$errors['nameError'] = "name cannot be empty";
					} else {
						if (!preg_match("/^[a-zA-Z ]*$/", $value)) {
							$errors['nameError'] = "invalid name";
						}
					}
					break;
				case 'ccn':
					// TODO validate credit card number
					if (!is_numeric($value)) {
						$errors['ccnError'] = "invalid credit card number";
					}
					break;
				case 'email':
					// TODO validate email address
					if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
						$errors['emailError'] = "invalid email";
					}
					break;
				case 'addr':
					// TODO validate address
					break;
				case 'interest':
					// TODO validate interest
					if (!preg_match("/^[a-zA-Z ]*(,[a-zA-Z ]*)*$/", $value)) {
						$errors['interestError'] = "invalid interest(s)";
					}
			}
		}
		return $errors;
	}
	
	private function hasUname($uname) {
		$ret = false;
		if ($this->select($uname)) {
			$ret = true;
		}
		return $ret;
	}
	
	public function checkLogin() {
		if (session_status() == PHP_SESSION_NONE) {
		    session_start();
		}
		$ret = false;
		if (!isset($_SESSION['user']) || empty($_SESSION['user'])) {
			if (!empty($_COOKIE['username']) && !empty($_COOKIE['password'])) {
				// use cookies to login
				$user = $this->login($_COOKIE['username'], $_COOKIE['password']);
				if (!empty($user)) {
					$_SESSION['user'] = $user;
					$ret = true;
				}
			}
		} else {
			$ret = true;
		}
		return $ret;
	}
	
	public function login($username, $password) {
		$user = array();
		if (($upwd = $this->select('upwd', $username)) && password_verify($password, $upwd['upwd'])) {
			$user['username'] = $username;
		}
		return $user;
	}
}