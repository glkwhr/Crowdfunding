<?php
defined('FRAME_PATH') or define('FRAME_PATH', __DIR__ . '/');
defined('APP_PATH') or define('APP_PATH', dirname($_SERVER['SCRIPT_FILENAME']) . '/');
defined('APP_DEBUG') or define('APP_DEBUG', false);
defined('CONFIG_PATH') or define('CONFIG_PATH', APP_PATH . 'config/');
defined('RUNTIME_PATH') or define('RUNTIME_PATH', APP_PATH . 'runtime/');

require APP_PATH . 'config/config.php';

require FRAME_PATH . 'Core.php';

$fast = new Core();
$fast->run();