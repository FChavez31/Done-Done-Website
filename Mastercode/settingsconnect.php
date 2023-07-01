<?php
session_start();

$con = mysqli_connect('localhost', 'root', '');
mysqli_select_db($con, 'donedb');

$uID = $_SESSION['uID'];
$firstname = $_POST['firstname'];
$lastname = $_POST['lastname'];
$email = $_POST['email'];
$password = $_POST['password'];
$newpassword = $_POST['newpassword'];
$cnewpassword = $_POST['cnewpassword'];

//Allow user to see updated first and last name 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  
  if (isset($_POST['firstname']) && isset($_POST['lastname'])) {
    // both first name and last name were submitted in the form data
    $firstname = trim($_POST['firstname']); 
    $lastname = trim($_POST['lastname']);
    if (!empty($firstname) && !empty($lastname)) {
      // first name and last name are not empty 
      $_SESSION['firstname'] = $firstname; 
      $_SESSION['lastname'] = $lastname; 
      // send a success response or redirect to a success page
    } else {
      // first name or last name is empty or only whitespace
      
    }
  } else {
    // first name or last name was not submitted in the form data
    
  }
}


if ($firstname && $lastname) {
    // Update the first and last name fields
    $s = "UPDATE user SET firstname='$firstname', lastname='$lastname' WHERE uID='$uID'";
    mysqli_query($con, $s);
    echo '<script>
        window.location.href = "Settings.php";
        alert ("Information updated successfully.")
        </script>';
    exit();
}

if ($password || $newpassword || $cnewpassword) {
    // Check if all three password fields are filled
    if (!$password || !$newpassword || !$cnewpassword) {
        echo '<script>
            window.location.href = "Settings.php";
            alert ("Please enter all three password fields.")
            </script>';
        exit();
    }
    
    // Check if the new password & confirm new password fields match
    if ($newpassword !== $cnewpassword) {
        echo '<script>
            window.location.href = "Settings.php";
            alert ("New password and confirm new password fields do not match.")
            </script>';
        exit();
    }

    // Check if the old password is correct
    $s = "SELECT password FROM user WHERE uID = '$uID'";
    $result = mysqli_query($con, $s);
    $row = mysqli_fetch_assoc($result);

    if (password_verify($password, $row['password'])) {
        // Update the password in the database
        $newPasswordHash = password_hash($newpassword, PASSWORD_DEFAULT);
        $s = "UPDATE user SET password='$newPasswordHash' WHERE uID='$uID'";
        mysqli_query($con, $s);
        echo '<script>
            window.location.href = "Settings.php";
            alert ("Password updated successfully.")
            </script>';
        exit();
    } else {
        echo '<script>
            window.location.href = "Settings.php";
            alert ("Entered password is incorrect.")
            </script>';
        exit();
    }
}
?>