<?php 

class PagehomeController extends Controller 
{
  public function index()
  {
      // languge
      
      $this->Lang->load('page/home'); 
      
      $this->data['lang_code'] = $this->Lang->get('code');
      
      // Modal
      
      $this->Loder->model('page/home');    
      $this->data['langs'] = $this->model_page_home->getLanguage();
       
      
      
     // setting
      
//     echo $this->Settings->get('ads');
      
      
    // template
      
     $template = '/template/page/home.php';
      
     $this->data['temp'] = '/template/page/home.php'; // value to data array();
      
     if(file_exists(VIEW_DIR . $this->Settings->get('theme') . $template )) 
     {
         $this->template = VIEW_DIR . $this->Settings->get('theme') . $template;
         
     }
      else 
     {
        $this->template = VIEW_DIR . "defult" . $template;
     }
      
$this->render();
  }
    
}