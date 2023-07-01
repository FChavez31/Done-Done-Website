<?php
     include('login.php');
     session_start();

     $con = mysqli_connect('localhost' , 'root' , '');
     mysqli_select_db($con, 'donedb');

     $firstname = $_POST['fname'];
     $lastname = $_POST['lname'];
     $email = $_POST['email'];
     $pnumber = $_POST['pnumber'];
     $oldpassword = $_POST['oldpsw'];
     $newpassword = $_POST['newpsw'];

     $currentuser = $_SESSION['uID'];

     if(isset($_POST['submit'])){

        $sql = "select * from user where uID = '$currentuser'";
        $gotresults = mysqli_query($con, $sql);

        if($gotresults){
          if(mysqli_num_rows($gotresults)>0){
               while($row = mysqli_fetch_array($gotresults)){
                    print_r($row['uID']);
               }
          }
        }

     }
?>