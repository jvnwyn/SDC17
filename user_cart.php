<?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    require('reglog_config.php');

    $total = 0;

    if (isset($_POST['logout'])) {
        $_SESSION = array();
    
        // Destroy the session
        session_destroy();
        
        header("Location: sign_in.php");
        exit();
    }

    if (isset($_POST['remove_product'])) {
        $product_id = $_POST['product_id'];
        $username = $_SESSION['username'];
    
        $sql = "DELETE FROM cart WHERE cart_id = ? AND cart_user = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("is", $product_id, $username);
    
        if ($stmt->execute()) {
            header('location: user_cart.php');
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    }
    
    if (isset($_POST['checkout'])) {
        $order_user = $_SESSION['username'];
        
        $myorder_query = "SELECT * FROM cart WHERE cart_user = ?";
        $stmt = $conn->prepare($myorder_query); 
        $stmt->bind_param("s", $order_user);
        $stmt->execute();
        $pass_query = $stmt->get_result();
        
        $myorder = "INSERT INTO `order` (proditem_id, order_size, order_color, order_qty, order_user) VALUES (?, ?, ?, ?, ?)";
        $insert_stmt = $conn->prepare($myorder);
    
        while ($pass = $pass_query->fetch_assoc()) {
            $proditem_id = $pass['prod_id'];
            $order_qty = $pass['cart_qty'];
            $order_size = $pass['cart_size'];
            $order_color = $pass['cart_color'];
    
            $insert_stmt->bind_param("issis", $proditem_id, $order_size, $order_color, $order_qty, $order_user);
    
            if ($insert_stmt->execute()) {
                $sql = "DELETE FROM `cart` WHERE cart_id = ? AND cart_user = ?";
                $delete_stmt = $conn->prepare($sql);
                $cart_id = $pass['cart_id'];
                $delete_stmt->bind_param("is", $cart_id, $order_user);
                
                $delete_stmt->execute();
            } else {
                echo "Error: " . $insert_stmt->error;
            }
        }
        // Close the prepared statements
        $insert_stmt->close();
        $delete_stmt->close();
    }
    // Calculate total price before rendering the HTML
$usern = $_SESSION['username'];
$query = "SELECT * FROM cart WHERE cart_user = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $usern);
$stmt->execute();
$result = $stmt->get_result();

$total = 0;

if ($result->num_rows > 0) {
    while ($display = $result->fetch_assoc()) {
        $product_id = $display['prod_id'];
        $item_qty = $display['cart_qty'];
        $item_size = $display['cart_size'];
        $item_color = $display['cart_color'];
        $cart_id = $display['cart_id'];

        $product_query = "SELECT * FROM `product` WHERE product_id = ?";
        $cart_stmt = $conn->prepare($product_query);
        $cart_stmt->bind_param("i", $product_id);
        $cart_stmt->execute();
        $product_result = $cart_stmt->get_result();

        while ($row = $product_result->fetch_assoc()) {
            $item_id = $row['product_id'];
            $item_category = $row['product_category'];
            $item_name = $row['product_name'];
            $item_img = $row['product_img'];
            $item_price = $row['product_price'];
            $item_total = $item_price * $item_qty;
            $total += $item_total;
        }
        $cart_stmt->close();
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
    <?php require('header.php'); ?>
    <div class="parent">
        <?php require('user_sidebar.php'); ?>
        <div class="user_cart">
            <div class="user_cart_top">
                <div>
                    <h1>My Cart</h1>
                    <p>Manage your cart</p>
                </div>
                <div class="price_submit">
                    <form method="POST">
                        <p>Total: &#8369;<?php echo number_format($total); ?></p>
                        <input type='submit' name='checkout' id='checkout' class='checkout' value='Checkout'>
                    </form>
                </div>
            </div>
            <div class="display_products">
            <?php
                $usern = $_SESSION['username'];
                $query = "SELECT * FROM cart WHERE cart_user = ?";
                $stmt = $conn->prepare($query);
                $stmt->bind_param("s", $usern);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    while ($display = $result->fetch_assoc()) {
                        $product_id = $display['prod_id'];
                        $item_qty = $display['cart_qty'];
                        $item_size = $display['cart_size'];
                        $item_color = $display['cart_color'];
                        $cart_id = $display['cart_id'];

                        $product_query = "SELECT * FROM `product` WHERE product_id = ?";
                        $cart_stmt = $conn->prepare($product_query);
                        $cart_stmt->bind_param("i", $product_id);
                        $cart_stmt->execute();
                        $product_result = $cart_stmt->get_result();

                        while ($row = $product_result->fetch_assoc()) {
                            $item_id = $row['product_id'];
                            $item_category = $row['product_category'];
                            $item_name = $row['product_name'];
                            $item_img = $row['product_img'];
                            $item_price = $row['product_price'];
                            
                            $formatted_price = number_format($item_total);

                            echo "
                                <a href='viewmore.php?id=$item_id' id='viewMore' name='viewMore'>
                                    <div class='prod_display'>  
                                        <div class='prod_info'>
                                            <div class='prod_image'>
                                                <img src='./products_img/" . htmlspecialchars($item_img, ENT_QUOTES, 'UTF-8') . "' alt='Product Image'>
                                            </div>
                                            <div class='prod_name'>
                                                <p id='name'>" . htmlspecialchars($item_name, ENT_QUOTES, 'UTF-8') . "</p>
                                                <p id='categ'>" . htmlspecialchars($item_category, ENT_QUOTES, 'UTF-8') . "</p>
                                            </div>
                                        </div>
                                        <div class='cart_var_qty'>
                                            <div class='cart_var'>
                                                <p>Variation:</p>
                                                <p>" . htmlspecialchars($item_size, ENT_QUOTES, 'UTF-8') . "</p>
                                                <p>" . htmlspecialchars($item_color, ENT_QUOTES, 'UTF-8') . "</p>
                                            </div>
                                            <div class='cart_qty'>
                                                <p>Quantity:</p>
                                                <p>" . htmlspecialchars($item_qty, ENT_QUOTES, 'UTF-8') . "</p>
                                            </div>
                                        </div>
                                        <div class='prod_button'>
                                            <div class='remove_prod'>
                                                <form method='POST'>
                                                    <input type='hidden' name='product_id' value='" . htmlspecialchars($cart_id, ENT_QUOTES, 'UTF-8') . "'>
                                                    <input type='submit' name='remove_product' class='remove_prod_button' value='Remove Product'>
                                                </form>
                                                <div class='prod_price'>
                                                    <p>&#8369;$formatted_price</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>";
                        }
                        $cart_stmt->close();
                    }
                } else {
                    echo "<p id='prod_message'>No products found for this user</p>";
                }
                $stmt->close();
                
            ?>
            </div>
        </div>
    </div>
    <?php require('footer.php'); ?>
</body>
</html>