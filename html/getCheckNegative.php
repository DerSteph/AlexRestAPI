<?php
error_reporting(E_ALL);
require('../database.php');
$pdo = buildPdo();

$id = $_GET['personid'];

$timestamp = date("Y-m-d", strtotime('-2 days', time()));

$query = $pdo->prepare("SELECT personID FROM negative WHERE personID = ? AND Timestamp > ?");
if($query->execute(array($id, $timestamp)))
{
    $output = array();

    while($row = $query->fetch())
    {
        $negativetest = $row['personID'];
    }
    if($negativetest == "" OR $negativetest == null)
    {
        $output["status"] = "ok";
        $output["message"] = "false";
    }
    else
    {
        $output["status"] = "ok";
        $output["message"] = "true";
    }
    header('Content-Type: application/json');
    echo json_encode($output);
}
else
{
    $output = array();

    $output["status"] = "error";
    $output["message"] = "sql fail";
    header('Content-Type: application/json');
    echo json_encode($output);
}

?>