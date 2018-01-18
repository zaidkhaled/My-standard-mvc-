<?php 

// prepare the website adresse 

define('HTTP_SERVER', "http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['SCRIPT_NAME']) . "/");

// SEPARATOR 

define('DS', DIRECTORY_SEPARATOR);

// DIRECTORIES

define('APP_DIR', __DIR__. DS);
define('SYSTEM_DIR', APP_DIR . 'system' . DS);
define('CONTROLLER_DIR', APP_DIR . 'controller' . DS);
define('MODEL_DIR', APP_DIR . 'model' . DS);
define('VIEW_DIR', APP_DIR . 'view' . DS);

// SERVER DATE 

define('SERVER_NAME', 'localhost'); 
define('DB_NAME', 'AWS');
define('DB_USER', 'root');
define('DB_PASSWORD', '');