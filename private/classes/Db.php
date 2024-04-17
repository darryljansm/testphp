<?php

/**
 * Database class for handling database operations.
 */
class Db {
    // Database connection instance
    private static $_instance = null;
    private $_conn,
            $_host = 'localhost',
            $_db = 'test',
            $_user = 'root',
            $_pass = '';

    /**
     * Constructor method to establish a database connection.
     */
    public function __construct() {
        try {
            $this->_conn = new PDO("mysql:host={$this->_host};dbname={$this->_db}", $this->_user, $this->_pass);
            $this->_conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            echo 'Error: '.$e->getMessage();
        }
    }

    /**
     * Get the instance of the database connection.
     */
    public static function getInstance() {
        if (!isset(self::$_instance)) {
            self::$_instance = new Db();
        }
        return self::$_instance;
    }

    /**
     * Execute a SELECT query with optional parameters.
     *
     * @param string $column The column(s) to select.
     * @param string $table The table name.
     * @param string|null $condition The WHERE condition.
     * @param array $params The parameters for the query.
     * @return array The result of the query.
     */
    public function selectData($column = '*', $table = null, $condition = null, $params = array()) {
        $sql = "SELECT {$column} FROM {$table}";
        if ($condition) {
            $sql .= " WHERE {$condition}";
        }
        try {
            $stmt = $this->_conn->prepare($sql);
            $stmt->execute($params);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $data = array('result' => 1, 'message' => $result);
            return $data;
        } catch(PDOException $e) {
            $data = array('result' => 0, 'message' => $e->getMessage());
            return $data;
        }
    }

    /**
     * Execute an INSERT query.
     *
     * @param string $table The table name.
     * @param array $data The data to insert.
     * @return array The result of the query.
     */
    public function insertData($table, $data = array()) {
        if (empty($data)) {
            $data = array('result' => 0, 'message' => 'Data was empty.');
            return $data;
        }
        $fields = implode(", ", array_keys($data));
        $placeholders = rtrim(str_repeat("?, ", count($data)), ", ");
        $values = array_values($data);
        $sql = "INSERT INTO {$table} ({$fields}) VALUES ({$placeholders})";
        try {
            $stmt = $this->_conn->prepare($sql);
            $result = $stmt->execute($values);
            $data = array('result' => 1, 'message' => $result);
            return $data;
        } catch (PDOException $e) {
            $data = array('result' => 0, 'message' => $e->getMessage());
            return $data;
        }
    }

    /**
     * Execute an UPDATE query.
     *
     * @param string $table The table name.
     * @param string $where The WHERE clause.
     * @param array $data The data to update.
     * @return array The result of the query.
     */
    public function updateData($table, $where, $data = array()) {
        if (empty($data)) {
            $data = array('result' => 0, 'message' => 'Data was empty.');
            return $data;
        }
        $setValues = array();
        foreach ($data as $field => $value) {
            $setValues[] = "{$field} = ?";
        }
        $setClause = implode(", ", $setValues);
        $sql = "UPDATE {$table} SET {$setClause} WHERE {$where}";
        try {
            $stmt = $this->_conn->prepare($sql);
            $result = $stmt->execute(array_values($data));
            $data = array('result' => 1, 'message' => $result);
            return $data;
        } catch (PDOException $e) {
            $data = array('result' => 0, 'message' => $e->getMessage());
            return $data;
        }
    }

    /**
     * Execute a DELETE query.
     *
     * @param string $table The table name.
     * @param string $where The WHERE clause.
     * @param array $params The parameters for the query.
     * @return array The result of the query.
     */
    public function deleteData($table, $where, $params = array()) {
        $sql = "DELETE FROM {$table} WHERE {$where}";
        try {
            $stmt = $this->_conn->prepare($sql);
            $stmt->execute($params);
            $rowCount = $stmt->rowCount();
            $data = array('result' => 1, 'message' => "Deleted {$rowCount} row(s)");
            return $data;
        } catch (PDOException $e) {
            $data = array('result' => 0, 'message' => $e->getMessage());
            return $data;
        }
    }

    /**
     * Get the most recent ID updated in the table based on the condition.
     *
     * @param string $table The table name.
     * @param string $where The WHERE clause.
     * @param array $params The parameters for the query.
     * @param string $idField The name of the ID field.
     * @return mixed|null The most recent ID updated, or null if not found.
     */
    public function getRecentId($table, $where, $params = array(), $idField = 'ID') {
        $sql = "SELECT {$idField} FROM {$table} WHERE {$where} ORDER BY {$idField} DESC LIMIT 1";
        try {
            $stmt = $this->_conn->prepare($sql);
            $stmt->execute($params);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result ? $result[$idField] : null;
        } catch(PDOException $e) {
            echo 'Error: '.$e->getMessage();
            return null;
        }
    }



}


?>