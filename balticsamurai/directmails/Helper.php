<?php

require '../db.php';
include('DirectMailsController.php');

class DirectMails
{
    /**
     * Get all the contacts getAll()
     */
    public function allContacts()
    {
        $contacts = new DirectMailsController;
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
        $contacts = new DirectMailsController;
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
        $dispute = new DirectMailsController;
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