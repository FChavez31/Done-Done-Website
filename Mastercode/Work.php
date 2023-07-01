<?php
 session_start();
 $connect=mysqli_connect("localhost","root","", "donedb") or die("Connection failed");
 $uID = $_SESSION['uID'];
?>
<!--Emilio: Login & Forgot Password Page
    Fernando: Sign-Up Page
    Jocelyn: Home Page
    Emillio: New Task
    Stephanie: Edit Task
    Takeyah: "General Settings" & Account Settings-->
    <!DOCTYPE html>
<html>
  <head>
    <!--Emilio (Login & Forgot Password Page) & Fernando (Sign-Up Page) Code Leads To Here?-->
    <!--Fernando's (Sign-Up Page) Code Also Links To Emilio's (Login & Forgot Password Page) Code-->
    <title>Homepage</title>
    <!--CSS Style Sheets-->
    <link rel="stylesheet" href="styles/general.css" />
    <link rel="stylesheet" href="styles/header.css" />
    <link rel="stylesheet" href="styles/task.css" />
    <link rel="stylesheet" href="styles/sidebar.css" />
  </head>
  <body>
    <header class="header">
      <!---------------------------------------------------------------------------------------------------->
      <div class="left-section">
        <img class="logo" src="icons/logo.png" />
      </div>
      <!---------------------------------------------------------------------------------------------------->
      <div class="middle-section">
      <form action="HOMEPAGE.php" method="post" name="searchbar">
        <input class="search-bar" type="text" placeholder="Search..." name="search" id="search" />
        <button class="search-button" button type="submit" name="submit-search">
          <img class="search-icon" src="icons/search.svg" /> </button>
        </form>
        <button
          id="notifications"
          onclick="toggleNotifications()"
          type="submit"
          class="notifications"
        >
          Notifications ON!
          <div class="tooltip">Notifications</div>
        </button>
        <script>
          function toggleNotifications() {
            var x = document.getElementById("notifications");
            if (x.innerHTML === "Notifications ON!") {
              x.innerHTML = "Notifications OFF!";
            } else {
              x.innerHTML = "Notifications ON!";
            }
          }
        </script>
        <!--Put position absolute inside position relative-->
      </div>
      <!---------------------------------------------------------------------------------------------------->
      <div class="right-section">
        <form>
          <button
            type="submit"
            formaction="editPage.php"
            class="search-button"
          >
            <img class="search-icon" src="icons/edit.png" />
            <div class="tooltip">Edit Tasks</div>
          </button>
        </form>
        <!--Emillio Code (New Task) Here?-->
        <button
          class="create-task-button"
          class="open-button"
          onclick="openForm()"
        >
          <img class="create-task-icon" src="icons/plus-sign.png" />
          <div class="tooltip">Create Task</div>
        </button>
        <!--------------------Create Task Form Popup------------------------------>
        <div class="form-popup" id="myForm">
          <form action="createTaskconnect.php" method="post" class="form-container">
            <h1>New Task</h1>
            <!---------->
            <label for="title">Title</label>
            <input
              type="text"
              id="title"
              name="title"
              placeholder="sample..."
              required
            />

            <label for="category">Category</label>
            </br>
            <select name="category" class="category" required>
              <option value="1">Personal</option>
              <option value="2">Finance</option>
              <option value="3">Work</option>
              <option value="4">School</option>
              <option value="5">Miscellaneous</option>
              <option value="6">Unknown</option>
            </select>

            <p>
            <label>Description<br/>
            <textarea name="description" rows="10" cols="35" require ></textarea><br/>
            </label>
            </p>
            </br>

            <label for="duedate">Due Date</label>
            <input type="date" name="duedate" class="dueDate" required/>
            </br>

            <button type="submit" class="btn">Save</button>
            <button type="button" class="btn cancel" onclick="closeForm()">
              Cancel
            </button>
          </form>
        </div>
        <!-----------------------Javascript For Opening & Closing Form--------------------------->
        <script>
          function openForm() {
            document.getElementById("myForm").style.display = "block";
          }

          function closeForm() {
            document.getElementById("myForm").style.display = "none";
          }
        </script>
        <!-------------------------------------------------->
        <button
          class="account-icon-container"
          class="open-button"
          onclick="openDropdown()"
        >
          <img class="account-settings-icon" src="icons/account-settings.png" />
          <div class="tooltip">Account Settings</div>
        </button>
        <!--------------------Settings Dropdown------------------------------>
        <div class="drop-down" id="myDropdown">
          <form class="form-container">
            <button type="submit" formaction="login.html" class="btn nav">
              Logout
            </button>
            <button type="submit" formaction="Settings.html" class="btn nav">
              Account
            </button>
            <?php
              if(isset($_GET['logout'])){
                session_destroy();
              }
              ?>
            <button type="button" class="btn cancel" onclick="closeDropdown()">
              Close
            </button>
          </form>
        </div>
        <!-----------------------Javascript For Opening & Closing Settings Dropdown--------------------------->
        <script>
          function openDropdown() {
            document.getElementById("myDropdown").style.display = "block";
          }

          function closeDropdown() {
            document.getElementById("myDropdown").style.display = "none";
          }
        </script>
        <!-------------------------------------------------->
      </div>
      <!---------------------------------------------------------------------------------------------------->
    </header>
    <nav class="sidebar">
      <!-------------------------------------------------->
      <div class="sidebar-link">
        <!--Add image source here later-->
        <!--<div>Personal</div>-->
        <a href="Personal.php">
        Personal
        </a>
      </div>
      <!-------------------------------------------------->
      <div class="sidebar-link">
        <!--Add image source here later-->
        <a href="Finance.php">
        Finance
        </a>
      </div>
      <!-------------------------------------------------->
      <div class="sidebar-link">
        <!--Add image source here later-->
        <!--<div>Personal</div>-->
        <a href="HOMEPAGE.php">
        Work
        </a>
      </div>
      <!-------------------------------------------------->
      <div class="sidebar-link">
        <!--Add image source here later-->
        <a href="School.php">
        School
        </a>
      </div>
      <!-------------------------------------------------->
      <div class="sidebar-link">
        <!--Add image source here later-->
        <!--<div>Personal</div>-->
        <a href="Miscellaneous.php">
        Miscellaneous
        </a>
      </div>
      <!-------------------------------------------------->
      <div class="sidebar-link">
        <!--Add image source here later-->
       <!--<div>Personal</div>-->
       <a href="Unknown.php">
        Unknown
        </a>
      </div>
      <!-------------------------------------------------->
    </nav>
    <main class="task-grid">
        <!---------------------------------------------------------------------------------------------------->
        <?php
        if (isset($_POST['submit-search'])&&!empty(@$_POST["search"])){
            $search = mysqli_real_escape_string($connect, $_POST['search']);
            ?>
        <?php
        $query = "select * from task where uID = '$uID' and sID = 1 and title like '%$search%' order by duedate";
        $result = mysqli_query($connect, $query);
        while ($row = mysqli_fetch_assoc($result)) {
        ?>
            <div class="task-preview">
          <div class="task-row">
            <div class="task-box">
              <div class="task-form">
                <!--Stephanie (Edit Task) & Emillio Code (New Task) Here?-->
                <form action="" method="post">
              
       
                  
                    <!--history feature drop down-->
                    <!-- <i class="fa-light fa-clock-rotate-left"></i> -->
                    <!--title -->
                    <form action = "sidupdate.php" method="POST">
                    <input type ="hidden" name="tID" value="<?php echo $row['tID']?>"/>
                    <button type="submit" name = "completed" id="completed">Complete</button>
                    </br>

                    <label for="title">Title</label>
                      <input type="text" value="<?php echo $row['title']?>"/>
                    <!--category: personal, finance, work, school, -->
                    <!--miscellaneous, unknown-->
                    <!---
                    <div id="poll">
                    <label for="category">Category</label>
                    <select id="category" name="category" class="category" onchange="my_fun(this.value);">
                      <option value="Personal">Personal</option>
                      <option value="Finance">Finance</option>
                      <option value="Work">Work</option>
                      <option value="School">School</option>
                      <option value="Miscellaneous">Miscellaneous</option>
                      <option value="Unknown">Unknown</option>
                    </select>
                    </div>
                    --->
                    <label for="category">Category</label>
                    <input type="text" value="
                    <?php $query = "SELECT task.cID, category.cID, category.category FROM task, category WHERE task.cID = category.cID"; 
                    switch ($row['cID']) {
                      case "1":
                        echo "Personal";
                        break;
                      case "2":
                        echo "Finance";
                        break;
                      case "3":
                        echo "Work";
                        break;
                      case "4":
                        echo "School";
                        break;
                      case "5":
                        echo "Miscellaneous";
                        break;
                      case "6":
                        echo "Unknown";
                        break;
                      default:
                        echo "Please select a category";
                    }
                    ?>"/>
                    
                    <!--description box-->
                    <p>
                     <label>Description<br/>
                     <textarea name="description" rows="10" cols="35" ><?php echo $row['description']?></textarea><br/>
                      </label>
                    </p>
                    <!--Date-->
                    <label for="duedate">Due Date</label>
                    <input type="text" name="duedate" class="dueDate" value="<?php echo $row['duedate']?>"/>
                    <!--save n cancel-->
                    </form>
              
                </form>
              </div>
              </div>
          </div>
        </div>
        <?php } ?>
        <?php } else { ?>
          <?php
        $query = "select * from task where uID = '$uID' and sID = 1 and cID = 3 order by duedate";
        $result = mysqli_query($connect, $query);
        while ($row = mysqli_fetch_assoc($result)) {
        ?>
            <div class="task-preview">
          <div class="task-row">
            <div class="task-box">
              <div class="task-form">
                <!--Stephanie (Edit Task) & Emillio Code (New Task) Here?-->

                    <!--history feature drop down-->
                    <!-- <i class="fa-light fa-clock-rotate-left"></i> -->
                    <!--title -->
                    <form action="sidupdate.php" method="POST">
                    <input type ="hidden" name="tID" value="<?php echo $row['tID']?>"/>
                    <button type="submit" name = "completed" id="changes">Complete</button>
                    </form>
                    </br>
                    
                    <label for="title">Title</label>
                      <input type="text" value="<?php echo $row['title']?>"/>
                    <!--category: personal, finance, work, school, -->
                    <!--miscellaneous, unknown-->
                    <!---
                    <div id="poll">
                    <label for="category">Category</label>
                    <select id="category" name="category" class="category" onchange="my_fun(this.value);">
                      <option value="Personal">Personal</option>
                      <option value="Finance">Finance</option>
                      <option value="Work">Work</option>
                      <option value="School">School</option>
                      <option value="Miscellaneous">Miscellaneous</option>
                      <option value="Unknown">Unknown</option>
                    </select>
                    </div>
                    --->
                    <label for="category">Category</label>
                    <input type="text" value="
                    <?php 
                    switch ($row['cID']) {
                      case "1":
                        echo "Personal";
                        break;
                      case "2":
                        echo "Finance";
                        break;
                      case "3":
                        echo "Work";
                        break;
                      case "4":
                        echo "School";
                        break;
                      case "5":
                        echo "Miscellaneous";
                        break;
                      case "6":
                        echo "Unknown";
                        break;
                      default:
                        echo "Please select a category";
                    }
                    ?>"/>
                    
                    <!--description box-->
                    <p>
                    <label>Description<br/>
                    <textarea name="description" rows="10" cols="35" ><?php echo $row['description']?></textarea><br/>
                    </label>
                    </p>
 
                    <!--Date-->
                    <label for="duedate">Due Date</label>
                    <input type="text" name="duedate" class="dueDate" value="<?php echo $row['duedate']?>"/>
                    <!--save n cancel-->
                
              

              </div>
              </div>
          </div>
        </div>
    
                <?php } ?>
            
          <?php } ?>
       
        <!---------------------------------------------------------------------------------------------------->
        <script>
          /*
          function my_fun(str) {
            if (window.XMLHttpRequest) {
              xmlhttp = new XMLHttpRequest();
            } else {
              xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange = function(){
              if (this.readyState == 4 && this.status == 200){
                document.getElementByID('poll').innerHTML = this.responseText;
              }
            }
            xmlhttp.open("GET", "fetch-data.php?value="+str, true);
            xmlhttp.send();
          }
        */
        </script>
        <!---------------------------------------------------------------------------------------------------->
    </main>
  </body>
</html>