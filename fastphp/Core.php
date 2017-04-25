<?php
/**
 * fastphp Core
 */
class Core {

	public function run() {
		spl_autoload_register(array(
				$this,
				'loadClass' 
		));
		$this->setReporting();
		$this->removeMagicQuotes();
		$this->unregisterGlobals();
		$this->route();
	}
	
	// Routing
	public function route() {
		$controllerName = 'Index';
		$action = 'index';
		$param = array();
		
		$url = isset($_GET['url']) ? $_GET['url'] : false;
		if ($url) {
			$urlArray = explode('/', $url);
			$urlArray = array_filter($urlArray);
			
			$controllerName = ucfirst($urlArray[0]);
			
			array_shift($urlArray);
			$action = $urlArray ? $urlArray[0] : 'index';
			
			array_shift($urlArray);
			$param = $urlArray ? $urlArray : array();
		}
		
		$controller = $controllerName . 'Controller';
		
		if ((int)method_exists($controller, $action)) {
			//error_log($action);
			$dispatch = new $controller($controllerName, $action);
			call_user_func_array(array(
					$dispatch,
					$action 
			), $param);
		} else {
			header('location:' . APP_URL);
			//error_log($controller . " Controller does not exist.");
			//exit($controller . "Controller does not exist.");
		}
	}

	public function setReporting() {
		if (APP_DEBUG === true) {
			error_reporting(E_ALL);
			ini_set('display_errors', 'On');
		} else {
			error_reporting(E_ALL);
			ini_set('display_errors', 'Off');
			ini_set('log_errors', 'On');
			ini_set('error_log', RUNTIME_PATH . 'logs/error.log');
		}
	}

	public function stripSlashesDeep($value) {
		$value = is_array($value) ? array_map(array(
				$this,
				'stripSlashesDeep' 
		), $value) : stripslashes($value);
		return $value;
	}

	public function removeMagicQuotes() {
		if (get_magic_quotes_gpc()) {
			$_GET = isset($_GET) ? $this->stripSlashesDeep($_GET) : '';
			$_POST = isset($_POST) ? $this->stripSlashesDeep($_POST) : '';
			$_COOKIE = isset($_COOKIE) ? $this->stripSlashesDeep($_COOKIE) : '';
			$_SESSION = isset($_SESSION) ? $this->stripSlashesDeep($_SESSION) : '';
		}
	}

	public function unregisterGlobals() {
		if (ini_get('register_globals')) {
			$array = array(
					'_SESSION',
					'_POST',
					'_GET',
					'_COOKIE',
					'_REQUEST',
					'_SERVER',
					'_ENV',
					'_FILES' 
			);
			foreach ($array as $value) {
				foreach ($GLOBALS[$value] as $key => $var) {
					if ($var === $GLOBALS[$key]) {
						unset($GLOBALS[$key]);
					}
				}
			}
		}
	}

	public static function loadClass($class) {
		$frameworks = FRAME_PATH . $class . '.class.php';
		$controllers = APP_PATH . 'application/controllers/' . $class . '.class.php';
		$models = APP_PATH . 'application/models/' . $class . '.class.php';
		
		if (file_exists($frameworks)) {
			include $frameworks;
		} elseif (file_exists($controllers)) {
			include $controllers;
		} elseif (file_exists($models)) {
			include $models;
		} else {
			// Error
		}
	}
}