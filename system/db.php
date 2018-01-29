<?php


class DB
{
    private  $db;
    private  $where;
    private  $where_value;
    private  $rows;
    private $clear;
    private $tbname;
    private $result;
    private $sql;
    private $query;
    private $last_insert_id;
    private $binded = array();
    private $join = FALSE;
    
    
    
    
    public function __construct($server_name, $db_name, $db_user, $db_pass)
    {
        try
        {
            $this->db = new PDO('mysql:host='.$server_name. ';dbname='. $db_name, $db_user, $db_pass);
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            $this->db->exec('SET NAMES utf8');
        }
        catch(PDOException $e)
        {
            die($e->getMessage());
        }
    }
    

    
    
    
    // SAVE
    
    public function save($tbname, $data, $type = 'insert', $where = FALSE)
    {
        // ex : save('users', '$data');
        
        $this->tbname = string(DB_PREFIX . $tbname);
        
        $this->sql = ($type == 'update') ? 'UPDATE ' : 'INSERT INTO ';
        
        $this->sql .= $this->tbname;
        
        $this->sql .= " SET ";
        
        $this->data = $data;
        
        $binded = array();
        
        if(is_array($this->data[0]))
        {
            foreach($this->data as $data)
            {
                // ex : $data = array(array("username", 'admin'),
                //                    array("email", 'admin@gmail.com'),
                //                    array("password", 'ad1234')
                //                   )
                
    
                
                $key = string($data[0]);

                $filter = (isset($data[2]) ? string($data[2]) : 'string');

                $value = $filter($data[1]);

                $this->sql .= " " . $key . " =:" . $key . " ,";

                $binded[$key] = $filter($value);
            }
            $this->sql = rtrim($this->sql, ",");
        }
        else
        {            
            $key = string($this-> data[0]);
            
            $filter = (isset($this->data[2]) ? string($this->data[2]) : 'string');
            
            $value = $filter($this->data[1]);
            
            $this->sql .= $key . " =:" . $key . " ,";
            
            $binded[$key] = $filter($value);
            
            $this->sql = rtrim($this->sql, ",");
        }
        
        if ($where)
        {
            $this->sql .= " WHERE " ;
            
            if(is_array($where[0]))
            {
                $this->where = $where;
                
                foreach($this->where as $where)
                {
                    $key = string($where[0]);
                    $where_key = "where_" . string($where[0]);
                    $where_value = $where[1];
                    $where_filter = isset($where[2]) ? string($where[2]) :  'integer';
                    $condition = isset($where[3]) ? string($where[3]) : ' = ';
                    $connector = isset($where[4]) ? string($where[4]) : ' AND ';
                    $binded[$where_key] = $where_filter($where_value);
                    $this->sql .= ' ' . $key . $condition . ":" . $where_key. "" . $connector;
                }
                $this->sql = rtrim($this->sql, $connector);
            }
            else
            {
                $key = string($where[0]);
                $where_key = "where_" . string($where[0]);
                $where_value = $where[1];
                $where_filter = isset($where[2]) ? string($where[2]) :  'integer';
                $condition = isset($where[3]) ? string($where[3]) : ' = ';
                $binded[$where_key] = $where_filter($where_value);
                $this->sql .= ' ' . $key . $condition . ":" . $where_key;
            }
            
        }
        
        $this->query = $this->query($this->sql);
        
        foreach($binded as $key => $value)
        {
            $this->bind($key, $value);
        } 

        if ($type == 'update' && !$where){
            
            die('there is no WHERE VALUE 2');
                
        }
        try
        {
            $this->query->execute();
        }
        catch (PDOExpection $e)
        {
            die($e->getMessage);
        }
            
        
        
        if ($type == 'insert')
        {

            $this->last_insert_id = $this->db->lastInsertId();

        }
    }
    
    
    
    
    
    
    // LAST ID
    
    
    public function lastInsertId()
    {
        return $this->last_insert_id;
    }
    
    
    
    
    
