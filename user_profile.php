<?php 
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    require('reglog_config.php');
    

    $error = '';
    $success = '';

    $email_error = '';
    $phone_num_error = '';
    $address_error = '';
    $password_error = '';

    $email_success = '';
    $phone_num_success = '';
    $address_error = '';
    $password_success = '';
 

    if (!isset($_SESSION['username'])) {
        header('Location: login.php');
        exit();
    }
    $fname = isset($_SESSION['fname']) ? $_SESSION['fname'] : '';
    $lname = isset($_SESSION['lname']) ? $_SESSION['lname'] : '';
    $username = isset($_SESSION['username']) ? $_SESSION['username'] : '';
    $email = isset($_SESSION['email']) ? $_SESSION['email'] : '';
    $phoneNum = isset($_SESSION['phoneNum']) ? $_SESSION['phoneNum'] : '';
    $user = isset($_SESSION['user']) ? $_SESSION['user'] : '';


    // Fetch user's current profile photo and other details
    $query = $conn->prepare("SELECT image, region, province, city, barangay FROM user WHERE username = ?");
    $query->bind_param("s", $username);
    $query->execute();
    $result = $query->get_result();
    $row = $result->fetch_assoc();
    $_SESSION['image'] = $row['image'] ? 'pfpimg/' . $row['image'] : 'asset/default_pfp.jpg';
    $image = $_SESSION['image'];

    // Check if other user details are set and assign them to session variables or use defaults
    $_SESSION['region'] = $row['region'] ?? '';
    $_SESSION['province'] = $row['province'] ?? '';
    $_SESSION['city'] = $row['city'] ?? '';
    $_SESSION['barangay'] = $row['barangay'] ?? '';

    $region = $_SESSION['region'];
    $province = $_SESSION['province'];
    $city = $_SESSION['city'];
    $barangay = $_SESSION['barangay'];

    // Fetch user's current password
    $query = $conn->prepare("SELECT password FROM user WHERE username = ?");
    $query->bind_param("s", $username);
    $query->execute();
    $result = $query->get_result();
    $row = $result->fetch_assoc();
    $_SESSION['password'] = $row['password'] ?? '';

    // Get password length and generate asterisks
    $password_length = strlen($_SESSION['password']);
    $password_display = str_repeat('*', $password_length);

    //handles password change
    if (isset($_POST['save_new_password'])) {
        $old_password = $_POST['old_password'];
        $new_password = $_POST['new_password'];
        $confirm_password = $_POST['confirm_password'];
    
        // Verify the old password
        if ($old_password === $_SESSION['password']) {
            //check if password has 8 characters
            if(strlen($new_password) < 8) {
                $password_error = 'Password must contain atleast 8 characters';
            }
            elseif ($new_password === $confirm_password) {
                $update_query = $conn->prepare("UPDATE user SET password = ? WHERE username = ?");
                $update_query->bind_param("ss", $new_password, $username);
    
                if ($update_query->execute()) {
                    $_SESSION['password'] = $new_password;
                    $password_success = 'Password updated successfully';
                } else {
                    $password_error = 'Error updating password. Please try again.';
                }
            } else {
                $password_error = 'New passwords do not match';
            }
        } else {
            $password_error = 'Old password is incorrect';
        }
    }
    //handles photo upload
    if (isset($_POST['save_new_image'])) {
        if ($_FILES['image']['error'] === 4) {
            $error = 'Image does not exist';
        } else {
            $file_name = $_FILES['image']['name'];
            $file_size = $_FILES['image']['size'];
            $tmp_name = $_FILES['image']['tmp_name'];
    
            $valid_image_extensions = ['jpeg', 'jpg', 'png'];
            $image_extension = pathinfo($file_name, PATHINFO_EXTENSION);
    
            if (!in_array($image_extension, $valid_image_extensions)) {
                $error = 'Invalid image extension';
            } elseif ($file_size > 1000000) {
                $error = 'Image size is too large';
            } else {
                $new_image_name = uniqid() . '.' . $image_extension;
    
                if (move_uploaded_file($tmp_name, 'pfpimg/' . $new_image_name)) {
                    //update image in database
                    $query = "UPDATE user SET image = '$new_image_name' WHERE username = '$username'";
                    if (mysqli_query($conn, $query)) {
                        $success = 'Photo changed successfully';
                        $image = 'pfpimg/' . $new_image_name; //update displayed image path
                        $_SESSION['image'] = $image;
                    } else {
                        echo "<script>alert('Failed to update image in database')</script>";
                    }
                } else {
                    echo "<script>alert('Failed to upload image')</script>";
                }
            }
        }
    }

    //handles email changing
    if (isset($_POST['save_new_email'])) {
        // Validate inputs and update email
        $new_email = $_POST['change_email'] ?? '';
        $confirm_password = $_POST['confirm_password'] ?? '';
    
        if (!empty($new_email) && !empty($confirm_password)) {
            // Validate password and update email in database
            $query = "SELECT password FROM user WHERE username = '$username'";
            $result = mysqli_query($conn, $query);
    
            if ($result && mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                $stored_password = $row['password'];
    
                // Verify password
                if ($confirm_password == $stored_password) {
                    // Update email in database
                    if($new_email != $_SESSION['email']) {
                        $query = "UPDATE user SET email = '$new_email' WHERE username = '$username'";
                        if (mysqli_query($conn, $query)) {
                            // Update session and local variable for displayed email
                            $_SESSION['email'] = $new_email;
                            $email = $new_email; // Update local variable
                            $email_success = 'Email changed successfully';
                        } else {
                            $email_error = 'Failed to update email';
                        }
                    }
                    else{
                        $email_error = "New email can't be similar to old email";
                    }
                } else {
                    $email_error = 'Incorrect password';
                }
            } else {
                $email_error = 'User not found';
            }
        } else {
            $email_error = 'All fields are required';
        }
    }
    if(isset($POST['save new password'])) {

    }
    //handles phone number changing
    if (isset($_POST['save_new_phone_num'])) {
        $new_phone_num = $_POST['change_phone_num'] ?? null;
        $confirm_password = $_POST['confirm_password'] ?? null;

        if (!empty($new_phone_num) && !empty($confirm_password)) {
            $query = "SELECT password FROM user WHERE username = '$username'";
            $result = mysqli_query($conn, $query);

            if ($result && mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                $stored_password = $row['password'];

                if ($confirm_password == $stored_password) {
                    // Check if phone number is valid
                    if (!str_starts_with($new_phone_num, '09')) {
                        $phone_num_error = "Phone number must start with '09'";
                    } elseif (!preg_match('/^\d+$/', $new_phone_num)) {
                        // Check if phone number consists only of numbers
                        $phone_num_error = 'Phone number must only consist of numbers';
                    } elseif (strlen($new_phone_num) != 11) {
                        $phone_num_error = 'Phone number must consist of 11 digits';
                    } elseif ($new_phone_num == $_SESSION['phoneNum']) {
                        $phone_num_error = "New phone number can't be similar to old phone number";
                    } else {
                        // If no error, update the phone number in the database
                        $query = "UPDATE user SET phoneNum = ? WHERE username = ?";
                        $stmt = mysqli_prepare($conn, $query);
                        if ($stmt) {
                            mysqli_stmt_bind_param($stmt, 'ss', $new_phone_num, $username);
                            if (mysqli_stmt_execute($stmt)) {
                                $phone_num_success = 'Phone number changed successfully';
                                $phoneNum = $new_phone_num; // Update displayed phoneNum
                                $_SESSION['phoneNum'] = $new_phone_num;
                            } else {
                                $phone_num_error = 'Failed to update phone number';
                            }
                            mysqli_stmt_close($stmt);
                        } else {
                            $phone_num_error = 'Failed to prepare the database query';
                        }
                    }
                } else {
                    $phone_num_error = 'Incorrect password';
                }
            }
        } else {
            $phone_num_error = 'All fields are required';
        }
    }

    //handles address changing
    if(isset($_POST['save_new_address'])) {
        $new_region = $_POST['region'] ?? '';
        $new_province = $_POST['province'] ?? '';
        $new_city = $_POST['city'] ?? '';
        $new_barangay = $_POST['barangay'] ?? '';
        
        // Fetch current address details
        $query = "SELECT region, province, city, barangay FROM user WHERE username = '$username'";
        $result = mysqli_query($conn, $query);

        $row = mysqli_fetch_assoc($result);
        $current_region = $row['region'];
        $current_province = $row['province'];
        $current_city = $row['city'];
        $current_barangay = $row['barangay'];
    
        // Update query
        $query = "UPDATE user SET region = '$new_region', province = '$new_province', city = '$new_city', barangay = '$new_barangay' WHERE username = '$username'";
        if (mysqli_query($conn, $query)) {
            // Update session variables and local variables
            $_SESSION['region'] = $new_region;
            $_SESSION['province'] = $new_province;
            $_SESSION['city'] = $new_city;
            $_SESSION['barangay'] = $new_barangay;
    
            $region = $new_region;
            $province = $new_province;
            $city = $new_city;
            $barangay = $new_barangay;
    
            $address_success = 'Address changed successfully';
        }
        else {
            $address_error = 'Failed to change address';
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
</head>
<body>
    <?php 
        require('header.php');
    ?>
    <div class="parent">
        <?php
            require('user_sidebar.php');
        ?>
        <div class="user_profile">
            <h1>My Profile</h1>
            <p>Manage and protect your account</p>
            <div class="user_info_container">
                <div class="user_info">
                    <div class="full_name">
                        <p>Name:</p><p><?php echo htmlspecialchars($fname . ' ' . $lname); ?></p>
                    </div>
                    <div class="username">
                        <p>Username: </p><p><?php echo htmlspecialchars($_SESSION['username']); ?></p>
                    </div>
                    <div class="user_email">
                        <p>Email:</p><p><?php echo htmlspecialchars($_SESSION['email']); ?></p><p id="change_email">Change</p>
                    </div>
                    <div class="change_email hidden">
                        <form action="user_profile.php" method="POST">
                            <div class="change_email_input">
                                <p>Enter new email: </p>
                                <input type="email" name="change_email" required>
                            </div>
                            <div class="confirm_password">
                                <p>Enter password:</p>
                                <input type="password" name="confirm_password" required>
                            </div>
                            <input type="submit" name="save_new_email" id="save_new_email" value="Save Changes">
                        </form>               
                    </div>
                    <?php if (!empty($email_error)): ?>
                        <p id="email_error"><?php echo htmlspecialchars($email_error); ?></p>
                    <?php elseif (!empty($email_success)): ?>
                        <p id="email_success"><?php echo htmlspecialchars($email_success); ?></p>
                    <?php endif; ?>
                    <div class="user_password">
                        <p>Password: </p><p><?php echo htmlspecialchars($password_display); ?></p><p id="change_password">Change</p>
                    </div>    
                    <div class="change_password hidden">
                        <form action="user_profile.php" method="POST">
                            <div class="old_password">
                                <p>Enter old password: </p>
                                <input type="password" name="old_password" required>
                            </div>
                            <div class="new_password">
                                <p>Enter new password:</p>
                                <input type="password" name="new_password" required>
                            </div>
                            <div class="confirm_password">
                                <p>Enter password:</p>
                                <input type="password" name="confirm_password" required>
                            </div>
                            <input type="submit" name="save_new_password" id="save_new_password" value="Save Changes">
                        </form>               
                    </div>
                    <?php if (!empty($password_error)): ?>
                        <p id="password_error"><?php echo htmlspecialchars($password_error); ?></p>
                    <?php elseif (!empty($password_success)): ?>
                        <p id="password_success"><?php echo htmlspecialchars($password_success); ?></p>
                    <?php endif; ?>
                    <div class="phone_num">
                        <p>Phone number:</p><p><?php echo htmlspecialchars($_SESSION['phoneNum']); ?></p><p id="change_num">Change</p>
                    </div>
                    <div class="change_phone_num hidden">
                        <form action="user_profile.php" method="POST">
                            <div class="change_phone_num_input">
                                <p>Enter new phone number: </p>
                                <input type="tel" name="change_phone_num" required>
                            </div>
                            <div class="confirm_password">
                                <p>Enter password:</p>
                                <input type="password" name="confirm_password" required>
                            </div>
                            <input type="submit" name="save_new_phone_num" id="save_new_phone_num" value="Save Changes">
                        </form>
                    </div>
                    <?php if (!empty($phone_num_error)): ?>
                        <p id="phone_num_error"><?php echo htmlspecialchars($phone_num_error); ?></p>
                    <?php elseif (!empty($phone_num_success)): ?>
                        <p id="phone_num_success"><?php echo htmlspecialchars($phone_num_success); ?></p>
                    <?php endif; ?>
                    <div class="address">
                        <p>Address:</p>
                        <p><?php echo htmlspecialchars("$barangay, $city, $province, region $region"); ?></p><p id="change_address">Change</p>
                    </div>
                    <div class="address_info hidden">
                        <form action="user_profile.php" method="POST">
                            <div class="region_province">
                                <div class="region">
                                    <p>Region:</p>
                                    <input type="text" name="region" id="region" required>
                                </div>
                                <div class="province">
                                    <p>Province:</p>
                                    <input type="text" name="province" id="province" required>
                                </div>
                            </div>
                            <div class="city_barangay">
                                <div class="city">
                                    <p>City:</p>
                                    <input type="text" name="city" id="city" required>
                                </div>
                                <div class="barangay">
                                    <p>Barangay:</p>
                                    <input type="text" name="barangay" id="barangay" required>
                                </div>
                            </div>
                            <input type="submit" name="save_new_address" id="save_new_address" value="Save Changes">
                        </form>
                    </div>
                    <?php if (!empty($address_error)): ?>
                        <p id="address_error"><?php echo htmlspecialchars($address_error); ?></p>
                    <?php elseif (!empty($address_success)): ?>
                        <p id="address_success"><?php echo htmlspecialchars($address_success); ?></p>
                    <?php endif; ?>
                </div>
                <div class="profile_pic">
                    <img src="<?php echo htmlspecialchars($image); ?>" id="profile_pic">
                    <form action="user_profile.php" method="POST" enctype="multipart/form-data">
                        <div class="select_image">
                            <input type="file" name="image" id="file_input" style="display: none;">
                            <label for="file_input" id="custom_file_label">Select Image</label>
                        </div>
                        <p>File size: maximum 1 MB</p>
                        <p>File extension: .JPEG, .JPG, .PNG</p>
                        <p id="error"><?php echo htmlspecialchars($error); ?></p>
                        <p id="success"><?php echo htmlspecialchars($success); ?></p>
                        <div class="save">
                            <input type="submit" name="save_new_image" id="save" value="Change Photo">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php 
        require('footer.php');
    ?>                 
    <script>
            document.addEventListener('DOMContentLoaded', () => {
                // Toggle visibility of email change section
                document.getElementById('change_email').addEventListener('click', function() {
                    const changeEmailSection = document.querySelector('.change_email');
                    changeEmailSection.classList.toggle('hidden');
                });

                // Initially hide email change section
                const changeEmailSection = document.querySelector('.change_email');
                changeEmailSection.classList.add('hidden');

                // Toggle visibility of phone number change section
                document.getElementById('change_num').addEventListener('click', function() {
                    const changePhoneNumSection = document.querySelector('.change_phone_num');
                    changePhoneNumSection.classList.toggle('hidden');
                });

                // Initially hide phone number change section
                const changePhoneNumSection = document.querySelector('.change_phone_num');
                changePhoneNumSection.classList.add('hidden');

                // Toggle visibility of address change section
                document.getElementById('change_address').addEventListener('click', function() {
                    const changeEmailSection = document.querySelector('.address_info');
                    changeEmailSection.classList.toggle('hidden');
                });

                // Toggle visibility of password change section
                document.getElementById('change_password').addEventListener('click', function() {
                    const changePasswordSection = document.querySelector('.change_password');
                    changePasswordSection.classList.toggle('hidden');
                });

                // Initially hide phone number change section
                const changePasswordSection = document.querySelector('.change_password');
                changePasswordSection.classList.add('hidden');
            });   
    </script>
</body>
</html>