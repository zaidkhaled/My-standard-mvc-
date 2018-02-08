<?php 

class PagehomeController extends Controller 
{
  public function index()
  {
      $this->Document->setTitle($this->Lang->get("home_page"));
      pre($this->Request->files);
      
      // data 
      
      $this->data['post'] = $this->Url->link('page/post');
      
      // languge
      
      $this->Lang->load('page/home'); 
      
      $this->data['lang_code'] = $this->Lang->get('code');
      
      
      // Modal
      
      $this->Loder->model('page/home');    
      $this->data['langs'] = $this->model_page_home->getLanguage();
       
      
      
     // setting
      
      
    // contents
      
      $this->childern = array(
          "commen/header",
          "commen/footer"
      );
      
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
      
    $this->Response->setOutput($this->render());
  }
    
}