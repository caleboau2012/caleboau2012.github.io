<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of database_handler
 *
 * @author goke_epapa
 */
//require_once 'config.php';

class databaseHandler {

    private $host;
    private $username;
    private $password;
    private $dbName;
    private $tableName;
    private $con;
    private $query;
    
    public function __construct($host, $username, $password) {
        $this->host = $host;
        $this->username = $username;
        $this->password = $password;
        $this->con = mysql_connect($this->host, $this->username, $this->password) or die("Could not connect to " + $this->hosr);
    }

    public function setTable($table_name) {
        $this->tableName = $table_name;
    }

    public function closeDb() {
        if (isset($this->con)) {
            mysql_close($this->con);
            unset($this->con);
        }
    }

    public function selectDatabase($dbName) {
        $this->dbName = $dbName;
        mysql_select_db($this->dbName, $this->con) or die("Could not select database" + $this->dbName);
    }

    public function query($query){
        $this->query = @mysql_query($query,$this->con);
    }

    public function getQueryStatus(){
        return $this->query;
    }
	
   public function getResult(){
        $result = array();
        $result = @mysql_fetch_array($this->query,MYSQL_ASSOC);
//        for($i=0; $i<@mysql_num_rows($this->query);$i++){
//			$result[$i] = @mysql_fetch_array($this->query,MYSQL_ASSOC);
//        }
        return $result;
    }
	
	public function getCon(){
		return $this->con;	
	}

}

?>
