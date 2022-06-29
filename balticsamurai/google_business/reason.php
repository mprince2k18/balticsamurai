<?php

session_start();
require '../db.php';
include('GoogleBusniessController.php');

$db = new DatabaseConnection;

$inputData = [
    'google_business_id' => mysqli_real_escape_string($db->conn, $_POST['google_business_id']),
    'reason' => mysqli_real_escape_string($db->conn, $_POST['reason'])
];

$dispute = new GoogleBusniessController;
$result = $dispute->update($inputData);

if($result)
{
    $_SESSION['message'] = "Disputed Successfully";
    header("Location: index.php");
    exit(0);
}
else
{
    $_SESSION['message'] = "Not Updated";
    header("Location: index.php");
    exit(0);
}
