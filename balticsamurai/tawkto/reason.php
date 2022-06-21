<?php

session_start();
require '../db.php';
include('TawktoController.php');

$db = new DatabaseConnection;

$inputData = [
    'tawkto_id' => mysqli_real_escape_string($db->conn, $_POST['tawkto_id']),
    'reason' => mysqli_real_escape_string($db->conn, $_POST['reason'])
];

$dispute = new TawktoController;
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
