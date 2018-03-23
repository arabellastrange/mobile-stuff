<?php
/**
 * Created by IntelliJ IDEA.
 * User: game_
 * Date: 23/03/2018
 * Time: 12:57
 */
define('server', 'devweb2017.cis.strath.ac.uk');
define('un', 'mad3_p');
define('pw', 'xahJi7kua8Ah');
$db = mysqli_connect(server,un,pw);
if($db === false){
    die("ERROR: Unable to connect. " . mysqli_connect_error());
}
?>