    // delete 
    
    
    public function delete($tbname, $where = FALSE, $where_value = FALSE, $filter = 'integer', $condition = " = ", $operator = " AND ")
    {
        $this->sql = 'DELETE ';
        
        if(is_array($tbname))
        {
            array_walk($tbname, "add_db_prefix");
            $this->sql .= implode(',', $tbname);
            $this->sql .= ' FROM ';
            $this->sql .= implode(',', $tbname);
        }
        else
        {
            $this ->tbname ="aws." . string(DB_PREFIX.$tbname);
            $this->sql .= " FROM " . $this->tbname;
        }
        
        if($where && $where_value)
        {
            $column = string($where);
            
            $this->sql .= " WHERE ";
            
            $value = $where_value;
            
            if(is_array($tbname))
            {
                foreach($tbname as $table)
                {
                    $this->sql .= $table. '.' . $column . $condition . ' :' . $column . ' ' . $operator;
                }
                $this->sql = rtrim($this->sql, $operator);
            }
            else
            {
                $this->sql .=  $column . $condition . " :" .  $column;
            }
            
        }
        
        $this->query = $this->query($this->sql);
        
        if($where && $where_value)
        {
            $this->bind($column, $value, $filter);
        }
        
        try 
        {
           return $this->query->execute();
        }
        catch (PDOException $e) 
        {
            die('Error : ' . $e->getMessage());
        }
        

    }
    
    
    
    
    
    
    // fetch
    
    
    public function fetch($tbname, $options = array(), $fetch = 'fetchAll')
    {
        $this->tbname = string(DB_PREFIX. $tbname);
        
        //select
        
        $this->sql = "SELECT ";
        
        if(isset($options['join']))
        {
            $this->join = $this->join($options['join']);
        }
        
        
        if(isset($options['select']))
        {
            $this->sql .= $this->select($options['select']);
        }
        else
        {
            $this->sql .= " * ";
        }
        
        $this->sql .= " FROM " . $this->tbname;
        
        $this->sql .= isset($options['join']) ? $this->join :FALSE ;
        
        // where
        
        $this->sql .= isset($options['where']) ? ' WHERE ' . $this->where($options['where']) : FALSE;
        
        $this->sql .= isset($options['group_by']) ? ' GROUP BY ' . $this->group_by($options['group_by']) : FALSE;
        
        $this->sql .= isset($options['order_by']) ? ' ORDER BY ' . $this->order_by($options['order_by']) : FALSE;
        
        $this->sql .= isset($options['limit']) ? ' LIMIT ' . $this->limit($options['limit']) : FALSE;        
        
//        echo $this->sql ."<br>";
        
        $this->query = $this->query($this->sql);
        
        foreach($this->binded as $key => $value)
        {
            $this->bind($key, $value);
        }
        
        
        try
        {
            $this->query->execute();
            

            $this->rows = $this->query->rowCount();
        }
        catch(PDOExeption $e)
        {
            die( "error : " . $e->getMessage());
        }
      
        
        $this->result = $this->query->$fetch();
        
        return $this->result;
    }
    
    // select
    
    private function select($select)
    {

        if (is_array($select))
        {
            // ex : $options['select'] = array("username","password"); OR $options['select'] = "username";

            // rst: SELECT username,password OR SELECT username;

            array_walk($select, 'add_db_prefix');
            $sql = string(implode(',', $select));
        }
        else
        {
            // ex : $options['select'] = array("username","password");

            // rst: SELECT username,password

            $sql = DBPREFIX . string($select);
        }

        return $sql;

    }
    
    
    
    
    
    
    // where 
    
    private function where($where)
    {
        if(is_array($where[0]))
        {
            // example :  $options['where'] = array(array('users.username', "zaid123123", "string", "=", "OR"),
            //                                      array('users.username', "hassen_mnmnnm")
            //                                      );
            
            // result : WHERE aws_users.username= :938152003 OR aws_users.username= :202453224
            
            $multi_where = $where;
            
            $sql = '';
            
            foreach($multi_where as $where)
            {
                    
                $key = DB_PREFIX . string($where[0]);
                
                $key2 =  rand();
                
                $value = $where[1];
                
                $filter = isset($where[2]) ? string($where[2]) : "integer";
                
                $condition = isset($where[3]) ? ($where[3]) : "=";
                
                $operator = (isset($where[4]) ? string($where[4]) : "AND") . " ";
           
                $sql .= $key . $condition . " :" . $key2 . " ". $operator ;
                
                $this->binded[$key2] = $filter($value); 
            }
            
            $sql = rtrim($sql, $operator);
        }
        else
        {
            // example : $options['where'] = array('users.email', "hassen_mnmnnm", 'string');
            
            // result : WHERE aws_users.email= :97957213
            
            $key = DB_PREFIX . string($where[0]);
            
            $key2 =  rand();
            
            $value = $where[1];
            
            $filter = isset($where[2]) ? string($where[2]) : "integer";
            
            $condition = isset($where[3]) ? string($where[3]) : "=";
            
            $sql = $key . $condition . " :" . $key2;
            
            $this->binded[$key2] = $filter($value);
            pre($this->binded);
        }
        
        return $sql;
        
    }
    
    
    
    
    
    // limit
    
