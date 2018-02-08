<?php

class PagePostModel extends Model
{
    public function AddNewPost($grabbed_data)
    {
        $data = array(
            
            array('cat_id', $grabbed_data[cate_details][1][cate_id], 'integer'),
            array('status', 1, 'integer'),
            array('user_id', 1, 'integer'),
            array('data', date('Y-m-d H:i:s'))
            
        );
        
        $this->db->save('post', $data);
        $post_id = $this->db->lastInsertId();
        
        foreach($grabbed_data['post_details'] as $lang_id => $details)
        {
            $data = array(
                array('title', $details['title']),
                array('content', $details['content']),
                array('lang_id', $lang_id, 'integer'),
                array('post_id', $post_id, "integer") // add cat_id
                
            );
            
            $this->db->save('post_details' , $data);
        }
        
        return true;
    }
    
    
    
    public function getPosts()
    {
        $options = array(
            "join"    => array('post_details', 'post.post_id', 'post_details.post_id'),
            "where"   => array('post_details.lang_id', $this->Settings->get('set_id'), "integer")
        
        );
        
        return $this->db->fetch('post', $options);


        
    }
    
    public function getPostById($id)
    {
        $where['where'] = array("post.post_id", $id);
        
        $post_info = $this->db->fetch('post', $where, 'fetch');
        
        $where['where'] = array("post_details.post_id", $id);
        
        $results = $this->db->fetch('post_details', $where);
        
        foreach($results as $result)
        {
            $post_info['post_details'][$result['lang_id']] = array(
                
                'title'   => $result['title'],
                
                'content' => $result['content']
            
            );
        }
        
        return $post_info;
        
    }
    
    
    public function getCategories()
    {
        return $this->db->fetch('category');
    }
}