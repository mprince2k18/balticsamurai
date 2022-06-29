<?php

session_start();
require '../db.php';
include('GoogleBusniessController.php');

$db = new DatabaseConnection;

$inputData = [
    'name' => mysqli_real_escape_string($db->conn, $_POST['name']),
    'email' => mysqli_real_escape_string($db->conn, $_POST['email']),
    'phone' => mysqli_real_escape_string($db->conn, $_POST['phone']),
    'date' => mysqli_real_escape_string($db->conn, $_POST['date']),
];

$dispute = new GoogleBusniessController;
$result = $dispute->create($inputData);

if($result)
{
    $_SESSION['message'] = "Lead Saved Successfully";
    header("Location: index.php");
    exit(0);
}
else
{
    $_SESSION['message'] = "Not Inserted";
    header("Location: index.php");
    exit(0);
}
