<?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    require('reglog_config.php');

    $image_error = '';

    if(isset($_POST['add_product'])) {
        $item_name = $_POST['item_name'];
        $description = $_POST['description'];
        $category = $_POST['category'];
        $price = $_POST['price'];
        $size = $_POST['size'];
        $color = $_POST['color'];
        $username = $_SESSION['username'];

        $prod_img = $_FILES['prod_image']['name'];
        $tmp_name_img = $_FILES['prod_image']['tmp_name'];

        $valid_image_extensions = ['jpeg', 'jpg', 'png'];
        $image_extension = pathinfo($prod_img, PATHINFO_EXTENSION);

        if (!in_array($image_extension, $valid_image_extensions)) {
            $image_error = 'Invalid image extension';
        }
        else {
            $new_image_name = uniqid() . '.' . $image_extension;
    
            if (move_uploaded_file($tmp_name_img, 'products_img/' . $new_image_name)) {
                //update image in database
                $sql = "INSERT INTO product VALUES ('','$item_name','$description','$new_image_name','$category','$price', '$size', '$color', '$username')";
    
                if (mysqli_query($conn, $sql)) {
                    $success = 'Photo changed successfully';
                    $image = 'products_img/' . $new_image_name; //update displayed image path
                    $_SESSION['product_img'] = $image;
                } else {
                    echo "<script>alert('Failed to update image in database')</script>";
                }
            } else {
                echo "<script>alert('Failed to upload image')</script>";
            }
        }
        
         
    }
    if (isset($_POST['remove_product'])) {
        $product_id = $_POST['product_id'];
        $username = $_SESSION['username'];
    
        $sql = "DELETE FROM product WHERE product_id = ? AND username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("is", $product_id, $username);
    
        if ($stmt->execute()) {
            echo "<script>alert('Product removed successfully'); window.location.href = 'user_products.php';</script>";
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    }

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
    <link rel="icon" type="image/x-icon" href="asset/logo.png"> <!-- icon -->
    <style>
        textarea::placeholder {
            color: white;
        }
    </style>
</head>
<body>
    <?php
        require('header.php');
    ?>
    <div class="parent">
        <?php
            require('user_sidebar.php');
        ?>
        <div class="user_products">
            <div class="user_prodcontent">
                <div>
                    <h1>My Products</h1>
                    <p>Manage your products</p>
                </div>  
                <div class="itemButton">
                    <input type="button" id="addItem" name="addItem" value="Add Item">
                </div>
            </div>
            <p id="image_error"><?php echo $image_error ;?> </p>
            <div class="add_item hidden">
                <form action="user_products.php" method="POST" enctype="multipart/form-data">
                    <div class="prod_img_container">
                        <div class="prod_image">
                            <img src="asset/default_product_image.png" >
                        </div>
                        <div class="item_image">
                            <input type="file" name="prod_image" id="item_image" required>
                            <label for="item_image" class="item_image_label">Select Image</label>
                        </div>
                    </div>
                    <div class="prod_info_container">
                        <div class="item_name">
                            <p>Item name:</p>
                            <input type="text" name="item_name" id="item_name" autocomplete="off" required>
                        </div>
                        <div class="description">
                            <p>Description:</p>
                            <textarea name="description" row="4" autocomplete="off" required></textarea>
                        </div>
                        <div class="category_price">
                            <div class="category">
                                <p>Category:</p>  
                                <select id="category" name="category">
                                    <option value="Accessories" id="accessories" selected>Accessories</option>
                                    <option value="Entertainment" id="entertainment">Entertainment</option>
                                    <option value="Health & Personal Care" id="health_&_personal_care">Health & Personal Care</option>
                                    <option value="Home Appliance" id="home_appliances">Home Appliances</option>
                                    <option value="Makeup & Fragrances" id="makeup_&_fragrances">Makeup & Fragrances</option>
                                    <option value="Mens Apparel" id="mens_apparel">Men's Apparel</option>
                                    <option value="Mens Shoes" id="mens_shoes">Men's Shoes</option>
                                    <option value="Mobile & Gadgets" id="mobiles_&_gadgets">Mobile & Gadgets</option>
                                    <option value="Womens Apparel" id="womens_apparel">Women's Apparel</option>
                                </select>
                            </div>
                            <div class="price">
                                <p>Price: </p>
                                <input type="number" name="price" id="price" autocomplete="off" required>
                            </div>
                        </div>
                        <div class="size_color">
                                <div class="size">
                                    <p>Size:</p>
                                    <input type="text" name="size" placeholder="Comma separated" autocomplete="off" required>
                                </div>
                                <div class="color">
                                    <p>Color:</p>
                                    <input type="text" name="color" placeholder="Comma separated" autocomplete="off" required>
                                </div>
                            </div>
                        <div class="add_product">
                            <input type="submit" name="add_product" value="Add Product" id="add_product">
                        </div>
                    </div>
                </form>
            </div>
            <div class="display_products">
            <?php
                $username = $_SESSION['username'];

                $query = "SELECT * FROM product WHERE username = ?";
                $stmt = $conn->prepare($query);
                $stmt->bind_param("s", $username);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    while ($display = $result->fetch_assoc()) {
                        $product_id = htmlspecialchars($display['product_id']);
                        $name = htmlspecialchars($display['product_name']);
                        $info = htmlspecialchars($display['product_info']);
                        $image = htmlspecialchars($display['product_img']);
                        $categ = htmlspecialchars($display['product_category']);
                        $prod_price = htmlspecialchars($display['product_price']);
                        $formatted_price = number_format($prod_price);

                        echo "
                            <a href='viewmore.php?id=$product_id' id='display_prod_info'>
                                <div class='prod_display'>
                                    <div class='prod_info'>
                                        <div class='prod_image'>
                                            <img src='./products_img/$image' alt='Product Image'>
                                        </div>
                                        <div class='prod_name'>
                                            <p id='name'>$name</p>
                                            <p id='categ'>$categ</p>
                                        </div>
                                    </div>
                                    <div class='prod_button'>
                                        <div class='edit_product'>
                                            <a href='edit_product.php?id=$product_id''><button class='edit_prod_button'>Edit Product</button></a>
                                        </div>
                                        <div class='remove_prod'>
                                            <form method='POST'>
                                                    <input type='hidden' name='product_id' value='$product_id'>
                                                    <input type='submit' name='remove_product' class='remove_prod_button' value='Remove Product'>
                                                </form>
                                            <div class='prod_price'>
                                                <p>&#8369;$formatted_price</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        ";
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
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Toggle add item visibility
            const addItemButton = document.getElementById('addItem');
            const addItemSection = document.querySelector('.add_item');

            addItemButton.addEventListener('click', () => {
                addItemSection.classList.toggle('hidden');
            });

            // Initially hide add item section
            addItemSection.classList.add('hidden');
        });
    </script>
</body>
</html>