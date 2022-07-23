<?php

require '../db.php';
include('Controller.php');

class Information
{
    /**
     * Get all the contacts getAll()
     */
    public function allContacts()
    {
        $contacts = new Controller;
        $result = $contacts->getAll();

        if($result){
            return $result;
        }else{
            return false;
        }
    }

    /**
     * Destroy a contact
     */
    public function destroy($id)
    {
        $contacts = new Controller;
        $result = $contacts->destroy($id);

        if($result)
        {
            $_SESSION['message'] = "Destroyed Successfully";
            header("Location: index.php");
            exit(0);
        }
        else
        {
            $_SESSION['message'] = "Something went wrong";
            header("Location: index.php");
            exit(0);
        }
    }

    /**
     * Check disputed
     */

    /**
     * Check Disputed in mysql
     */

    public function check_disputed($id)
    {
        $dispute = new Controller;
        $result = $dispute->get_disputed($id);
        if($result)
        {
            return 'Disputed';
        }
        else
        {
            return 'Dispute';
        }
    }

}