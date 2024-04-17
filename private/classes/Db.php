<?php

class Db {

	private static $_instance = null;
	private $_conn,
			$_host = 'localhost',
			$_db = 'test',
			$_user = 'root',
			$_pass = '';

	public function __construct() { // PDO connection for sqlsrv database
		try {
			$this->_conn = new PDO("mysql:host=".$this->_host.";dbname=".$this->_db,$this->_user,$this->_pass);
			$this->_conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		} catch(PDOException $e) {
			echo 'Error: '.$e->getMessage();
		}
	}

    public static function getInstance() {
		if(!isset(self::$_instance)) {
			self::$_instance = new Db();
		}
		return self::$_instance;
	}

    public function selectData($column = '*', $table = null, $condition = null) {
        $sql = "SELECT $column FROM $table";
        if($condition) {
            $sql .= " WHERE $condition";
        }
        try {
            $stmt = $this->_conn->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $data = array('result' => 1, 'message' =>  $result);
            return $data;
        } catch(PDOException $e) {
            $data = array('result' => 0, 'message' => $e->getMessage());
            return $data;
        }
    }


    public function insertData($table, $data = array()) {
        if(empty($data)) {
            $data = array('result' => 0, 'message' => 'Data was empty.');
            return $data;
        }
        $fields = implode(", ", array_keys($data));
        $placeholders = rtrim(str_repeat("?, ", count($data)), ", ");
        $values = array_values($data);
        $sql = "INSERT INTO $table ($fields) VALUES ($placeholders)";
        try {
            $stmt = $this->_conn->prepare($sql);
            $result = $stmt->execute($values);
            $data = array('result' => 1, 'message' =>  $result);
            return $data;
        } catch (PDOException $e) {
            $data = array('result' => 0, 'message' => $e->getMessage());
            return $data;
        }
    }
    
    public function updateData($table, $where, $data = array()) {
        if(empty($data)) {
            $data = array('result' => 0, 'message' => 'Data was empty.');
            return $data;
        }
        $setValues = array();
        foreach ($data as $field => $value) {
            $setValues[] = "$field = ?";
        }
        $setClause = implode(", ", $setValues);
        $sql = "UPDATE $table SET $setClause WHERE $where";
        try {
            $stmt = $this->_conn->prepare($sql);
            $result = $stmt->execute(array_values($data));
            $data = array('result' => 1, 'message' =>  $result);
            return $data;
        } catch (PDOException $e) {
            $data = array('result' => 0, 'message' => $e->getMessage());
            return $data;
        }

    }

}


?>