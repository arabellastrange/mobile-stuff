<?php
/**
 * Created by IntelliJ IDEA.
 * User: losti
 * Date: 28/03/2018
 * Time: 12:47
 */
session_start();
require ('dbconnect.php');
header('Content-Type: application/json');

//TODO validate session

if(isset($_POST['username']) && isset($_POST['route'])){
    $sql = "INSERT INTO `RoutesToUsers`(`id`, `UserID`, `Route`, `Worth`) VALUES (0,?,?,250)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $_POST['username'], $_POST['route']);
    $stmt->execute();
    $stmt->close();
    echo json_encode(Array("success" =>true, "post" => $_POST));
    $conn->close();
}