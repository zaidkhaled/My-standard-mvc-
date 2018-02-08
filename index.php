<?php
error_reporting(E_ALL);
// include config file 

if (file_exists('config.php'))
{
    require_once  "config.php";
} 
else 
{
    dir("config NOT FOUND");
}

require_once SYSTEM_DIR . 'startup.php';

// registry class

$registry = new registry();

// request class

$registry->set('Request', new Request());


// controller class

$controller = new Controller($registry);


// session class

$registry ->set('Session', new Session());


// document class

$registry ->set('Document', new Document());

// class database

$registry->set('db', new DB(SERVER_NAME, DB_NAME, DB_USER, DB_PASSWORD));

// setting class

$registry->set('Settings', new Setting());


// fetch setting curent lang

$limit['limit'] = '1';

$limit['where'] = array("setting.theme",'defult', 'string');

$settings_result = $registry->get('db')->fetch('setting', $limit, "fetch");

define('MAX_FILE_SIZE', $settings_result['max_size']);

foreach ($settings_result as $key => $value)
{
    $registry->get('Settings')->set($key, $value);
}


// fetch langs info

$where['where'] = array('langs.status', 1, 'integer');

$fetch_langs = $registry->get('db')->fetch('langs');



foreach ($fetch_langs as $lang)
{
    $langs[$lang['code']] = $lang;
}

$total_langs = $registry->get('db')->rowCount();

$registry->get('Settings')->set('langs', $fetch_langs);

$registry->get('Settings')->set('total_langs', $total_langs);

$current_lang = $langs[$registry->get('Settings')->get('lang')];



// lang class 

$registry->set('Lang', new Lang($current_lang['dir']));

//model class

$registry->set('Loder', new Loder($registry));

// response class

$registry->set('Response', new Response());

// upload class

$registry->set('Upload', new Upload());

// url class 

$registry->set('Url', new Url(HTTP_SERVER));



// Route class
$route = (isset($registry->get('Request')->get['route']) ? new Route($registry->get('Request')->get['route']) : new Route('page/home'));

$controller->dispatch($route, new Route('error/not_found')); 

$registry->get('Response')->output();

