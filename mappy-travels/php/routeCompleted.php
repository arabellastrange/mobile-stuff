<?php
/**
 * Created by IntelliJ IDEA.
 * User: game_
 * Date: 24/03/2018
 * Time: 17:31
 */
session_start();
require ('dbconnect.php');

if (isset($_SESSION['username']) && $_POST['username'] == $_SESSION['username']){
    //header('Content-Type: application/json');
    $username = $_SESSION['username'];
    $sql = "SELECT * FROM `MappyUsers` WHERE UserID='$username'";
    $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
    $count = mysqli_num_rows($result);
    if($count==1){
        $xp = mysqli_fetch_assoc($result)['UserXP'];
        $xp += $_POST['xp'];
        $sql = "UPDATE `MappyUsers` SET `UserXP`=$xp WHERE UserID='$username'";
        $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
    }
    else {
        unset($_SESSION);
    }
}
else {
    header("Location: ../index.html");
}

$conn->close();