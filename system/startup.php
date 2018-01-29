<?php

// startup file 

session_start();

function autoload($system)
{
    $file = SYSTEM_DIR. strtolower($system).'.php';
    
    if(file_exists($file))
    {
        require $file;
    }
}

spl_autoload_register('autoload');

require_once SYSTEM_DIR . 'helpers.php';