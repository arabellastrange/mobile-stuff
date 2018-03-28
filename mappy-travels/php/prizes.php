<?php
/**
 * Created by IntelliJ IDEA.
 * User: game_
 * Date: 26/03/2018
 * Time: 11:39
 */
session_start();
require ('dbconnect.php');
header('Content-Type: application/json');
$userPrizes = array();
$prizes = array();

//if(isset($_SESSION['username'])){

    $json = Array();

    $username = "a";

    $pointsql = "SELECT `UserXP` FROM `MappyUsers` WHERE `UserID` = '$username'";
    $points = mysqli_query($conn, $pointsql);

    $sql = "SELECT `PrizeID` FROM `PrizesToUsers` WHERE `UserID` = '$username'";
    $result = mysqli_query($conn, $sql);
    if($result) {
        while (($row = mysqli_fetch_assoc($result))) {
            array_push($userPrizes, $row);
        }
        $json["userPrizes"] = (array)($userPrizes);
    }

    $pdsql = "SELECT `PrizeName`,`PointsRequired`,`PrizePic` FROM `MappyPrizes`";
    $result = mysqli_query($conn, $pdsql);
    while(($pdrow = mysqli_fetch_assoc($result))){
        array_push($prizes, $pdrow);
    }


    $json["prizes"] = (array)($prizes);
    $json['points'] = ($points);
    //$json['msg'] = ("could not load prize array or user points");
    echo json_encode($json);
//}
//else{
//   // echo json_encode(false);
//}
