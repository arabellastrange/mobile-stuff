<?php
require ('dbconnect.php');
//if values are posted, add them into the database.
header('Content-Type: application/json');

function safePOST($conn, $name)
{
    if (isset($_POST["$name"])) {
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
        return False;
    }
    else {
        return True;
    }
}

if(isset($_POST['username']) && isset($_POST['password']) && isset($_POST['reenterpassword'])){
    $username = safePOST($conn, 'username');
    $password = $_POST['password'];
    $reenterpassword = $_POST['reenterpassword'];

    if(matchingPasswords($password, $reenterpassword) && usernameIsUnique($username, $conn)){
        $password =  hash('SHA256', $password);
        $sql = "INSERT INTO `MappyUsers` (`UserID`, `UserPW`) VALUES ('$username','$password')";
        $result = mysqli_query($conn, $sql);
        if($result){
            $sql = "INSERT INTO `PrizesToUsers` (`UserID`) VALUES ('$username')";
            mysqli_query($conn, $sql);
            $msg = "Registration Successful";
            echo json_encode(true);
        }
        else {
            echo json_encode(false);
        }
    }
}
?>
