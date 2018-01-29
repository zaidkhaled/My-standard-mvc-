<?php 

class PagehomeController extends Controller 
{
  public function index()
  {
      
      // data 
      
//      $data = array('username', 'zeid', 'string');
      
//      $data = array('profile_img', "pic.png");
     
//      $where = array(
//       array('user_id', "1", 'integer'),
//       array('password', 343434, 'integer'),
//       array('email', 'zeid_kaled@gmail.com', 'email')
//      );
      
      
//      $users = $this->db->save('user_file', $data);
//      
//      $user_id = $this->db->lastInsertId();
//      
//        echo $user_id;
//        
      
//      $options['where'] = array(
//          array('users.username', "zaid123123", "string", "=", "OR"),
//          array('users.username', "hassen_mnmnnm")
//          );
//      
//        $options['where'] = array('users.email', "hassen_mnmnnm", 'string');

//      $options['limit'] = array(4,6);
//  $options = array(
//  'select'  => array("users.username", "user_files.profile_img", "user_payment.mach"),
//      
//  'join'    => array(
//                               array('user_files', 'users.user_id', 'user_files.user_id'),
//                               array('user_payment', 'users.username', 'user_payment.username')
//                              )
      
      
//  );
      
//      echo $this->db->getTotal("users");
//      
//      echo $this->db->truncate('user_files');
//
//      $data = ['profile_img', 'pngzzzzzzz'];
//      $this->db->save('user_files', $data);
//      $options['group_by'] = array('username', 'profile_img');
      
//      
//      $options['select'] = array("username","password");
      
//      
//      $options['order_by'] = array(array("users.username",'users.email'), 'DESC');

      
//      $r = $this->db->fetch("users", $options );
//      pre($r);
//      
//      echo $this->db->rowCount();
      
      // languge
      
      $this->Lang->load('page/home'); 
      
      $this->data['lang_code'] = $this->Lang->get('code');
      
      
      // Modal
      
      $this->Loder->model('page/home');    
      $this->data['langs'] = $this->model_page_home->getLanguage();
       
      
      
     // setting
      
//     echo $this->Settings->get('ads');
      
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