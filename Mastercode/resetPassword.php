<?php
session_start();
$conn = mysqli_connect('localhost','root', '');
mysqli_select_db($conn, 'donedb');

if(mysqli_connect_errno()){
    echo "Failed to connect: ". mysqli_connect_errno();
}

if(!isset($_GET["token"])){ //if you don't have a code
    exit("Can't find page");
}

$token = $_GET["token"];
$getEmailQuery = mysqli_query($conn, "SELECT email FROM resetPassword WHERE token='$token'"); //check if token is in and matches the one in the database
    if(mysqli_num_rows($getEmailQuery) == 0){ //if no row in the database has the same token
    exit("Can't find page");
}

if(isset($_POST["password"])){ //if received new password
    $password = $_POST["password"];
    //$password = md5($password); //encrypt password
  
        $row = mysqli_fetch_array($getEmailQuery); //fetches data from getEmailQuery 
        $email = $row["email"];

    $query = mysqli_query($conn, "UPDATE user SET password='$password' WHERE email='$email'"); //update profile with the new password

    if($query){
        $query = mysqli_query($conn, "DELETE FROM resetPassword WHERE token='$token'"); //deletes token from token row after password has been updated
        echo file_get_contents("passwordUpdated.php");
        exit();
    }
    else{
        exit("Something Went Wrong"); //query failed
    }
}

?>

<!DOCTYPE html>
<html lang="en">
    <link rel="stylesheet" href="styles/resetPasswordStyle.css">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
</head>
<body>
    <div class="reset">
        <h1>Done&Done</h1>
        <h2>Reset Password</h2>
        <form method="POST">
            <div class=".txt_field">
            <p><input type="password" name="password" placeholder="New Password"></p>
            <p><input type="submit" name="submit" value="Update Password">
            <p id="return">Return to <a href="login.html">Login</a></p>
    </div>

        </form>
    </div>
</body>
</html>