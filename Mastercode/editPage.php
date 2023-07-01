<?php
 session_start();
 $connect=mysqli_connect("localhost","root","", "donedb") or die("Connection failed");
 //echo "" .$_SESSION['uID'];
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
    <title>Edit Tasks</title>
    <!--CSS Style Sheets-->
    <link rel="stylesheet" href="styles/general.css" />
    <link rel="stylesheet" href="styles/header.css" />
    <link rel="stylesheet" href="styles/task.css" />
    <link rel="stylesheet" href="styles/sidebar.css" />
    <link rel="stylesheet" href="styles/edit.css" />
    <style>
      input[type="submit"],
      input[type="reset"] {
        background-color: rgba(199, 171, 255, 255);
        border: none;
        border-radius: 10px;
        color: black;
        padding: 16px 32px;
        text-decoration: none;
        margin: 4px 2px;
        cursor: pointer;
        text-align: right;
        display:inline-block;
        justify-content: center;
        align-items: center;
        margin: auto;
      }
    </style>
  </head>
  <body>
    <header class="header">
      <!---------------------------------------------------------------------------------------------------->
      <div class="left-section">
        <img class="logo" src="icons/logo_edit.png" />
      </div>
      <!---------------------------------------------------------------------------------------------------->
      <div class="middle-section">
      <form action="editpage.php" method="post" name="searchbar">
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
          <button type="submit" formaction="HOMEPAGE.php" class="search-button">
            <img class="search-icon" src="icons/home.svg" />
            <div class="tooltip">Save Tasks</div>
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
            <select name="category" class="category" required>
            <option value="1">Personal</option>
              <option value="2">Finance</option>
              <option value="3">Work</option>
              <option value="4">School</option>
              <option value="5">Miscellaneous</option>
              <option value="6">Unknown</option>
            </select>

              <label>Description<br />
                <textarea name="description" rows="5" cols="35" required></textarea
                ><br />
              </label>

            <label for="duedate">Due Date</label>
            <input type="date" name="duedate" class="dueDate" required/>

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
    <main class="task-grid">
        <!---------------------------------------------------------------------------------------------------->
        <?php
        if (isset($_POST['submit-search'])&&!empty(@$_POST["search"])){
            $search = mysqli_real_escape_string($connect, $_POST['search']);
            ?>
        <?php
        $query = "select * from task where uID = '$uID' and title like '%$search%' order by duedate";
        $result = mysqli_query($connect, $query);
        while ($row = mysqli_fetch_assoc($result)) {
        ?>
          <div class="task-preview">
          <div class="task-row">
            <div class="task-box">
              <div class="task-form">
                <!--Stephanie (Edit Task) & Emillio Code (New Task) Here?-->
                <form action="updateTaskconnect.php" method="post">
                <input type ="hidden" name="tID" value="<?php echo $row['tID']?>"/>
              
       
                  
                    <!--history feature drop down-->
                    <!-- <i class="fa-light fa-clock-rotate-left"></i> -->
                    <!--title -->
                    <br />
                    <label for="title" >Title</label>
                      <input type="text" name ="title" value="<?php echo $row['title']?>"/>
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
                    <select name="category" class="category" >
                      <option value="<?php echo "$row[cID]"?>"><?php $query = "SELECT task.cID, category.cID, category.category FROM task, category WHERE task.cID = category.cID"; 
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
                    ?></option>
                      <option value="1">Personal</option>
                      <option value="2">Finance</option>
                      <option value="3">Work</option>
                      <option value="4">School</option>
                      <option value="5">Miscellaneous</option>
                      <option value="6">Unknown</option>
                    </select>
                    
                    <!--description box-->
                      <label for="description" >Description
                      </label>
                      <input type="text" name ="description"value="<?php echo $row['description']?>"/>
                    <!--Date-->
                    <label for="duedate">Due Date</label>
                    <input type="date" name="duedate" class="dueDate" value="<?php echo $row['duedate']?>"/>
                    <!--save n cancel-->
                    <input type="submit" name="save" id ="save" value="Save" />
                    <input type="submit" name ="delete" id ="delete" value="Delete" />
              
                </form>
              </div>
              </div>
          </div>
        </div>
        <?php } ?>
        <?php } else { ?>
        <?php
        $query = "select * from task where uID = '$uID' order by duedate";
        $result = mysqli_query($connect, $query);
        while ($row = mysqli_fetch_assoc($result)) {
        ?>
            <div class="task-preview">
          <div class="task-row">
            <div class="task-box">
              <div class="task-form">
                <!--Stephanie (Edit Task) & Emillio Code (New Task) Here?-->
                <form action="updateTaskconnect.php" method="post">
                <input type ="hidden" name="tID" value="<?php echo $row['tID']?>"/>
              
       
                  
                    <!--history feature drop down-->
                    <!-- <i class="fa-light fa-clock-rotate-left"></i> -->
                    <!--title -->
                    <br />
                    <label for="title" >Title</label>
                      <input type="text" name ="title" value="<?php echo $row['title']?>"/>
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
                    </br>
                    <select name="category" class="category" >
                      <option value="<?php echo "$row[cID]"?>"><?php $query = "SELECT task.cID, category.cID, category.category FROM task, category WHERE task.cID = category.cID"; 
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
                    ?></option>
                      <option value="1">Personal</option>
                      <option value="2">Finance</option>
                      <option value="3">Work</option>
                      <option value="4">School</option>
                      <option value="5">Miscellaneous</option>
                      <option value="6">Unknown</option>
                    </select>
                    
                    <!--description box-->
                    <p>
                     <label>Description<br/>
                     <textarea name="description" rows="10" cols="35" ><?php echo $row['description']?></textarea><br/>
                      </label>
                    </p>
                    <!--Date-->
                    <label for="duedate">Due Date</label>
                    <input type="date" name="duedate" class="dueDate" value="<?php echo $row['duedate']?>"/>
                    <!--save n cancel-->
                    <input type="submit" name="save" id ="save" value="Save" />
                    <input type="submit" name ="delete" id ="delete" value="Delete" />
              
                </form>
              </div>
              </div>
          </div>
        </div>
     
              <?php } ?>

              <?php } ?>
        
        
        <!---------------------------------------------------------------------------------------------------->
        <script>
          function validate() {
            var remember = document.getElementById("remember");
            if (remember.checked) {
              document.getElementById("task-preview").style.display = "none";
            } else {
              document.getElementById("task-preview").style.display = "block";
            }
          }
          /*
        */
        </script>
        <!---------------------------------------------------------------------------------------------------->
    </main>
  </body>
</html>
