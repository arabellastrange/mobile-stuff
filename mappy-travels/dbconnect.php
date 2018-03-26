<?php
/**
 * Created by IntelliJ IDEA.
 * User: game_
 * Date: 24/03/2018
 * Time: 14:44
 */
$host = "devweb2017.cis.strath.ac.uk";
$user = "mad3_p";
$pass = "xahJi7kua8Ah";
$dbname = "mad3_p";
$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn -> connect_error)
{
    die("Connection failed.");
}