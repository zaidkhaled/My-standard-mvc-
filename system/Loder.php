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
       $class = str_replace(array('/', '_'), "", $model) . "Model";
        
       if(file_exists($file))
       {
           require_once $file;
           $this->registry->set('model_' . str_replace('/', '_', $model), new $class($this->registry));
       }
    }
}