<?php

class AuditTrail {
    private $_db;

    public function __construct(Db $db) {
        $this->_db = $db;
    }

    public function log($userId, $action, $tableName, $recordId, $details) {
        // Log the action to the database
        $data = array(
            'user_id' => $userId,
            'action' => $action,
            'table_name' => $tableName,
            'record_id' => $recordId,
            'details' => $details,
            'timestamp' => date('Y-m-d H:i:s')
        );

        $result = $this->_db->insertData('audit_log', $data);

        // Optionally, you can handle the result here (e.g., check if the log was successfully inserted)
        return $result;
    }
}


?>

