<?php


class CommenFooterController extends Controller
{
    public function index()
    {
        $template = '/template/commen/footer.php';
        
        
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
