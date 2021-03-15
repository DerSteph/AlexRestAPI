<?php
require('../database.php');
$pdo = buildPdo();

$timestamp = date("Y-m-d", strtotime('-2 weeks', time()));

$query = $pdo->prepare("SELECT personID FROM positive WHERE Timestamp > ?");
if($query->execute(array($timestamp)))
{
    $output = array();
    $output["status"] = "ok";

    $i = 0;
    while($row = $query->fetch())
    {
        $output["persons"][$i] = $row['personID'];
        $i++;
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