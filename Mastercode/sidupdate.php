<?php
    session_start();
    $con=mysqli_connect("localhost","root","", "donedb") or die("Connection failed");
            
                  if (isset($_POST['completed'])){
                    $tID = $_POST['tID'];
                    $sqls = "update task set sID =2 where tID = '$tID'";
                   mysqli_query($con, $sqls);
                  header('location:HOMEPAGE.php');
                   }

                    ?>
