<?php 
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    // Default image path
    $default_image = 'asset/default_pfp.jpg';

    // Determine the profile image path
    $image_path = isset($_SESSION['image']) ? $_SESSION['image'] : $default_image;

    // Determine the link based on session status
    $link = isset($_SESSION['username']) ? 'user_profile.php' : 'sign_in.php';

    //checks if the user is logged in
    $cart_link = isset($_SESSION['username']) ? 'user_cart.php' : 'sign_in.php';

    // Default username text
    $default_username = 'Guest';

    // Determine the username to display
    $username_display = isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username'], ENT_QUOTES, 'UTF-8') : $default_username;

    // Count the number of items in the cart for the current user
    $item_count = 0;
    if (isset($_SESSION['username'])) {
        $usern = $_SESSION['username'];
        $count_query = "SELECT COUNT(*) as item_count FROM cart WHERE cart_user = ?";
        $stmt = $conn->prepare($count_query);
        $stmt->bind_param("s", $usern);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            $item_count = $row['item_count'];
        }
        $stmt->close();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="icon" type="image/x-icon" href="asset/logo.png"> <!-- icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> <!-- font awesome icon -->
    <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'> <!-- Poppins Font -->
    <title>SDC17</title>

</head>
<body>
    <div class="nav">
        <a href="index.php" id="user_profile"><img src="asset/logo.png" alt="logo" height="60" width="60"></a>
        <div class="search-container">
            <form action="#">
                <input type="text" placeholder="Search shop1217" id="searchbar" onkeyup="search()">
                <button type="submit"><i class="fa fa-search"></i></button>
            </form>
        </div>
        <div class="menu">
            <a href="<?php echo $link; ?>" id="sign_in">
                <img src="<?php echo htmlspecialchars($image_path, ENT_QUOTES, 'UTF-8'); ?>" height="30" width="30">
                <p><?php echo $username_display; ?></p>
            </a>
            <div class="cart">
                <a href="<?php echo $cart_link; ?>" id="cart"><i class="fa fa-shopping-cart" id="shopping-cart"></i><h5><?php echo $item_count; ?></h5></a> 
            </div>
        </div>
    </div>
</body>
</html>