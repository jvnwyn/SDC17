<?php 
    if (session_status() === PHP_SESSION_NONE) {
      session_start();
    }
    require('reglog_config.php');

    $fname = $lname = $username = $email = $password = $repassword = $phoneNum = $region = $province = $city = $barangay = ''; //initialize the variables so it will not disappear on error
    $errors = array('username'=>'', 'email'=>'', 'password'=>'', 'phoneNum'=>'', 'region'=>'', 'province'=>'', 'city'=>'', 'barangay'=>''); //array for error messages

    if(isset($_POST['submit'])) {
      $fname = mysqli_real_escape_string($conn, $_POST['fname']);
      $lname = mysqli_real_escape_string($conn, $_POST['lname']);
      $username = mysqli_real_escape_string($conn, $_POST['username']);
      $email = mysqli_real_escape_string($conn, $_POST['email']);
      $password = $_POST['password'];
      $repassword = $_POST['repassword'];
      $phoneNum = mysqli_real_escape_string($conn, $_POST['phoneNum']);
      $region = mysqli_real_escape_string($conn, $_POST['region']);
      $province = mysqli_real_escape_string($conn, $_POST['province']);
      $city = mysqli_real_escape_string($conn, $_POST['city']);
      $barangay = mysqli_real_escape_string($conn, $_POST['barangay']);
      $user = $_POST['user'];

      //check username 
      $check_user = "SELECT * FROM user WHERE username = '$username'";
      $check_user_query = mysqli_query($conn, $check_user);
      $check_user_result = mysqli_fetch_row($check_user_query);

      if(!empty($check_user_result)) {
        $errors['username'] = 'Username is already taken';
      }
      //check email
      $check_email = "SELECT * FROM user WHERE email = '$email'";
      $check_email_query = mysqli_query($conn, $check_email);
      $check_email_result = mysqli_fetch_row($check_email_query);

      if(!empty($check_email_result)) {
        $errors['email'] = 'Email address is already registered';
      }
      //check if password match
      if($repassword != $password) {
        $errors['password'] = 'Password do not match';
      }
      //check if password has 8 characters
      if(strlen($password) < 8) {
        $errors['password'] = 'Password must contain atleast 8 characters';
      }//check if phone number has 11 digits
      if(!str_starts_with($phoneNum, '09')) {
        $errors['phoneNum'] = "Phone number must start with '09'";
      }//check if phone number only consists of numbers
      if (!preg_match('/^\d+$/', $phoneNum)) {
        $errors['phoneNum'] = 'Phone number must only consist of numbers';
      }//check if phone number has 11 digits
      if(strlen($phoneNum) != 11) {
        $errors['phoneNum'] = 'Phone number must have 11 digits';
      }
      
      //insert data into the server
      if(!array_filter($errors)) {
        $sql = "INSERT INTO user (fname, lname, username, email, password, phoneNum, region, province, city, barangay, user) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssssssss", $fname, $lname, $username, $email, $password, $phoneNum, $region, $province, $city, $barangay, $user);

        if($stmt->execute()) {
            $_SESSION['username'] = $username;
            header('Location: sign_in.php');
            exit();
        } else {
            echo 'Error: '.mysqli_error($conn);
        }
      }
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
      <meta charset="UTF-8" />
      <meta name="viewport" content="width=device-width, initial-scale=1.0" />
      <title>SDC17</title>
      <link rel="icon" type="image/x-icon" href="asset/logo.png"> <!-- icon -->
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" /> <!-- Eye icon -->
      <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'> <!-- Poppins Font -->
      <link rel="stylesheet" href="style.css">
      <style>
        .password span {
            position: absolute;
            font-size: larger;
            right: 7px;
            transform: translateY(9%);
            cursor: pointer;
        }
        .password span i {
            color: var(--primary);
        }
    </style>
  </head>
  <body>
    <div class="main">
      <div class="whole">
        <div class="all">
          <form action="register.php" method="POST">
            <div class="title">
              <h1>Create Account</h1>
              <img src="asset\logo.png">
            </div>
            <div class="name">
              <div>
                <p>First name:</p>
                <input type="text" name="fname" id="fname" value="<?php echo $fname ?>" autocomplete="off" required />
              </div>
              <div>
                <p>Last Name:</p>
                <input type="text" name="lname" id="lname" value="<?php echo $lname ?>" autocomplete="off" required />
              </div>
              <div>
                <p>Username: </p>
                <input type="text" name="username" id="username" value="<?php echo $username ?>" autocomplete="off" required />
              </div>
            </div>
            <p id="error"><?php echo $errors['username']; ?></p>
            <div class="email">
              <p>Email Address:</p>
              <input type="email" name="email" id="email" placeholder="e.g. example@gmail.com" value="<?php echo $email ?>" autocomplete="off" required />
            </div>
            <p id="error"><?php echo $errors['email']; ?></p>
            <div class="password">
              <p>Password:</p>
              <input type="password" name="password" id="password" placeholder="Atleast 8 characters" value="<?php echo $password ?>" autocomplete="off" required />
              <span class="password-toggle-icon"><i class="fas fa-eye"></i></span>
            </div>
            <div class="repassword">
              <p>Confirm Password:</p>
              <input type="password" name="repassword" id="repassword" value="<?php echo $repassword ?>" autocomplete="off" required />
            </div>
            <p id="error"><?php echo $errors['password']; ?></p>
            <div class="phoneNum">
              <p>Enter Phone Number: </p>
              <input type="tel" name="phoneNum" id="phoneNum" value="<?php echo $phoneNum ?>" autocomplete="off" required />
            </div>
            <p id="error"><?php echo $errors['phoneNum']; ?></p>
            <div class= "loc">
              <p>Address: </p>
              <div class="address_up">
                <input type="text" name="region" id="region" placeholder="Region" value="<?php echo $region ?>" autocomplete="off" required>
                <input type="text" name="province" id="province" placeholder="Province" value="<?php echo $province ?>" autocomplete="off" required>
              </div>
              <div class ="address_down">
                <input type="text" name="city" id="city" placeholder="City" value="<?php echo $city ?>" autocomplete="off" required>
                <input type="text" name="barangay" id="barangay" placeholder="Barangay" value="<?php echo $barangay ?>" autocomplete="off" required>
              </div>

            </div>
            <div class="user">
              <p>Account for: </p>
              <select id="user" name="user">
                <option value="consumer" id="consumer" selected style="color: var(--lightbg);">As Costumer</option>
                <option value="business" id="business" style="color: var(--lightbg);">For Business</option>
              </select>
            </div>
            <div class="button">
              <input type="button" name="cancel" id="cancel" value="Cancel" onclick="document.location.href='sign_in.php';"></input>
              <input type="submit" name="submit" id="submit"></input>
            </div>
          </form>
        </div>
      </div>
    </div>
    <script>
      document.addEventListener("DOMContentLoaded", function() {
      const passwordField = document.getElementById("password");
      const rePasswordField = document.getElementById("repassword");
      const togglePassword = document.querySelector(".password-toggle-icon i");

      togglePassword.addEventListener("click", () => {
          if (passwordField.type === "password" || (rePasswordField && rePasswordField.type === "password")) {
              passwordField.type = "text";
              if (rePasswordField) rePasswordField.type = "text";
              togglePassword.classList.remove("fa-eye");
              togglePassword.classList.add("fa-eye-slash");
          } else {
              passwordField.type = "password";
              if (rePasswordField) rePasswordField.type = "password";
              togglePassword.classList.remove("fa-eye-slash");
              togglePassword.classList.add("fa-eye");
          }
      });
      });
    </script>
  </body>
</html>
