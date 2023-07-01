<?php
    $con = mysqli_connect('localhost' , 'root' , '');
    mysqli_select_db($con, 'donedb');

    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmpassword = $_POST["confirmpassword"];
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    $s = "select * from user where email = '$email'";

    $result = mysqli_query($con, $s);

    $num = mysqli_num_rows($result);



    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo '<script>
            window.location.href = "sign-up.html";
            alert ("Please choose a valid email.")
            </script>';
    }

    if ($password!==$confirmpassword) {
        echo '<script>
            window.location.href = "sign-up.html";
            alert ("Please make sure the passwords match.")
            </script>';
       }

    if($num == 1 || empty($email) || $password!==$confirmpassword){
        echo '<script>
                window.location.href = "sign-up.html";
                alert ("Email is already taken.")
                </script>';
    }else{
        $reg ="insert into user(firstname , lastname , email , password) values ('$firstname' , '$lastname' , '$email' , '$password')";
        session_start();
        mysqli_query($con, $reg);
        $_SESSION['uID'] = mysqli_insert_id($con);
        $uID = $_SESSION['uID'];
        $sql ="select * from user where uID = '$uID'";
        $result = mysqli_query($con, $sql);
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

        $_SESSION['firstname'] = $row['firstname'];
        $_SESSION['lastname'] = $row['lastname'];
        $_SESSION['email'] = $row['email'];
        header('location:HOMEPAGE.php');
    }


?>