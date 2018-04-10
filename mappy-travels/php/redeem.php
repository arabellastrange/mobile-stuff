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
    if(isset($_GET['Badges'])){
        $prize = 'Badges';
    } elseif (isset($_GET['Coffee coupon'])){
        $prize = 'Coffee coupon';
    } elseif (isset($_GET['Keep cup'])){
        $prize = 'Keep cup';
    } elseif (isset($_GET['Pass case'])){
        $prize = 'Pass case';
    } elseif (isset($_GET['Book token'])){
        $prize = 'Book token';
    } elseif (isset($_GET['Water bottle'])){
        $prize = 'Water bottle';
    }
}

$prizesql = $conn->query("SELECT id FROM MappyPrizes WHERE PrizeName = '$prize'");
$prizeResult = mysqli_query($conn, $prizesql) or die(mysqli_error($conn));

$ptusql = $conn->query("INSERT INTO `PrizesToUsers` (`UserID`, `PrizeID`) VALUES ('$username', '$prizeResult')");
mysqli_query($conn, $ptusql) or die(mysqli_error($conn));

$prizeQRsql = $conn->query("SELECT QR FROM MappyPrizes WHERE PrizeName = '$prize'");
$prizeQR = mysqli_query($conn, $prizeQRsql);
$prizeQR = bin2hex($prizeQR);

$conn->close();

$json['prize'] = $prize;
$json['prizeQR'] = $prizeQR;
echo json_encode($json);

