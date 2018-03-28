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
$prizeStatus = array();
$prizes = array();
$combinedPrizes = array();

if(isset($_SESSION['username'])){
    $username = $_SESSION['username'];

    $pointsql = "SELECT `UserXP` FROM `MappyUsers` WHERE `UserID` = '$username'";
    $points = mysqli_query($conn, $pointsql);

    $sql = "SELECT * FROM `PrizesToUsers` WHERE `UserID` = '$username'";
    $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
    while (($row = mysqli_fetch_assoc($result))){
        array_push($prizeStatus, $row['PrizeOne']);
        array_push($prizeStatus, $row['PrizeTwo']);
        array_push($prizeStatus, $row['PrizeThree']);
        array_push($prizeStatus, $row['PrizeFour']);
        array_push($prizeStatus, $row['PrizeFive']);
        array_push($prizeStatus, $row['PrizeSix']);
    }

    $pdsql = "SELECT `PrizeName``PointsRequired``PrizePic` FROM `MappyPrizes`";
    $result = mysqli_query($conn, $pdsql) or die(mysqli_error($conn));
    while(($pdrow = mysqli_fetch_assoc($result))){
        array_push($prizes, $pdrow);
    }

    $json = Array();
    $combinedPrizes = array_combine($prizes, $prizeStatus);
    $json['prizeArray'] = json_encode((array)$combinedPrizes);
    $json['userPoints'] = json_encode($points);
    $json['msg'] = json_encode("could not load prize array or user points");

}