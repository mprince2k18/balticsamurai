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
    $_SESSION['message'] = "Here is the search result:";
    $_SESSION['values'] = $result;
    $_SESSION['date'] = $inputData['date'];
    $_SESSION['source'] = $inputData['source'];
    header("Location: result.php");
    exit(0);
}
else
{
    $_SESSION['message'] = "Something went wrong";
    header("Location: result.php");
    exit(0);
}
