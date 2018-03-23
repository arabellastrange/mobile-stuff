<?php
/**
 * Created by IntelliJ IDEA.
 * User: game_
 * Date: 23/03/2018
 * Time: 12:46
 */
require_once 'SQLConfig.php';
session_start();
$username = $password = $confirm_password = "";
if($_SERVER["REQUEST_METHOD"] == "POST"){
    //Username validation
    if(empty(trim($_POST["username"]))){
        //Some kind of username error;
    }
    else{
        //Prepared sql statements
        $sql = "SELECT id FROM MappyUsers WHERE UserID = ?";
        if($statement = $mysqli->prepare($sql)){
            //binds parameters to the prepared statement
            $statement->bind_param("s", $param_username);
            //sets the parameters
            $param_username = trim($_POST["username"]);
            if($statement->execute()){
                //store result
                $statement->store_result();
                if($statement->num_rows == 1){
                    //some kind of username error
                }
                else {
                    $username = trim($_POST["username"]);
                }
            }
        }
    }
}
?>
<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <title>Register</title>
</head>
<body>
<div>
    <h1>Register</h1>
    <p>Welcome to Mappy Travels/App City!</p>
    <p>To sign up, fill in the form below:</p>
    <form action="" method="post">
        <label>Username: </label>
        <input type="text" name="username"/> <br>
        <label>Password: </label>
        <input type="password" name="password"/> <br>
        <label>Re-enter Password: </label>
        <input type="password" name="confirm-password"/> <br>
        <input type="submit" value="Submit">
        <p>Already have an account? Sign in</p> <!--needs link to log in page-->
    </form>
</div>
</body>
