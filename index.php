<?php

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

$registry = new registry();

$route = (isset($_GET['route']) ? new Route($_GET['route']) : new Route('page/home'));