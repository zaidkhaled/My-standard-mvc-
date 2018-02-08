<?php

class PagePostController extends Controller
{
    private $error = array();
    
    public function index()
    { 
            
         $this->Loder->model('page/post');
         
         // contents

         $this->data['add_post'] = $this->Url->link('page/post/insert');
         $this->data['goto'] = $this->Url->link('page/post/update', 'post_id=');
        
         

        
//         pre($this->model_page_post->getPosts());
        
        
         if(isset($this->Session->data['success']))
         {
             $this->data['success'] = $this->Session->data['success'];
             
             unset($this->Session->data['success']);
         }
         else
         {
              $this->data['success'] = null;
         }


         $this->childern = array(
              "commen/header",
              "commen/footer"
          );

         // template

         $template = '/template/page/post.php';

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

    
        public function insert()
        {
            $this->Lang->load('page/post');
            $this->Loder->model('page/post');
            $this->Document->setTitle($this->Lang->get("insert_title"));


            if($this->Request->server['REQUEST_METHOD'] == 'POST' && $this->validateForm())
            {
                 $insert = $this->model_page_post->AddNewPost($this->Request->post);

                 if ($insert)
                 {
                     $this->Session->data['success']    = $this->Lang->get('insert_success');
                     $this->redirect($this->Url->link('page/post'));
                 }
                 else
                 {
                     echo "no no no ";
                 }
                
            }else{
                pre($this->error);
                echo "no request";
            }
            $this->getForm();
        }

    
    
    
        public function update()
        {
            $this->Lang->load('page/post');
            $this->Loder->model('page/post');
            $this->Document->setTitle($this->Lang->get("edit_title"));
 
            $this->data['post_info'] = $this->model_page_post->getPostById($this->Request->get['post_id']);
            
            if($this->Request->server['REQUEST_METHOD'] == 'POST' && $this->validateForm())
            {
                 $insert = $this->model_page_post->AddNewPost($this->Request->post);

                 if ($insert)
                 {
                     $this->Session->data['success']    = $this->Lang->get('insert_success');
                     $this->redirect($this->Url->link('page/post'));
                 }
                
            }
            $this->getForm();
        }

    
    
    
        private function getForm()  
        {

            // contents

            if(isset($this->Request->get['post_id']))
            {
                $this->data['action'] = $this->Url->link('page/post', 'post_id=' . $this->Request->get['post_id']); 
                
                $this->data['heading'] = $this->Lang->get('update_heading');
            }
            else
            {
                
                $this->data['post_info'] = null;
                    
                $this->data['action'] = $this->Url->link('page/post'); 
                
                $this->data['heading'] = $this->Lang->get('insert_heading');
            }
            
            $this->data['categories'] = $this->model_page_post->getCategories();    
            $this->data['langs'] = $this->Settings->get('langs');   

            $this->data['error_title'] = isset($this->error['error_title']) ? $this->error['error_title'] : null;
            $this->data['error_content'] = isset($this->error['error_content']) ? $this->error['error_content'] : null;


            $this->childern = array(
                  "commen/header",
                  "commen/footer"
            );

            // template

            $template = '/template/page/post-form.php';

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



        private function validateForm()
        {
            
            if(!empty($this->Request->files['file']))
            {
                $this->Upload->check_file($this->Request->files['file']);
                $upload_error = $this->upload->hasError();
            }
            
            
            foreach($this->Request->post['post_details'] as $lang_id => $data) 
            {
                if (empty($data['title']))
                {
                    $this->error['error_title'][$lang_id] = 'empty field';
                }
                if (empty($data['content']))
                {
                    $this->error['error_content'][$lang_id] = 'empty content field';
                }
            }

            return !$this->error ? true : false;
        }
}