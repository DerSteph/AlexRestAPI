<?php
require('../database.php');
$pdo = buildPdo();

$timestamp = date("Y-m-d", strtotime('-2 weeks', time()));

$query = $pdo->prepare("SELECT personID FROM positive WHERE Timestamp > ?");
$query2 = $pdo->prepare("SELECT eventID FROM events WHERE Timestamp > ?");
if($query->execute(array($timestamp)) && $query2->execute(array($timestamp)))
{
    $output["status"] = "ok";

    $personIds = array();
    $eventIds = array();
 
    $i = 0;
    while($row = $query->fetch())
    {
        $personIds[$i] = $row['personID'];
        $i++;
    }
    $i = 0;
    while($row = $query2->fetch())
    {
        $eventIds[$i] = $row['eventID'];
        $i++;
    }
    $output["personIds"] = $personIds;
    $output["eventIds"] = $eventIds;
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