<?php

class CommenHeaderController extends Controller
{
    public function index()
    {
        
        $template = '/template/commen/header.php';
        
        $this->Lang->load('page/home'); 
      
        $this->data['lang_code'] = $this->Lang->get('code');
        
        $this->data['direction'] = $this->Lang->get('direction');
        
        if(file_exists(VIEW_DIR . $this->Settings->get('theme') . $template))
        {
            $this->template = VIEW_DIR . $this->Settings->get('theme') . $template;
        }
        else
        {
            $this->template = VIEW_DIR . 'defult' . $template;
        }
        
        $this->render();
    }
    
}