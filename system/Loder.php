<?php 


class Loder
{
    private $registry;
    
    public function __construct($registry) 
    {
        $this->registry = $registry;
    }
    
    public function model($model)
    {
       $file  = MODEL_DIR.$model.'.php';
        
       $class_ex = explode("/", $model);
       
       array_push($class_ex, 'model'); 
        
       $class ="";
        
       foreach($class_ex as $part) { $part = ucfirst($part); $class .= $part; }
        
       if(file_exists($file))
       {
           require_once $file;
           
           $this->registry->set('model_' . str_replace('/', '_', $model), new $class($this->registry));
       }
       else 
       {
           echo 'this ' . $file . ' file is not exists';
       }
    }
}