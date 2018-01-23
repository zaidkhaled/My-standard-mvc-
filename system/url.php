<?php

class Url
{
    private $url;
    
    public function __construct($url)
    {
        $this->url = $url;
    }
    
    public function link($route, $args = '')
    {
        $url  = $this ->url;
        
        $url .= 'index.php?route='. $route;
        
        if($args)
        {
            $url .= '&' . ltrim($args, '&');
        }
        
        return $url;
    }
 
}