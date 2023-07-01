<?php
    session_start();
     $con = mysqli_connect("localhost","root","", "donedb") or die("Connection failed");
     mysqli_select_db($con, 'donedb');

    if(isset($_POST['submit'])){
        $email = $_POST['email'];
        $password = $_POST['password'];

        $sql = "select * from user where email = '$email' and password = '$password'";
        $result = mysqli_query($con, $sql);
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
        $count = mysqli_num_rows($result);

        if($count==1){
            $_SESSION['uID'] = $row['uID'];
            $_SESSION['email'] = $row['email'];
            $_SESSION['firstname']=$row['firstname'];
            $_SESSION['lastname']=$row['lastname'];
           header("location:HOMEPAGE.php");
        }
        else{
            echo '<script>
                window.location.href = "login.html";
                alert ("Login failed. Invalid email or password.")
                </script>';
        }
    }
    
?>    