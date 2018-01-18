<?php


class Session
{
    public $data = array();

    public function __construct()
    {
        $_SESSION =& $this->data;
    } 
}
