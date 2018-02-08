<?php


class Session
{
    public $data = array();

    public function __construct()
    {
        $this->data =& $_SESSION ;
    } 
}
