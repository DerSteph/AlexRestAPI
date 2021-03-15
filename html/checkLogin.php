<?php
error_reporting(E_ALL);
require('../database.php');
$pdo = buildPdo();

$name = $_GET['name'];
$password = $_GET['password'];

$query1 = $pdo->prepare("SELECT password FROM amt WHERE name=?");
if($query1->execute(array($name)))
{
    $query_password = "";
    while($row = $query1->fetch())
    {
        $query_password = $row['password'];
    }
    
    if ($query_password == $password) {
        $output = array();
    
        $output["status"] = "ok";
        $output["message"] = "login";
        header('Content-Type: application/json');
        echo json_encode($output);
    }
    else
    {
        $output["status"] = "error";
        $output["message"] = "wrong name / wrong password";
        header('Content-Type: application/json');
        echo json_encode($output);
    }
}
else
{
    $output["status"] = "error";
    $output["message"] = "sql fail";
    header('Content-Type: application/json');
    echo json_encode($output);
}

?>