    private function limit($limit)
    {
        if(is_array($limit))
        {
            // ex : $options['limit'] = array(4,6);  
            
            // rst :  LIMIT 4,6
            
            array_walk($limit, function(&$value) {$value = integer($value);});
            $limit = implode(',', $limit);
        }
        else
        {
            // ex : $options['limit'] = 4;  
            
            // rst :  LIMIT 4
      
            $limit = integer($limit);
        }
        
        return $limit;
    }
    
    
    
    
    
    
    // order by
    
    private function order_by($order_by)
    {
        if(is_array($order_by))
        {
            // ex : $options['order_by'] = array(array("users.username",'users.email'), 'DESC');
            
            // rst: ORDER BY aws_users.username, aws_users.email DESC
            
            if(is_array($order_by[0]))
            {
                if($this->join)
                {
                    array_walk($order_by[0], 'add_db_prefix');
                }
                $sql = string(implode(',', $order_by[0]));
            }
            else
            {
                $sql = string($order_by[0]);
            }
            
            if(isset($order_by[1]))
            {
                $sql .= ' ' . string($order_by[1]);  
            }
        }
        else
        {
            // ex : $options['order_by'] = "users.username";
            
            // rst: ORDER BY aws_users.email
            
            $sql = $this->join ? string(DB_PREFIX . $order_by)  : string($order_by);
        }
        
        return $sql;
    }
    
    
    
    // gruped by
    
    private function group_by($group_by)
    {
        if(is_array($group_by))
        {
            // ex : $options['group_by'] = array('username', 'profile_img');
            
            // rst: GROUP BY username,profile_img 
            
            $sql = string(implode(',', $group_by));
        }
        else
        {
            // ex : $options['group_by'] = "username";
            
            // rst: GROUP BY username
            
            $sql = string($group_by);
        }
        
        return $sql;
    }
    
    
    
    
    
    // Join
    
    // Hinweis : make left join with two column in same table still not allwoed
    
    public function join($join)
    {
        if(is_array($join[0]))
        {
            // example : $options['join'] = $options['join'] = array(
            //                                           array('user_files', 'users.user_id', 'user_files.user_id'),
            //                                           array('user_payment', 'users.username', 'user_payment.username')
            //                    );
            // result : LEFT JOIN aws_user_files ON aws_users.user_id = aws_user_files.user_id LEFT JOIN aws_user_payment ON aws_users.username = aws_user_payment.username 
             
            $joins = $join;
            
            $sql = '';
            
            foreach ($joins as $join)
            {
                $joined_table = string(DB_PREFIX. $join[0]);

                $main_table_column = string(DB_PREFIX . $join[1]);

                $joined_table_column = string(DB_PREFIX . $join[2]);

                $join_type = isset($join[3]) ? string($join[3]) : 'LEFT JOIN';

                $sql .= " " . $join_type . " " . $joined_table . ' ON ' . $main_table_column . ' = ' . $joined_table_column. " ";    
                
            }
            
        }
        else
        {
            // example : $options['join'] = array('user_files', 'users.user_id', 'user_files.user_id');
            
            // result : aws_users LEFT JOIN aws_user_files ON aws_users.user_id = aws_user_files.user_id
            
            $joined_table = string(DB_PREFIX. $join[0]);
            
            $main_table_column = string(DB_PREFIX . $join[1]);
            
            $joined_table_column = string(DB_PREFIX . $join[2]);
            
            $join_type = isset($join[3]) ? string($join[3]) : 'LEFT JOIN';
            
            $sql = " " . $join_type . " " . $joined_table . ' ON ' . $main_table_column . ' = ' . $joined_table_column. " ";
        }
        return $sql;
    }
    
    
    
    
    
    //bind
    
    public function bind($placeholder, $value, $clear_type = 'integer', $bind_type = 'bindValue')
    {
        return $this->query->$bind_type(':' . $placeholder , $value, PDO::PARAM_STR);
    }
    
    
    // get effected rows 
    
    public function rowCount()
    {
        return $this->rows;
    }
    
    
    // get total columns
    
    public function getTotal($table)
    {
        $this->tbname = DB_PREFIX . string($table);
        
        $this->sql = 'SELECT COUNT(*) FROM  ' . $this->tbname;
        
        $this->query = $this->query($this->sql);
        
        $this->query->execute();
        
        return $this->query->fetchColumn();

    }
    
    
    // truncate
    
    public function truncate($table)
    {
        $this->tbname = DB_PREFIX . string($table);
        
        $this->sql = 'TRUNCATE ' . $this->tbname;
        
        $this->query = $this->query($this->sql);
        
        try
        {
            $this->query->execute();
        }
        catch (PDOExeption $e)
        {
            die($e->getMessage());
        }
    }
    
    
    // query
    
    public function query($sql)
    {
        return $this->db->prepare($sql);
    }
    
    
    
    
    public function __destruct()
    {
        $this->db = NULL;
    }
}