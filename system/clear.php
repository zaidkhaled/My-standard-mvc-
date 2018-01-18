<?php

class Clear
{
    public function data($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        return $data;
    }
    
    public function string($data) 
    {
        $data = trim($data);
        return filter_var($data, FILTER_SANITIZE_STRING);
    }
    
    public function integer($integer)
    {
        return (int) $integer;
    }
    
    public function email($email)
    {
        return filter_var($email, FILTER_SANITIZE_EMAIL);
    }
    
    public function url($url)
    {
        return filter_var($url, FILTER_SANITIZE_URL);
    }
}