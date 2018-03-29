<?php
/**
 * Created by IntelliJ IDEA.
 * User: game_
 * Date: 24/03/2018
 * Time: 17:31
 */
session_start();
require ('dbconnect.php');
header('Content-Type: application/json');

if (isset($_SESSION['username'])){
    $username = $_SESSION['username'];
    $sql = "SELECT * FROM `MappyUsers` WHERE UserID='$username'";
    $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
    $count = mysqli_num_rows($result);
    if($count==1){
        $xp = mysqli_fetch_assoc($result)['UserXP'];
    }
    else {
        unset($_SESSION);
    }
}


if(isset($_POST['username']) && isset($_POST['password'])){
    $username = $conn->real_escape_string(strip_tags($_POST['username']));
    $password = hash('SHA256', $_POST['password']);
    $sql = "SELECT * FROM `MappyUsers` WHERE UserID='$username' AND UserPW='$password'";
    $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
    $count = mysqli_num_rows($result);

    if($count==1){
        $_SESSION['username'] = $username;
        $xp = mysqli_fetch_assoc($result)['UserXP'];
    }
    else {
        unset($_SESSION);
        $msg = "Invalid Login Credentials.";
    }
}
$json = Array();
if(isset($_SESSION['username'])){
    $username = $_SESSION['username'];
    $json['username'] = $username;
    $json['xp'] = isset($xp) ? $xp : -1;
    $sql = "SELECT * FROM `RoutesToUsers` WHERE UserID='$username'";
    $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
    $json['routes'] = Array();
    while (($row = mysqli_fetch_assoc($result))){
        $route = json_decode($row['Route']);//decode the json string
        $json['routes'][] = $route;
    }
    echo json_encode($json);
}
else {
    $json['msg'] = isset($msg) ? $msg : "Login failed";
    echo(json_encode($json));
}
$conn->close();