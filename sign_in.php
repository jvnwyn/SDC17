<?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    require('reglog_config.php');
    
    $username_or_email = $password = ''; //initialize these variables so it won't disappear on error

    $errors = array('password'=>'');// array for errors

    if(isset($_POST['continue'])) {
        $username_or_email = mysqli_real_escape_string($conn, $_POST['username_or_email']);
        $password = $_POST['password'];

        // selects the chosen column from the table
        $sql = "SELECT * FROM user WHERE username = '$username_or_email' OR email = '$username_or_email'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);

        // checks if the user data is already in the server
        if(mysqli_num_rows($result) > 0 ) {
            if($password == $row['password']) {
                $_SESSION['username_or_email'] = $row['username_or_email'];
                $_SESSION['fname'] = $row['fname'];
                $_SESSION['lname'] = $row['lname'];
                $_SESSION['username'] = $row['username'];
                $_SESSION['email'] = $row['email'];
                $_SESSION['password'] = $row['password'];
                $_SESSION['phoneNum'] = $row['phoneNum'];
                $_SESSION['user'] = $row['user'];
                header('Location:user_profile.php');
            }
            else {
                $errors['password'] = 'Incorrect username or password';
            }
        }
        else {
            echo "<script>alert('User not found')</script>";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
        <div class="all">
            <form action="sign_in.php" method="POST">
                <div class="title">
                    <h1>Sign In</h1>
                    <img src="asset/logo.png">
                </div>
                <div class="username_or_email">
                    <p>Enter Username or Email Address:</p>
                    <input type="text"  name="username_or_email" id="email" value="<?php echo $username_or_email ?>" style="color: var(--primary);" autocomplete="off" required />
                </div>
                <div class="password">
                    <p>Enter Password:</p>
                    <input type="password" name="password" id="password" value="<?php echo $password ?>" style="color: var(--primary);" autocomplete="off" required />
                    <span class="password-toggle-icon"><i class="fas fa-eye"></i></span>         
                </div>
                <p id="error"><?php echo $errors['password'];?></p>
                <div class="button">
                    <input type="reset" id="cancel" name="cancel" value="Cancel" onclick="document.location.href='index.php';">
                    <input type="submit" id="continue" name="continue" value="Continue">
                </div>
                <br>
                <hr />
                <br>
                <div class="register">
                    <p>No account yet?</p>
                    <input type="button" name="register" id="register" value="Create your account" onclick="document.location.href='register.php';">
                </div>
            </form>
        </div>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
        const passwordField = document.getElementById("password");
        const togglePassword = document.querySelector(".password-toggle-icon i");

        togglePassword.addEventListener("click", () => {
            if (passwordField.type === "password") {
                passwordField.type = "text";
                togglePassword.classList.remove("fa-eye");
                togglePassword.classList.add("fa-eye-slash");
            } else {
                passwordField.type = "password";
                togglePassword.classList.remove("fa-eye-slash");
                togglePassword.classList.add("fa-eye");
            }
        });
        });
    </script>
</body>
</html>