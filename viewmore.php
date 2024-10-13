<?php
    require_once 'reglog_config.php';
    session_start();

    if (isset($_POST['add_to_cart'])){
        $prod_id = $_GET['id'];
        $cart_user=$_SESSION['username']; 
        $cart_qty = $_POST['qty'];
        $cart_size = $_POST['item_size'];
        $cart_color = $_POST['item_color'];

        $cart = "INSERT INTO cart VALUES('','$prod_id','$cart_qty','$cart_size','$cart_color','$cart_user')"; 

        if (mysqli_query($conn, $cart)){
            header('location:index.php');
        }else{
            echo "Error: " .$sql . "<br>" .mysqli_error($conn);
        }
    }

    if (isset($_POST['buy_now'])){
        $prod_id = $_GET['id'];
        $cart_user=$_SESSION['username']; 
        $cart_qty = $_POST['qty'];
        $cart_size = $_POST['item_size'];
        $cart_color = $_POST['item_color'];

        $order = "INSERT INTO `order` VALUES('','$prod_id','$cart_size','$cart_color','$cart_qty','$cart_user')"; 

        if (mysqli_query($conn, $order)){
            header('location:index.php');
        }else{
            echo "Error: " .$sql . "<br>" .mysqli_error($conn);
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="icon" type="image/x-icon" href="asset/logo.png"> <!-- icon -->
</head>
<body>
    <?php 
        require('header.php');
    ?>
    <div class="center_fullitem">
        <?php
            $view_id = $_GET['id'];
            $select_query = "SELECT * FROM `product` WHERE product_id='$view_id'";
            $result_query = mysqli_query($conn, $select_query);

            if ($display = mysqli_fetch_assoc($result_query)) {
                $item_category = $display['product_category'];
                $item_id = $display['product_id'];
                $item_name = $display['product_name'];
                $item_info = $display['product_info'];
                $item_img = $display['product_img'];
                $item_price = $display['product_price'];
                $item_size = $display['product_size'];
                $item_color = $display['product_color'];
                $product_owner = htmlspecialchars($display['username'], ENT_QUOTES, 'UTF-8');
                $current_user = $_SESSION['username'];
                $is_owner = ($current_user === $product_owner);

                $formatted_price = number_format($item_price);
                ?>
                <form method='POST'>         
                    <div class='fullitem'>
                        <div class='imgfull'>
                            <img src='./products_img/<?php echo htmlspecialchars($item_img, ENT_QUOTES, 'UTF-8'); ?>' id='imgfull'>
                        </div><br>
                        <div class='descript'>
                            <div class='full_item_top'>
                                <h1><?php echo htmlspecialchars($item_name, ENT_QUOTES, 'UTF-8'); ?></h1>
                                <p id='categ'><?php echo htmlspecialchars($item_category, ENT_QUOTES, 'UTF-8'); ?></p>
                                <p id='price'>&#8369;<?php echo $formatted_price; ?></p>
                            </div>
                            <div class='full_item_mid'>
                                <p id='item_full_info'><?php echo htmlspecialchars($item_info, ENT_QUOTES, 'UTF-8'); ?></p>
                                <div class='size_color'>
                                    <div class='item_size'>
                                        <p>Size: </p>
                                        <select id='item_size' name='item_size' required>                              
                                            <?php foreach (explode(',', $item_size) as $size): ?>
                                                <option value='<?php echo htmlspecialchars($size, ENT_QUOTES, 'UTF-8'); ?>'><?php echo htmlspecialchars($size, ENT_QUOTES, 'UTF-8'); ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class='item_color'>
                                        <p>Color: </p>
                                        <select id='item_color' name='item_color' required>
                                            <?php foreach (explode(',', $item_color) as $color): ?>
                                                <option value='<?php echo htmlspecialchars($color, ENT_QUOTES, 'UTF-8'); ?>'><?php echo htmlspecialchars($color, ENT_QUOTES, 'UTF-8'); ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class='item_qty'>
                                        <p>Quantity: </p>
                                        <input type='number' min='1' id='qty' name='qty' value='1' placeholder='quantity'>
                                    </div>
                                </div>
                            </div>
                            <?php if ($is_owner): ?>
                                <p>You cannot buy your own product.</p>
                            <?php else: ?>
                                <div class='acc_to_button'>
                                    <input type='submit' name='add_to_cart' id='add_to_cart' value='Add to cart'>
                                    <input type='submit' name='buy_now' id='buy_now' value='Buy Now'>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </form>
                <?php
            } else {
                echo "<p>Product not found.</p>";
            }
        ?>
    </div>
    <?php
        require('footer.php');
    ?>
</body>
</html>