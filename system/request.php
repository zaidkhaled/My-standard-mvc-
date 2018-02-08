<?php


class Request
{
    public $get = array();
    public $cookie = array();
    public $server = array();
    public $post = array();
    public $request = array();
    public $files = array();
    
    public function __construct()
    {
        $_GET          =$this->clean($_GET);
        $_COOKIE       =$this->clean($_COOKIE);
        $_POST         =$this->clean($_POST);
        $_SERVER       =$this->clean($_SERVER);
        $_REQUEST      =$this->clean($_REQUEST);
        $_FILES        =$this->clean($_FILES);
        
        $this->get     = $_GET;
        $this->post    = $_POST;
        $this->server  = $_SERVER; 
        $this->request = $_REQUEST;
        $this->cookie  = $_COOKIE;
        $this->files   = $_FILES;
    }
    
    private function clean($data)
    {
        if(is_array($data))
        {
            foreach($data as $key => $value)
            {
                unset($data[$key]);
                $data[$this->clean($key)] = $this->clean($value);
            }
        }
        else
        {
            $data = htmlspecialchars($data, ENT_COMPAT, 'UTF-8');    
        }
        
        return $data;
        
    }
}