<?php
/**
 *  SuperClass of Controllers
 */
class Controller {
	protected $_controller;
	protected $_action;
	protected $_view;

	public function __construct($controller, $action) {
		$this->_controller = $controller;
		$this->_action = $action;
		$this->_view = new View($controller, $action);
	}

	public function assign($name, $value) {
		$this->_view->assign($name, $value);
	}

	public function render() {
		$this->_view->render();
	}
	
	public function getInput($data) {
		// page security
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}
}