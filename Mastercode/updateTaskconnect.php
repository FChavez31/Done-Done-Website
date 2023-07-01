<?php
    session_start();
    $con=mysqli_connect("localhost","root","", "donedb") or die("Connection failed");
            
                  if (isset($_POST['save'])){
                    $tID = $_POST['tID'];
                    $category = $_POST['category'];
                    $cID = $category;
                    $title = $_POST['title'];
                    $description = $_POST['description'];
                    $duedate = $_POST['duedate'];
                   $sqls = "update task set title ='$title' , duedate ='$duedate' , description ='$description', sID = '1', cID = '$cID' where tID = '$tID'";
                   
                  mysqli_query($con, $sqls);
                  header('location:editPage.php');
                   }

                   if (isset($_POST['delete'])){
                    $tID = $_POST['tID'];
                   $sqls = "delete from task where tID = '$tID'";
                   
                  mysqli_query($con, $sqls);
                  header('location:editPage.php');
                   }

                    ?>