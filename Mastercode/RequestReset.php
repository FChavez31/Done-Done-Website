<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
//use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

session_start();
$conn = mysqli_connect('localhost','root','');
mysqli_select_db($conn, 'donedb');

if(mysqli_connect_errno()){
    echo "Failed to connect: ". mysqli_connect_errno();
}
//else{
   // echo("Connection Successful");
//}

//check form is submitted
if(isset($_POST["email"])){ //if email has been sent to this page
    $emailTo = $_POST["email"]; //send email to email that was submitted
    $token = uniqid(true); //create token and true makes it more unique
    $query=mysqli_query($conn, "INSERT INTO resetPassword(token, email) VALUES('$token', '$emailTo')"); //insert generated token into user database
    if(!$query){
        exit("Error");
    }
    //Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    //Server settings
    //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'doneanddonereset@gmail.com';                     //SMTP username
    $mail->Password   = 'dcjucrqkvwndunnw';                               //SMTP password
    $mail->SMTPSecure = 'tls';            //Enable implicit TLS encryption
    $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('doneanddonereset@gmail.com', 'Done&Done');
    $mail->addAddress($emailTo);     //Add a recipient
    $mail->addReplyTo('doneanddonereset@gmail.com', 'No-Reply Done&Done');


    //Attachments
    //$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
    //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

    //Content
    $url = "http://" . $_SERVER["HTTP_HOST"] . dirname($_SERVER["PHP_SELF"]) . "/resetPassword.php?token=$token"; //url to reset password page in the local host 
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Done&Done Password Reset Link';
    $mail->Body    = "<h2>You requested a password reset link to change your password</h2>
                        Click <a href='$url'>here</a>";
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();
    echo file_get_contents("sentEmail.php");
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}

exit(); //if form is submitted exit code

}


?>


<!DOCTYPE html>
<html lang="en">
    <link rel="stylesheet" href="styles/forgotStyle.css">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
</head>
<body>
    <div class="forgot">
        <h1>Done&Done</h1>
        <h2>Forgot Password?</h2>
        <form method="POST"> <!--send data to this page so no action -->
        <div class=".txt_field">
            
            <input type="text" placeholder="Enter Email" name="email" required>
            
            <p><input type="submit" value="Send" name="submit"></p>
            <p id="return">Return to <a href="login.html">Login</a></p>
        </div>
    </form>

</body>
</html>