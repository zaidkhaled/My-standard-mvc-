<?php


class Document
{
    private $title;
    private $description;
    
    public function setTitle($title)
    {
        $this->title =$title;
    }
    
    public function getTitle()
    {
        return $this->title;
    }
    
    public function setDescription($description)
    {
        $this->description = $description;
    }
    
    public function getDescription()
    {
        return $this->description;
    }
}