<?php
/**
 * Created by IntelliJ IDEA.
 * User: game_
 * Date: 09/04/2018
 * Time: 20:58
 */
session_start();
require ('dbconnect.php');
header("Content-Type: application/json; charset=UTF-8");
$json = Array();
$prize = null;
$prizeQR = null;
$username = $_SESSION['username'];
if($_SERVER['REQUEST_METHOD'] === 'GET'){
    if(isset($_GET['prize'])){
        $prize = $_GET['prize'];
    }
    else {
        echo json_encode(Array('msg'=>'Bad request - invalid prize'));
        die();
    }
}

$prizesql = ("SELECT id FROM MappyPrizes WHERE PrizeName = '$prize'");
$prizeResult = mysqli_query($conn, $prizesql) or die(mysqli_error($conn));
$row = mysqli_fetch_assoc($prizeResult);
$prizeResult = $row['id'];

$ptusql = ("INSERT INTO `PrizesToUsers` (`UserID`, `PrizeID`) VALUES ('$username', '$prizeResult')");
mysqli_query($conn, $ptusql) or die(mysqli_error($conn));

$prizeQRsql = ("SELECT QR FROM MappyPrizes WHERE PrizeName = '$prize'");
$prizeQR = mysqli_query($conn, $prizeQRsql);
$row = mysqli_fetch_assoc($prizeQR);
$prizeQR = bin2hex($row['QR']);

$conn->close();

$json['prize'] = $prize;
$json['prizeQR'] = $prizeQR;
echo json_encode($json);

