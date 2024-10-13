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
    if (isset($_POST['cancel_order'])) {
        $product_id = $_POST['product_id'];
        $username = $_SESSION['username'];
    
        $sql = "DELETE FROM `order` WHERE id = ? AND order_user = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("is", $product_id, $username);
        
        if ($stmt->execute()) {
            echo "<script>alert('Product removed successfully'); window.location.href = 'user_orders.php';</script>";
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
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
        <div class="user_orders">
        <div class="user_cart_top">
                <div>
                    <h1>My Orders</h1>
                    <p>Manage your orders</p>
                </div>
            </div>
            <div class="display_products">
            <?php
                $usern = $_SESSION['username'];

                $query = "SELECT * FROM `order` WHERE order_user = ?";
                $stmt = $conn->prepare($query);
                $stmt->bind_param("s", $usern);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    $select_query="SELECT * FROM `order` WHERE order_user='$_SESSION[username]'";
                    $result_query=mysqli_query($conn,$select_query);
                    while($display=mysqli_fetch_assoc($result_query)){
                        $product_id =$display['proditem_id'];
                        $item_qty = $display['order_qty'];
                        $item_size = $display['order_size'];
                        $item_color = $display['order_color'];
                        $cart_id = $display['id'];

                        $product_query = "SELECT * FROM `product` WHERE product_id='$product_id'";
                        $cart_query=mysqli_query($conn,$product_query);
                        while($row=mysqli_fetch_assoc($cart_query)){
                            $item_id =$row['product_id'];
                            $item_category=$row['product_category'];
                            $item_name =$row['product_name'];
                            $item_img =$row['product_img'];
                            $item_price =$row['product_price'];
                            
                            $total = $item_price * $item_qty;
                            $formatted_price = number_format($total);
                            
                
                            echo "
                                <a href='viewmore.php?id=$item_id' id='viewMore' name='viewMore'>
                                    <div class='prod_display'>  
                                        <div class='prod_info'>
                                            <div class='prod_image'>
                                                <img src='./products_img/$item_img' alt='Product Image'>
                                            </div>
                                            <div class='prod_name'>
                                                <p id='name'>$item_name</p>
                                                <p id='categ'>$item_category</p>
                                            </div>
                                        </div>
                                        <div class='cart_var_qty'>
                                            <div class='cart_var'>
                                                <p>Variation:</p>
                                                <p>$item_size</p>
                                                <p>$item_color</p>
                                            </div>
                                            <div class='cart_qty'>
                                                <p>Quantity:</p>
                                                <p>$item_qty</p>
                                            </div>
                                        </div>
                                        <div class='prod_button'>
                                            <div class='remove_prod'>
                                                <form method='POST'>
                                                        <input type='hidden' name='product_id' value='$cart_id'>
                                                        <input type='submit' name='cancel_order' class='remove_prod_button' value='Cancel Order'>
                                                    </form>
                                                <div class='prod_price'>
                                                    <p>&#8369;$formatted_price</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>";
                        }      
                    }
                } else {
                    echo "<p id='prod_message'>No products found for this user</p>";
                }
                $stmt->close();
            ?>
            </div>
        </div>
    </div>
    <?php
        require('footer.php');
    ?>
</body>
</html>