<?php


class PageHomeModel extends Model
{
    public function getLanguage()
    {   
        return $this->db->fetch('langs');
        
    }
    
}