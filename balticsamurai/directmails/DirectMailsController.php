<?php

class DirectMailsController
{

    /**
     * Create a new controller instance.
     * @return void
     */
    public function __construct()
    {
        $db = new DatabaseConnection;
        $this->conn = $db->conn;
    }

    /**
     * Store the contact in the database
     * @param  array $inputData
     */
    public function create($inputData)
    {
        $name = $inputData['name'];
        $email = $inputData['email'];
        $date = $inputData['date'];

        $disputeQuery = "INSERT INTO directmails (name, email, date) VALUES ('$name','$email', '$date')";
        $result = $this->conn->query($disputeQuery);
        if($result){
            return true;
        }else{
            return false;
        }
    }

    /**
     * All Contacts
     * @return array
     */
    public function getAll()
    {
        $disputeQuery = "SELECT * FROM directmails";
        $result = $this->conn->query($disputeQuery);
        if($result){
            return $result;
        }else{
            return false;
        }
    }

    /**
     * Destroy the contact
     * @param  int $id
     */
    public function destroy($id)
    {
        $disputeQuery = "DELETE FROM directmails WHERE id = $id";
        $result = $this->conn->query($disputeQuery);
        if($result){
            return true;
        }else{
            return false;
        }
    }

    /**
     * Update the contact
     * @param  int $id
     */
    public function update($inputData)
    {
        $id = $inputData['directmail_id'];
        $reason = $inputData['reason'];

        $disputeQuery = "UPDATE directmails SET reason = '$reason' WHERE id = $id";
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
    public function get_disputed($id)
    {
        // check if the contact has reason
        $disputeQuery = "SELECT * FROM directmails WHERE id = $id";
        $result = $this->conn->query($disputeQuery);
        if($result){
            $row = $result->fetch_assoc();
            if($row['reason'] == '')
            {
                return false;
            }else{
                return true;
            }
        }else{
            return false;
        }
        
    }

}