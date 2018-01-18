<?php 


class Controller
{
    private $registry;
    
    private $error;
    
    public function __construct($registry)
    {
        $this ->registry = $registry;
    }
    
    public function __set($key, $value)
    {
        $this ->registry->set($key, $value);
    }
    
    public function __get($key)
    {
        return $this->registry->get($key);
    }
    
    public function dispatch($route, $error)
    {
        $this ->error = $error;
        $execute = $this ->execute($route);
    }
    
    private function execute($route)
    {
        if(file_exists($route->getFile()))
        {
            require_once $route->getFile() ;
            
            $class = $route-> getController();
            
            $controller = new $class($this->registry);
            
            if(is_callable(array($controller, $route-> getMethod())))
            {
                $action = call_user_func_array(array($controller, $route->getMethod()), array());
               
            }
            else
            {
                $action = $this -> notFound();

            }

        }
        else
        {
            $action = $this -> notFound();

        }
            
            return $action;
    }
    
    private function notFound()
    {
        require_once $this -> error->getFile();
        $class = $this -> error -> getController();
        $controller = new $class($this->registry);
        return call_user_func_array(array($controller, $this->error->getMethod()),array());
    }
}