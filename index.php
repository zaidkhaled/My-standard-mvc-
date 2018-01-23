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
require_once SYSTEM_DIR . 'helpers.php';

// registry class

$registry = new registry();

// request class

$request = new Request();
$registry->set('Request', $request);

// controller class

$controller = new Controller($registry);


// session class

$session = new Session();
$registry ->set('Session', $session);


// document class

$document = new Document();
$registry ->set('Document', $document);

// class database

$db = new DB(SERVER_NAME, DB_NAME, DB_USER, DB_PASSWORD);
$registry->set('db', $db);

// setting class

$setting  = new Setting();
$registry->set('Settings', $setting);


// fetch setting

$sql = "SELECT * FROM aws." . DB_PREFIX . 'setting LIMIT 1';
$query = $db->query($sql);
$query->execute();
$settings_result = $query->fetch();

foreach($settings_result as $key => $value)
{
    $setting->set($key, $value);
}



// fetch langs info

$sql = "SELECT * FROM aws." . DB_PREFIX . 'langs WHERE status = 1';
$query = $db->query($sql);
$query -> execute();
$fetch_langs = $query->fetchAll();

foreach ($fetch_langs as $lang)
{
    $langs[$lang['code']] = $lang;
}


$current_lang = $langs[$setting->get('lang')];

// lang class 

$language = new Lang($current_lang['dir']);
$registry->set('Lang', $language);


//model class

$loder = new Loder($registry);
$registry->set('Loder', $loder);


// url class 

$url = new Url(HTTP_SERVER);
$registry->set('Url', $url);


// Route class

$route = (isset($request->get['route']) ? new Route($request->get['route']) : new Route('page/home'));

$controller->dispatch($route, new Route('error/not_found')); 



