<?php
/**
 * Created by IntelliJ IDEA.
 * User: game_
 * Date: 24/03/2018
 * Time: 17:31
 */
session_start();
require ('dbconnect.php');
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
        $msg = "Invalid Login Credentials.";
    }
}

if(isset($_SESSION['username'])){
    $username = $_SESSION['username'];
    echo "Welcome " . $username . "!";
}
else {

    ?>

    <!DOCTYPE html>
    <html>
<head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <title>Sign In</title>

</head>
<body>
<form id="signin" action="signin.php" method="post">
    <?php if (isset($msg)) {
        echo $msg;
    } ?>
    <p>Sign In</p>
    <label for="username">Username:</label>
    <input type="text" name="username" id="username" maxlength="20"/>
    <label for="password">Password:</label>
    <input type="password" name="password" id="password" maxlength="20"/>
    <input type="submit" name="submit" value="submit"/>
</form>
</body>

    <?php
}