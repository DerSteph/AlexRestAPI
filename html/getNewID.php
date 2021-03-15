<?php
require('../database.php');
$pdo = buildPdo();

// get if user or event
$gettype = $_GET['type'];
if($gettype == "user")
{
    $query = $pdo->prepare("SELECT counter FROM counters WHERE num = 0");
    if($query->execute()) {
        $getCount = 0;
    
        while($row = $query->fetch()) {
            $getCount = $row['counter'];
        }
        $getCount++;
    
        $query2 = $pdo->prepare("UPDATE counters SET counter = ? WHERE num = 0");
        if($query2->execute(array($getCount)))
        {
            $output = array();
            $output["status"] = "ok";
            $output["personID"] = $getCount;
            
            header('Content-Type: application/json');
            echo json_encode($output);
        }
    }
    else
    {
        $output = array();
        $output["status"] = "error";
        header('Content-Type: application/json');
        echo json_encode($output);
    }
}
else if($gettype == "event")
{
    $query = $pdo->prepare("SELECT counter FROM counters WHERE num = 1");
    if($query->execute()) {
        $getCount = 0;
    
        while($row = $query->fetch()) {
            $getCount = $row['counter'];
        }
        $getCount++;
    
        $query2 = $pdo->prepare("UPDATE counters SET counter = ? WHERE num = 1");
        if($query2->execute(array($getCount)))
        {
            $output = array();
            $output["status"] = "ok";
            $output["eventID"] = $getCount;
            
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
    }
    else
    {
        $output = array();
        $output["status"] = "error";
        $output["message"] = "sql fail";
        header('Content-Type: application/json');
        echo json_encode($output);
    }
}
else
{
    $output = array();
    $output["status"] = "error";
    $output["message"] = "wrong type selection";
    header('Content-Type: application/json');
    echo json_encode($output);
}

?>