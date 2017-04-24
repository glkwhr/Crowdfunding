<?php
class IndexController extends Controller {

	function index() {
		$this->assign('title', 'Crowdfunding');
		$this->assign('content', 'Welcome to Crowdfunding!');
		$this->render();
	}
}