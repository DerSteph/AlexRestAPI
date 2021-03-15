<?php
require('../database.php');
$pdo = buildPdo();

$id = $_GET['personid'];
$date = $_GET['timestamp'];
$name = $_GET['name'];
$password = $_GET['password'];  

// algo für hash, salt, pepper

$query1 = $pdo->prepare("SELECT password FROM amt WHERE name=?");
$query1->execute(array($name));

$query_password = "";
while($row = $query1->fetch())
{
    $query_password = $row['password'];
}

if($query_password == $password)
{
    $query2 = $pdo->prepare("INSERT IGNORE INTO negative SET personID=?, Timestamp=?");
    if($query2->execute(array($id, $date)))
    {
        $output = array();

        $output["status"] = "ok";
        $output["message"] = "id inserted into negative";
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
    $output["message"] = "wrong password / wrong name";
    header('Content-Type: application/json');
    echo json_encode($output);
}

?>