<?php

class DisputeController
{
    public function __construct()
    {
        $db = new DatabaseConnection;
        $this->conn = $db->conn;
    }

    public function create($inputData)
    {
        $caller_sid = $inputData['caller_sid'];
        $reason = $inputData['reason'];

        $disputeQuery = "INSERT INTO disputes (caller_sid,reason,created_at,updated_at) VALUES ('$caller_sid','$reason', null, null)";
        $result = $this->conn->query($disputeQuery);
        if($result){
            return true;
        }else{
            return false;
        }
    }

    /**
     * get_disputed
     */
    public function get_disputed($caller_sid)
    {
        $disputeQuery = "SELECT * FROM disputes WHERE caller_sid = '$caller_sid'";
        $result = $this->conn->query($disputeQuery);
        if($result->num_rows > 0){
            return $result;
        }else{
            return false;
        }
    }

    /**
     * Disputed value
     */
    public function get_disputed_value($caller_sid)
    {
        $disputeQuery = "SELECT * FROM disputes WHERE caller_sid = '$caller_sid'";
        $result = $this->conn->query($disputeQuery);
        if($result->num_rows > 0){
            $row = $result->fetch_assoc();
            return $row['reason'];
        }else{
            return false;
        }
    }
}
