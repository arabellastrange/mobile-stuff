<?php
require ('dbconnect.php');
//if values are posted, add them into the database.

function safePOST($conn, $name)
{
    if (isset($_POST["$name"])) {
        echo $name;
        return $conn->real_escape_string(strip_tags($_POST[$name]));
    } else {
        return "";
    }
}

function matchingPasswords($password, $passconfirm) {
    return ($password == $passconfirm);
}

function usernameIsUnique($username, $conn) {
    $sql = "SELECT * FROM `MappyUsers` WHERE `UserID` LIKE '$username'";
    $result = $conn->query($sql);
    if ($result -> fetch_assoc()){
        echo "Username not unique";
        return False;
    }
    else {
        echo "Username is unique";
        return True;
    }
}

if(isset($_POST['username']) && isset($_POST['password']) && isset($_POST['reenterpassword'])){
    echo "HOI";
    $username = safePOST($conn, 'username');
    $password = $_POST['password'];
    $reenterpassword = $_POST['reenterpassword'];

    if(matchingPasswords($password, $reenterpassword) && usernameIsUnique($username, $conn)){
        echo "Matching and unique";
        $password =  hash('SHA256', $password);
        $sql = "INSERT INTO `MappyUsers` (`UserID`, `UserPW`) VALUES ('$username','$password')";
        $result = mysqli_query($conn, $sql);
        if($result){
            $sql = "INSERT INTO `PrizesToUsers` (`UserID`) VALUES ('$username')";
            mysqli_query($conn, $sql);
            $msg = "Registration Successful";
        }
        else {
            echo "Registration Failed";
            $msg = "Registration failed";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <title>Sign Up</title>

</head>
<body>
<form id="signup" action="signup.php" method="post">
    <?php if(isset($msg)){ echo $msg; }?>
    <p>Sign Up</p>
    <label for="username">Username:</label>
    <input type="text" name="username" id="username" maxlength="20"/>
    <label for="password">Password:</label>
    <input type="password" name="password" id="password" maxlength="20"/>
    <label for="reenterpassword">Re-enter Password:</label>
    <input type="password" name="reenterpassword" id="reenterpassword" maxlength="20"/>
    <input type="submit" name="submit" value="submit"/>
</form>
</body>
</html>