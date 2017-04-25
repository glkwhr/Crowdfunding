<?php
class IndexController extends Controller {

	function index() {
		if ((new UserModel())->checkLogin()) {
			header('location:' . APP_URL . '/user/home');
		} else {
			$this->assign('title', 'Crowdfunding');
			$this->assign('content', 'Welcome to Crowdfunding!');
		}
		
		$this->render();
	}
	
	function error() {
		$this->assign('title', 'Crowdfunding');
		$this->render();
	}
}