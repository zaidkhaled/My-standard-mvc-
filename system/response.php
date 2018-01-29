<?php


class Response
{
    private $output;
    
    public function setOutput($output)
    {
        $this->output = $output;
    }
    
    public function output()
    {
        $output = $this->output;
        echo $output;
    }
}