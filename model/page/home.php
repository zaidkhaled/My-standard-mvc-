<?php


class PageHomeModel extends Model
{
    public function getLanguage()
    {
        $sql = 'SELECT * FROM aws.' . DB_PREFIX . 'langs WHERE status = 1';
        $query = $this->db->query($sql);
        $query->execute();
        return $query->fetchAll();
        
    }
    
}