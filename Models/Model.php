<?php
class Model {
    
    private $_connection = false;
    
    private $_host = "localhost";
    private $_username = "root";
    private $_password = "";
    private $_database = "slim_db";
    
    private function connect() {
         $this->_connection = mysql_connect($this->_host, $this->_username, $this->_password);
         mysql_select_db($this->_database, $this->_connection);
    }
 
    public function fetchOne($query) {
        $result = $this->query($query);
        $result = mysql_fetch_assoc($result);
        return $result;
    }
        
    public function fetchAll($query) {
        $result = $this->query($query);

        $records = array();
        while($row = mysql_fetch_assoc($result)){
             $records[] = $row;
        }
        return $records;
    }
    
    public function query($query) {
       if(!$this->_connection) {
            $this->connect();
       }
       
       $result = mysql_query($query);
       return $result ;
    }
}