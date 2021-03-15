<?php
require('../database.php');
$pdo = buildPdo();
/*
* get files as "0": {"eventid":"id", "timestamp":"timestamp"}
*/
$json = file_get_contents("php://input");
$data = json_decode($json, true);
$fail = false;
if($data == "")
{
    $output["status"] = "error";
    $output["message"] = "no data";
    header('Content-Type: application/json');
    echo json_encode($output);
}
else
{
// $data[0]["eventid"] = "id"
for($i = 0; $i < count($data); $i++)
{
    $query = $pdo->prepare("INSERT IGNORE INTO events SET eventID = ?, Timestamp = ?");
    if($query->execute(array($data[$i]["eventid"], $data[$i]["timestamp"])))
    {

    }
    else
    {
        $fail = true;
    }
}
if($fail == false)
{
    $output["status"] = "ok";
    $output["message"] = "events inserted";
    header('Content-Type: application/json');
    echo json_encode($output);
}
else
{
    $output["status"] = "error";
    $output["message"] = "sql error";
    header('Content-Type: application/json');
    echo json_encode($output);
}
}
?>