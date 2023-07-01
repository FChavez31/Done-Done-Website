<?php
    
    session_start();

    $con=mysqli_connect("localhost","root","", "donedb") or die("Connection failed");

    mysqli_select_db($con, 'donedb');

    $title = $_POST['title'];
    $category = $_POST['category'];
    $cID = $category;
    $description = $_POST['description'];
    $duedate = $_POST['duedate'];
    //$sID = $_POST['sID'];
    //sID was removed since this wont be user input

    $s = "select * from task where title = '$title'";

   $result = mysqli_query($con, $s);

   $num = mysqli_num_rows($result);

    $uID =  $_SESSION['uID'];

    $reg = "insert into task (title , duedate , uID , cID , sID, description ) values ('$title' , '$duedate', '$uID', '$cID' , '1' , '$description')";
    mysqli_query($con, $reg);
    header('location:HOMEPAGE.php');

?>
