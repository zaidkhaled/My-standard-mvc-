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
        $file = (file_exists(LANGS_DIR. $this->directory . DS . $filename . '.php')) ? LANGS_DIR. $this->directory . DS . $filename . '.php' : LANGS_DIR. "en". DS . $filename . '.php';
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