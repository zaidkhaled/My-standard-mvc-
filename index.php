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

// Route class

$route = (isset($request->get['route']) ? new Route($request->get['route']) : new Route('page/home'));

// controller class

$controller = new Controller($registry);

$controller->dispatch($route, new Route('error/not_found')); 

// request class

$request = new Request();
$registry->set('Request', $request);

// session class

$session = new Session();
$registry ->set('Session', $session);


// document class

$document = new Document();
$registry ->set('Document', $document);

// clear class

$clear = new Clear();
$registry->set("Clear", $clear);

//model class

$loder = new Loder($registry);
$registry->set('Loder', $loder);

$loder->model("test/home");
$registry->get('model_test_home')->Amm();







