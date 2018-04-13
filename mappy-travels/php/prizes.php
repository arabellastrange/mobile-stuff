<?php

session_start();
require ('dbconnect.php');

$json = Array();
if (isset($_SESSION['username'])){
    $username = $_SESSION['username'];
}
else {
    header("Location: ../index.html");
    die();
}
header("Content-Type: application/json; charset=UTF-8");

//PrizesToUsers
$ptuResult =  $conn->query("SELECT PrizeID FROM PrizesToUsers WHERE UserID = '$username'");
$ptuOutp = "[";
while($rs = $ptuResult->fetch_array(MYSQLI_ASSOC)){
    if ($ptuOutp != "[") {$ptuOutp .= ",";}
    $ptuOutp .= '{"PrizeID":"'.$rs["PrizeID"].'"}';
}
$ptuOutp .="]";

$json['ptu'] = $ptuOutp;

//MappyPrizes
$result = $conn->query("SELECT PrizeName, PointsRequired, id, PrizePic FROM MappyPrizes");

$outp = "[";
while($rs = $result->fetch_array(MYSQLI_ASSOC)){
    if ($outp != "[") {$outp .= ",";}
    $outp .= '{"PrizeName":"'.$rs["PrizeName"].'",';
    $outp .= '"PointsRequired":"'.$rs["PointsRequired"].'",';
    $outp .= '"id":"'.$rs["id"].'",';
    $outp .= '"PrizePic":"'.bin2hex($rs["PrizePic"]).'"}';
}
$outp .="]";

$conn->close();

$json['prizes'] = $outp;

$json['username'] = $username;

echo json_encode($json);
