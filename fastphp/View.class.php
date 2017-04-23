<?php

class View
{
	protected $variables = array();
	protected $_controller;
	protected $_action;

	function __construct($controller, $action)
	{
		$this->_controller = $controller;
		$this->_action = $action;
	}

	public function assign($name, $value)
	{
		$this->variables[$name] = $value;
	}

	public function render()
	{
		extract($this->variables); // Variables are used in the .php files below
		$defaultHeader = APP_PATH . 'application/views/header.php';
		$defaultFooter = APP_PATH . 'application/views/footer.php';
		$defaultLayout = APP_PATH . 'application/views/layout.php';

		$controllerHeader = APP_PATH . 'application/views/' . $this->_controller . '/header.php';
		$controllerFooter = APP_PATH . 'application/views/' . $this->_controller . '/footer.php';
		$controllerLayout = APP_PATH . 'application/views/' . $this->_controller . '/' . $this->_action . '.php';

		if (file_exists($controllerHeader)) {
			include ($controllerHeader);
		} else {
			include ($defaultHeader);
		}

		if (file_exists($controllerLayout)) {
			include ($controllerLayout);
		} else {
			include ($defaultLayout);
		}

		if (file_exists($controllerFooter)) {
			include ($controllerFooter);
		} else {
			include ($defaultFooter);
		}
	}
}