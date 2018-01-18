<?php 


abstract class model
{
    protected $registry;
    
    public function __construct($registry)
    {
        $this->registry = $registry;
    }
    
    public function __set($key, $value)
    {
        $htis->registry -> set($key, $value);
    }
    
    public function __get($key)
    {
        return $this->registry ->get($key);
    }
}