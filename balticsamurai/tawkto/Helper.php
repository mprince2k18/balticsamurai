<?php

require '../db.php';
include('TawktoController.php');

class Tawkto 
{
    /**
     * Get all the contacts getAll()
     */
    public function allContacts()
    {
        $contacts = new TawktoController;
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
        $contacts = new TawktoController;
        $result = $contacts->destroy($id);

        if($result)
        {
            $_SESSION['message'] = "Contact Destroyed Successfully";
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
        $dispute = new TawktoController;
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