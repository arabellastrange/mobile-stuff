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

if(isset($_POST['username']) && isset($_POST['password'])){
    $username = $conn->real_escape_string(strip_tags($_POST['username']));
    $password = hash('SHA256', $_POST['password']);
    $sql = "SELECT * FROM `MappyUsers` WHERE UserID='$username' AND UserPW='$password'";
    $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
    $count = mysqli_num_rows($result);

    if($count==1){
        $_SESSION['username'] = $username;
    }
    else {
        unset($_SESSION);
        $msg = "Invalid Login Credentials.";
    }
}

if(isset($_SESSION['username'])){
    $username = $_SESSION['username'];
    echo json_encode($username);
}
else {

    echo(json_encode(false));
}