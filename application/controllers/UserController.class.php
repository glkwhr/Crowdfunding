<?php
class UserController extends Controller {
	const EXPIRE_SEC = 60;

	function login() {		
		// TODO use JWT instead of saving password in cookies
		if ($_SERVER["REQUEST_METHOD"] == "POST") {
			$data['uname'] = $this->getInput($_POST['usrname']);
			$data['upwd'] = $this->getInput($_POST['pwd']);
			
			$userModel = new UserModel();			
			$user = $userModel->login($data['uname'], $data['upwd']);
			if (empty($user)) {
				$this->assign('errors', array('error' => 'wrong username or password'));
				$this->assign('mode', 'failed');
			} else {				
				if (!empty($user)) {
					// successfully logged in
					session_start();
					$_SESSION['user'] = $user;
					if (!empty($_POST['remember'])) {
						setcookie("username", $data['uname'], time() + UserController::EXPIRE_SEC);
						setcookie("password", $data['upwd'], time() + UserController::EXPIRE_SEC);
					}
					$this->assign('mode', 'succeeded');
				} else {
					// failed to log in
					$this->assign('mode', 'failed');
				}
			}
		} else {
			if ((new UserModel())->checkLogin()) {
				// login page can only be accessed by guests
				header('location:' . APP_URL);
			} else {
				$this->assign('mode', 'login');
			}
		}
		$this->assign('title', 'Login');
		$this->render();
	}
	
	function logout() {
		if (session_status() == PHP_SESSION_NONE) {
		    session_start();
		}
		if (isset($_SESSION['user'])) {
			unset($_SESSION['user']);
			if(!empty($_COOKIE['username']) || !empty($_COOKIE['password'])){
				setcookie("username", null, time() - UserController::EXPIRE_SEC);
				setcookie("password", null, time() - UserController::EXPIRE_SEC);
			}
		}
		header('location:' . APP_URL);
	}
	
	function register() {
		if ((new UserModel())->checkLogin()) {
			// register page can only be accessed by guests
			header('location:' . APP_URL);
		} else {
			if ($_SERVER["REQUEST_METHOD"] == "POST") {
				$data = $this->getData();
				// 1. validate input data 2. assign error message
				$userModel = new UserModel();
				if ($res = $userModel->isInvalidInsert($data)) {
					$this->assign('errors', $res);
					$this->assign('mode', 'failed');
				} else {
					$data['upwd'] = password_hash($data['upwd'], PASSWORD_DEFAULT);
					if ($userModel->add($data)) {
						// successfully registered
						$this->assign('mode', 'succeeded');
					} else {
						// failed to register
						$this->assign('mode', 'failed');
					}
				}
			} else {
				$this->assign('mode', 'register'); // show register page
			}
		}
		$this->assign('title', 'Register');
		$this->render();
	}
	
	function home() {
		if ((new UserModel())->checkLogin()) {
			$this->assign('title', 'Timeline');
			$this->render();
		} else {
			header("location:" . APP_URL . "/user/login");
		}
	}
	
	function profile() {
		$userModel = new UserModel();
		if ($userModel->checkLogin()) {
			if ($_SERVER["REQUEST_METHOD"] == "POST") {
				$data = $this->getData();
				$res = array();
				if (empty($userModel->login($data['uname'], $data['upwd'])) || $res = $userModel->isInvalidUpdate($data)) {
					if (empty($res)) {
						$res['upwdError'] = "wrong password";
					}
					$this->assign('errors', $res);
					$this->assign('mode', 'failed');
				} else {
					if (isset($data['newpwd'])) {
						$data['upwd'] = $data['newpwd'];
						unset($data['newpwd']);
					}
					$data['upwd'] = password_hash($data['upwd'], PASSWORD_DEFAULT);
					if ($userModel->update($data['uname'], $data)) {
						// successfully updated
						$this->assign('mode', 'succeeded');
					} else {
						// failed to update
						$this->assign('mode', 'failed');
					}
				}
			} else {
				$this->assign('mode', 'profile');
			}
			if (session_status() == PHP_SESSION_NONE) {
				session_start();
			}
			$data = $userModel->select($_SESSION['user']['username']);
			$this->assign('data', $data);
			$this->assign('title', 'Profile');
			$this->render();
		} else {
			header("location:" . APP_URL . "/user/login");
		}
	}
	
	function view($uname) {
		if (empty($uname) || empty($row = (new UserModel())->select($uname))) {
			header("location:" . APP_URL);
		}
		$guest = "";
		if ((new UserModel())->checkLogin()) {
			if (session_status() == PHP_SESSION_NONE) {
				session_start();
			}
			$guest = $_SESSION['user']['username'];
		}
		if (empty($guest)) {
			$this->assign('mode', 'guest');
		} else if ($guest == $row['uname']) {
			header("location:" . APP_URL . "/user/profile");
		} else {
			$this->assign('mode', 'user');
		}
		$this->assign('row', $row);
		$this->render();
	}
	
	function history() {
		
	}
	
	function getData() {
		$data['uname'] = $this->getInput($_POST['usrname']);
		$data['upwd'] = $this->getInput($_POST['pwd']);
		$data['name'] = $this->getInput($_POST['realname']);
		if (isset($_POST['newpwd']) && !empty($_POST['newpwd'])) {
			$data['newpwd'] = $this->getInput($_POST['newpwd']);
		}
		if (!empty($_POST['creditcardnum'])) {
			$data['ccn'] = $this->getInput($_POST['creditcardnum']);
		}
		if (!empty($_POST['email'])) {
			$data['email'] = $this->getInput($_POST['email']);
		}
		if (!empty($_POST['addr'])) {
			$data['addr'] = $this->getInput($_POST['addr']);
		}
		if (!empty($_POST['interest'])) {
			$data['interest'] = $this->getInput($_POST['interest']);
		}
		return $data;
	}
}