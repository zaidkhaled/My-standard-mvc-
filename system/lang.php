<?php

class Lang
{
    private $directory;
    private $defult = "en";
    private $data = array();
    
    public function __construct($directory)
    {
        $this->directory = $directory;
    }
    
    public function get($key)
    {
        return (isset($this->data[$key]) ? $this->data[$key] : $key); 
    }
    
    public function load($filename)
    {
        $this->directory = (isset($this->directory) ? $this->directory : $this->defult);
        $file = LANGS_DIR. $this->directory . DS . $filename . '.php';
        
        if(file_exists($file))
        {
            $lang = array();
            require_once $file;
            $this->data = array_merge($lang, $this->data);
            return $this->data;
        }
        else
        {
            echo $file . "<br>";
            die($filename. " file not found in " . $this->directory . " file directory");
        }
    }
}