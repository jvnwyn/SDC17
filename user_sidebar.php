<?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    require('reglog_config.php');

    if (isset($_POST['logout'])) {
        $_SESSION = array();
    
        // Destroy the session
        session_destroy();
        
        header("Location: sign_in.php");
        exit();
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SDC17</title>
    <style>

        .profile {
            display: flex;
            align-items: center;
            gap: 8px;
        }
        ul img {
            border-radius: 50%;
        }
    </style>
</head>
<body>
    <div class="sidebar_container">
        <ul id="sidebar">
            <div class="profile">
                <a href="user_profile.php">
                    <img src="<?php echo $_SESSION['image'];?>" height="50" width="50" id="profile_pic">
                    <h3><?php echo $_SESSION['username'];?></h3>
                </a>
            </div>
            <li><a href="user_profile.php">My Account</a></li>
            <?php if ($_SESSION['user'] === 'business'): ?>
                <li><a href="user_products.php">My Products</a></li>
            <?php endif; ?>
            <li><a href="user_cart.php">My Cart</a></li>
            <li><a href="user_orders.php">My Orders</a></li>
            <li><form action="user_profile.php" method="POST">
                <input type="submit" name="logout" id="logout" value="Logout">
            </form></li>
        </ul>
    </div>
    
</body>
</html>