<?php
/**
 * Created by IntelliJ IDEA.
 * User: game_
 * Date: 23/03/2018
 * Time: 12:57
 */
$host = "devweb2017.cis.strath.ac.uk";
$user = "mad3_p";
$pass = "xahJi7kua8Ah";
$dbname = "mad3_p";
$conn = new mysqli($host,$user,$pass,$dbname);
if($conn -> connect_error){
    die("ERROR: Unable to connect. " . mysqli_connect_error());
}
