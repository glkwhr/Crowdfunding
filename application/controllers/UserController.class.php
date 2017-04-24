<?php
class UserController extends Controller {

	function register() {
		if ($_SERVER["REQUEST_METHOD"] == "POST") {
			$data['uname'] = $this->getInput($_POST['usrname']);
			$data['upwd'] = $this->getInput($_POST['pwd']);
			$data['name'] = $this->getInput($_POST['realname']);
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
			
			// TODO 1. validate input data 2. assign error message
			$userModel = new UserModel();
			if ($res = $userModel->isInvalid($data)) {			
				$this->assign('errors', $res);
				$this->assign('mode', 'failed');
			} else {
				$data['upwd'] = password_hash($data['upwd'], PASSWORD_DEFAULT);
				if ($userModel->add($data)) {
					// successfully registered
					$this->assign('mode', 'successful');
				} else {
					// failed to register
					$this->assign('mode', 'failed');
				}
			}
		} else {
			$this->assign('mode', 'register'); // show register page
		}
		$this->assign('title', 'Register');
		$this->render();
	}
}