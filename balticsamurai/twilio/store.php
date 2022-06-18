<?php

session_start();
include('db.php');
include('DisputeController.php');

$db = new DatabaseConnection;

if(isset($_POST['caller_sid']))
{
    $inputData = [
        'caller_sid' => mysqli_real_escape_string($db->conn, $_POST['caller_sid']),
        'reason' => mysqli_real_escape_string($db->conn, $_POST['reason']),
    ];

    $dispute = new DisputeController;
    $result = $dispute->create($inputData);
    
    if($result)
    {
        $_SESSION['message'] = "Disputed Successfully";
        header("Location: index.php");
        exit(0);
    }
    else
    {
        $_SESSION['message'] = "Not Inserted";
        header("Location: index.php");
        exit(0);
    }
}