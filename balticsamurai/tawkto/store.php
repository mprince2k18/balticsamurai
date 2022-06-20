<?php

session_start();
require '../db.php';
include('TawktoController.php');

$db = new DatabaseConnection;

$inputData = [
    'name' => mysqli_real_escape_string($db->conn, $_POST['name']),
    'email' => mysqli_real_escape_string($db->conn, $_POST['email']),
    'country' => mysqli_real_escape_string($db->conn, $_POST['country']),
    'city' => mysqli_real_escape_string($db->conn, $_POST['city']),
];

$dispute = new TawktoController;
$result = $dispute->create($inputData);

if($result)
{
    $_SESSION['message'] = "Contact Saved Successfully";
    header("Location: index.php");
    exit(0);
}
else
{
    $_SESSION['message'] = "Not Inserted";
    header("Location: index.php");
    exit(0);
}
