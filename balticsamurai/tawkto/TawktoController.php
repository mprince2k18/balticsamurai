<?php

class TawktoController
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
        $country = $inputData['country'];
        $city = $inputData['city'];

        $disputeQuery = "INSERT INTO tawkto_contacts (name,email,country,city) VALUES ('$name','$email', '$country', '$city')";
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
        $disputeQuery = "SELECT * FROM tawkto_contacts";
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
        $disputeQuery = "DELETE FROM tawkto_contacts WHERE id = $id";
        $result = $this->conn->query($disputeQuery);
        if($result){
            return true;
        }else{
            return false;
        }
    }

}