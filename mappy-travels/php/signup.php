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
	if ($password == $passconfirm) {
		$json['msg'] = "Passmatch.";
		return true;
	}
	else {
		
		return false;
	}
}

function usernameIsUnique($username, $conn) {
    $sql = "SELECT * FROM `MappyUsers` WHERE `UserID` LIKE '$username'";
    $result = $conn->query($sql);
    if ($result -> fetch_assoc()){
		return false;
    }
    else {
        return true;
    }
}


if(isset($_POST['username']) && isset($_POST['password']) && isset($_POST['reenterpassword'])){
	$json = Array();
    $username = safePOST($conn, 'username');
    $password = $_POST['password'];
    $reenterpassword = $_POST['reenterpassword'];

    if(matchingPasswords($password, $reenterpassword, $json)){
		if (usernameIsUnique($username, $conn, $json)) {
			$password =  hash('SHA256', $password);
			$sql = "INSERT INTO `MappyUsers` (`UserID`, `UserPW`) VALUES ('$username','$password')";
			$result = mysqli_query($conn, $sql);
			if($result){
				$json['result'] = true;
				$json['msg'] = "Registration Successful";
			}
			else {
				$json['result'] = false;
				$json['msg'] = "An error occured. Please try again.";
			}
		}
		else {
			$json['msg'] = "This username is already in use.";
			$json['result'] = false;
		}
    }
	else {
		$json['msg'] = "Passwords do not match.";
		$json['result'] = false;
	}
	echo json_encode($json);
}
else {
	$json = Array();
	$json['result'] = false;
	$json['msg'] = "Please fill in all fields.";
	echo json_encode($json);
}

?>
