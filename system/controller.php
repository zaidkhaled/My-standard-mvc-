<?php 


class Controller
{
    protected $data = array();
    protected $childern = array();
    protected $template;
    private $registry;
    private $error;
    private $output;
    
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
    
    public function redirect($route)
    {
       header('location'.$route);
       exit();
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
                return $this->output; // output ist nicht klar fur mich 
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
    
    protected function render()
    {
        foreach($this->childern as $child)
        {
            $this->data[basename($child)] = $this->child($child);
        }
        
        if(file_exists($this->template))
        {
            extract($this->data);
            ob_start();
            require_once $this->template;
            $this->output = ob_get_contents();
            ob_end_clean();
            return $this->output; 
        }
        else 
        {
            die($this->template . 'not found pleace check it');
        }
    }
    
    private function child($child)
    {
        $route = new Route($child); 
        
        if(file_exists($route->getFile()))
        {
            require_once $route->getFile() ;
            
            $class = $route-> getController();
            
            $controller = new $class($this->registry);
            
            if(is_callable(array($controller, $route-> getMethod())))
            {
                $action = call_user_func_array(array($controller, $route->getMethod()), array());
                 return $controller->output;
            }
            else
            {
                echo "child controller method was not found";
            }
        }
        else
        {
            echo "child controller was not found";

        }
 
    }
    
    private function notFound()
    {
        require_once $this -> error->getFile();
        $class = $this -> error -> getController();
        $controller = new $class($this->registry);
        return call_user_func_array(array($controller, $this->error->getMethod()),array());
    }
}