<?php

class GoogleBusniessController
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
        $phone = $inputData['phone'];
        $date = $inputData['date'];

        $disputeQuery = "INSERT INTO google_business (name, email, date, phone) VALUES ('$name','$email', '$date', '$phone')";
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
        $disputeQuery = "SELECT * FROM google_business";
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
        $disputeQuery = "DELETE FROM google_business WHERE id = $id";
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
        $id = $inputData['google_business_id'];
        $reason = $inputData['reason'];

        $disputeQuery = "UPDATE google_business SET reason = '$reason' WHERE id = $id";
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
        $disputeQuery = "SELECT * FROM google_business WHERE id = $id";
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