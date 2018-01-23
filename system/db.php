<?php


class DB
{
    public  $db;
    public  $where;
    public  $where_value;
    public  $rows;
    private $clear;
    private $tbname;
    private $result;
    private $sql;
    private $query;
    
    
    public function __construct($server_name, $db_name, $db_user, $db_pass)
    {
        try
        {
            
            $this->db = new PDO('mysql:host='.$server_name. ';dbname'.$db_name, $db_user, $db_pass);
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            $this->db->exec('SET NAMES utf8');
        }
        catch(PDOException $e)
        {
            die($e->getMessage());
        }
    }
    
    public function fetch($tbname, $where, $where_value)
    {
        $this->tbname = string($tbname);
        $this->where = string($where);
        $this->where_value = $where_value;
        $this->sql = 'SELECT * FROM aws.' . DB_PREFIX . $this->tbname . ' WHERE ' . $this->where . '=:' . $this->where;
       
        $this->query = $this ->db->prepare($this->sql);
        $this->bind($this->where, $this->where_value); 
        $this->query->execute();

        $this->rows = $this->query->rowCount();
        
        if($this->rows == 1)
        {
            $this->results = $this->query->fetch();
           
        }
         return $this->results;
        
        
    }
    
    public function bind($placeholder, $value, $clear_type = 'integer', $bind_type = 'bindValue')
    {
        return $this->query->$bind_type(':' . $placeholder , $clear_type($value), PDO::PARAM_STR);
    }
    
    public function query($sql)
    {
        return $this->db->prepare($sql);
    }
    
    public function __destruct()
    {
        $this->db = NULL;
    }
}