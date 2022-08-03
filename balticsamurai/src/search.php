<?php

session_start();
require '../db.php';
include('Controller.php');

$db = new DatabaseConnection;

$inputData = [
    'date' => $_GET['date'],
    'end_date' => $_GET['end_date'],
    'source' => $_GET['source'],
];

$dispute = new Controller;
$result = $dispute->search($inputData);


$_SESSION['message'] = "Here is the search result:";
$_SESSION['values'] = $result;
$_SESSION['date'] = $inputData['date'];
$_SESSION['end_date'] = $inputData['end_date'];
$_SESSION['source'] = $inputData['source'];
header("Location: result.php");
exit(0);

