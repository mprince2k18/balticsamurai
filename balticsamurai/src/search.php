<?php

session_start();
require '../db.php';
include('Controller.php');

$db = new DatabaseConnection;

$inputData = [
    'date' => $_GET['date'],
    'source' => $_GET['source'],
];

$dispute = new Controller;
$result = $dispute->search($inputData);

if($result)
{
    $_SESSION['message'] = "Contact Saved Successfully";
    $_SESSION['values'] = $result;
    header("Location: result.php");
    exit(0);
}
else
{
    $_SESSION['message'] = "Something went wrong";
    header("Location: result.php");
    exit(0);
}
