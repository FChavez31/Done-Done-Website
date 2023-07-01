<?php
 session_start();
 $connect=mysqli_connect("localhost","root","", "donedb") or die("Connection failed");

 $firstname = $_SESSION['firstname'];
 $lastname = $_SESSION['lastname'];
 $email = $_SESSION['email'];

 echo "Welcome, " . $_SESSION['firstname'] . " " . $_SESSION['lastname'];
?>
<!DOCTYPE html>
<html>
<head>
  
  <title>Settings</title>
  <!--CSS Style Sheets-->
  <link rel="stylesheet" href="styles/general.css" />
  <link rel="stylesheet" href="styles/settingsstyle.css" />
 
 </head>
 
   <body>
    <!---Header-->
    <header class="header">
     <!------Logo------>
      <div class="left-section">
        <img class="logo" src="icons/logo.png" />
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
   
    <!---Home Button-->
    <div class="right-section">
      <button class="home-icon-container"
       class="open-button"
       onclick="location.href='HOMEPAGE.php'">
         <img class="home-icon-container" src="icons/home6.png" />
         <div class="tooltip">Home</div>
       </button>
       

      <!--Settings Button--->
      <div>
          <button class="account-icon-container"
            class="open-button"
            onclick="openDropdown()">
            <img class="account-settings-icon" src="icons/account-settings.png" />
            <div class="tooltip">Account Settings</div>
          </button>
         </div>
    
      
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
       
      </div>
    
    </header>
  
    <!--Form Container--->
    <div class="container">
        <div id="logo">
          <h1 class="logo"></h1>
          <div class="CTA">
             </div>
             
      <div class="rightbox">
          <div class="profile">
        </div>

     <!--Form Fields--->   
    <form action ="settingsconnect.php" method="post">
    
    <h3 class="form-title">User Profile</h3>

   <label for="firstname">First Name: </label><br>
    <input type="text" id="firstname" name="firstname"  value="<?php echo isset($_SESSION['firstname']) ? $_SESSION['firstname'] : ''; ?>" required></br>
   
    <label for="lname">Last Name:</label><br>
    <input type="text" id="lastname" name="lastname" value="<?php echo isset($_SESSION['lastname']) ? $_SESSION['lastname'] : ''; ?>" required ></br>

    <label for ="email">Email:</label><br>
    <input type="email" name="email" placeholder=email@email.com value="<?php echo isset($_SESSION['email']) ? $_SESSION['email'] : ''; ?>" readonly required></br>
 
    <label for="oldpassword">Current Password: </label><br>
    <input type="password" id="password" name="password"  pattern=".{8,40}" title="8 or more Character" size="30" required pattern="[!@#$%^&*][a-z][A-Z][0-9]" 
    ></br>
  
    <label for="newpassword">New Password: </label><br>
    <input type="password" id="newpassword" name="newpassword"  pattern=".{8,40}" title="8 or more Character" size="30" required pattern="[!@#$%^&*][a-z][A-Z][0-9]"  
     ></br>

     <label for="newpassword">Confirm New Password: </label><br>
     <input type="password" id="cnewpassword" name="cnewpassword"  pattern=".{8,40}" title="8 or more Character" size="30" required pattern="[!@#$%^&*][a-z][A-Z][0-9]"  
      ></br>


<!---Cancel & Update Button-->
<button type="button" onclick="resetProfile()"> Cancel</button> 
<button type="submit" onclick="saveProfile()">Update</button>

</form>

<!------Javascript------->          
<script> 

//Cancel Button Message

function resetProfile() {
  let firstname = document.getElementById('firstname');
  let lastname = document.getElementById('lastname');
  
  let password = document.getElementById('password');
  let newpassword = document.getElementById('newpassword');

  // Store the current values of the form fields
  let firstnameValue = firstname.value;
  let lastnameValue = lastname.value;
  
  let passwordValue = password.value;
  let newpasswordValue = newpassword.value;

  if (confirm("Are you sure you want to cancel?")) {
    // If the user clicks "OK", reset the form data
    firstname.value = '';
    lastname.value = '';
   
    password.value = '';
    newPassword.value = '';
  } else {
    // If user clicks "cancel", restore the saved values 
    firstname.value = firstnameValue;
    lastname.value = lastnameValue;
   
    password.value = passwordValue;
    newPassword.value = newpasswordValue;
  }
}


function validateForm() {
  let password = document.getElementById("password").value;
  let newPassword = document.getElementById("newpassword").value;
  let cNewPassword = document.getElementById("cnewpassword").value;

  // check if all three password fields are empty
  if (!password && !newPassword && !cNewPassword) {
    return true;
  }

  // check if new password & confirm new password are not filled when current password is filled
  if (password && (newPassword === "" || cNewPassword === "")) {
    alert("Please enter new password and confirm new password");
    return false;
  }
  
  // check if current password is not filled when new password or confirm new password is filled
  if ((!password || password === "") && (newPassword || cNewPassword)) {
    alert("Please enter current password");
    return false;
  }

  // disallow saving the profile when only the "password" field is submitted
  if (password && !newPassword && !cNewPassword) {
    alert("Please enter new password and confirm new password");
    return false;
  }
  
  if (newPassword !== cNewPassword) {
    alert("New password and confirm new password do not match");
    return false;
  }

  return true;
}




// Submit form
function saveProfile() {
  if (validateForm()) {
    // Save the user's profile info
    let firstname = document.getElementById("firstname").value;
    let lastname = document.getElementById("lastname").value;
    let email = document.getElementById("email").value;
    
    localStorage.setItem("firstname", firstname);
    localStorage.setItem("lastname", lastname);
    localStorage.setItem("email", email);
    
    alert("Profile saved.");
  }
}

</script> 