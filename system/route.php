<?php 

class route 
{
    private $controller;
    private $file;
    private $method; 
    
    public function __construct($route)
    {
    // ?route =folder/page/method => if exists
        
    $parts = explode('/', rtrim($this->clear($route), "/"));
    
    $path = "";
    
    foreach($parts as $part)
    {
       $path .= $part; 
    
        if(is_dir(CONTROLLER_DIR.$path))
        {
            $path .='/';
            array_shift($parts);
            continue;
        } 
        $file = CONTROLLER_DIR . $path . '.php';
        
        if (file_exists($file))
        {
            $this-> file = $file;
            
            $this-> controller = str_replace(array('_', '/'), "", ucfirst($path)) . 'Controller';
            
            array_shift($parts);
            break;
        }
    }
        
    $method = array_shift($parts);
    $this ->method = ($method) ? $method : "index";
        
    }
    
    public function getFile() 
    {
        return $this->file;
    }
    public function getController()
    {
        return $this->controller;
    }
    public function getMethod()
    {
        return $this->method;
    }
    
    private function clear($route)
    {
        $route = filter_var($route,FILTER_SANITIZE_STRING);
        return $route;
    }

}