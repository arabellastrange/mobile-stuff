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
if($_SERVER["REQUEST_METHOD"] == "POST") {
    //Username validation
    if (empty(trim($_POST["username"]))) {
        //Some kind of username error;
    } else {
        //Prepared sql statements
        $sql = "SELECT UserID FROM MappyUsers WHERE UserID=?";

        if($stmt = $conn->prepare($sql)){
            //binds parameters to the prepared statement
            $stmt->bind_param("s", $param_username);
            //sets the parameters
            $param_username = trim($_POST["username"]);
            if ($stmt->execute()) {
                //store result
                $stmt->store_result();
                if ($stmt->num_rows > 0) {
                    //some kind of username error - already taken;
                } else {
                    $username = trim($_POST["username"]);
                }
            } else {
                //Something went wrong
            }
            //close statement
            $stmt->close();
        }

    }

    //Password validation
    if (empty(trim($_POST['password']))) {
        //Password error - empty
    } else {
        $password = trim($_POST['password']);
    }

    //Confirm password validation
    if (empty(trim($_POST["confirmPassword"]))) {
        //confirm password error - empty
    } else {
        $confirmPassword = trim($_POST['confirmPassword']);
        if ($password != $confirmPassword) {
            //confirm password error - didn't match
        }
    }

    //REQUIRED HERE: error checking before database insertion

    //prepare insert statement
    $sql = "INSERT INTO MappyUsers (UserID, UserPW) VALUES (?, ?)";
    if ($stmt = $conn->prepare($sql)) {
        //Bind variables to prepared statement as parameters
        $stmt->bind_param("ss", $param_username, $param_password);
        //set parameters
        $param_username = $username;
        $param_password = password_hash($password, PASSWORD_BCRYPT); //hashes passsword - safety

        if ($stmt->execute()) {
            echo "successfully made an account, check the database"; //Redirects to homescreen later - just for testing.
        } else {
            echo "Something went wrong.";
        }
    }

    $stmt->close();

    $conn->close();
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
        <input type="password" name="confirmPassword"/> <br>
        <input type="submit" value="Submit">
        <p>Already have an account? Sign in</p> <!--needs link to log in page-->
    </form>
</div>
</body>
