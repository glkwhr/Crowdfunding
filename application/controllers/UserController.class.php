<?php

class UserController extends Controller
{
	function register()
	{
		if (isset($_POST['usrname']) && isset($_POST['pwd']) && isset($_POST['realname'])) {
			$data['uname'] = $_POST['usrname'];
			$data['upwd'] = password_hash($_POST['pwd'], PASSWORD_DEFAULT);
			$data['name'] = $_POST['realname'];
			if ((new UserModel)->add($data) == 1) {
				// successfully registered
				$this->assign('title', 'Registration Succeeded');
				$this->assign('mode', 'successful');
			} else {
				// failed to register
				$this->assign('title', 'Registration Failed');
				$this->assign('mode', 'failed');
			}
		} else {
			$this->assign('title', 'Register');
			$this->assign('mode', 'register'); // show register page
		}
		$this->render();
	}
}