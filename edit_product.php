<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require('reglog_config.php');

$error = '';
$success = '';
$product = '';

// Fetch product details based on the provided ID
if (isset($_GET['id'])) {
    $view_id = mysqli_real_escape_string($conn, $_GET['id']);
    $select_query = "SELECT * FROM `product` WHERE product_id='$view_id'";
    $result_query = mysqli_query($conn, $select_query);
    $display = mysqli_fetch_assoc($result_query);

    if ($display) {
        $item_category = htmlspecialchars($display['product_category']);
        $item_id = htmlspecialchars($display['product_id']);
        $item_name = htmlspecialchars($display['product_name']);
        $item_info = htmlspecialchars($display['product_info']);
        $item_img = htmlspecialchars($display['product_img']);
        $item_price = htmlspecialchars($display['product_price']);
        $item_size = htmlspecialchars($display['product_size']);
        $item_color = htmlspecialchars($display['product_color']);
        $product_username = htmlspecialchars($display['username']);

        // Check if the logged-in user is the owner of the product
        if ($_SESSION['username'] !== $product_username) {
            $error = "You do not have permission to edit this product.";
        } elseif (isset($_POST['save_changes'])) {
            $new_name = mysqli_real_escape_string($conn, $_POST['item_name']);
            $new_info = mysqli_real_escape_string($conn, $_POST['description']);
            $new_category = mysqli_real_escape_string($conn, $_POST['category']);
            $new_price = mysqli_real_escape_string($conn, $_POST['price']);
            $new_size = mysqli_real_escape_string($conn, $_POST['size']);
            $new_color = mysqli_real_escape_string($conn, $_POST['color']);

            $update_query = "UPDATE product SET product_name='$new_name', product_info='$new_info', product_category='$new_category', product_price='$new_price', product_size='$new_size', product_color='$new_color' WHERE product_id='$item_id'";

            if (!empty($_FILES['image']['name'])) {
                $prod_img = $_FILES['image']['name'];
                $tmp_name_img = $_FILES['image']['tmp_name'];
                $valid_image_extensions = ['jpeg', 'jpg', 'png'];
                $image_extension = pathinfo($prod_img, PATHINFO_EXTENSION);

                if (!in_array($image_extension, $valid_image_extensions)) {
                    $error = 'Invalid image extension';
                } else {
                    $new_image_name = uniqid() . '.' . $image_extension;
                    $destination = 'products_img/' . $new_image_name;

                    if (move_uploaded_file($tmp_name_img, $destination)) {
                        $update_query = "UPDATE product SET product_name='$new_name', product_info='$new_info', product_img='$new_image_name', product_category='$new_category', product_price='$new_price', product_size='$new_size', product_color='$new_color' WHERE product_id='$item_id'";
                    } else {
                        $error = 'Failed to upload image';
                    }
                }
            }

            if (empty($error) && mysqli_query($conn, $update_query)) {
                $success = 'Product updated successfully';
                header("Location: user_products.php");
                exit();
            } else {
                $error = 'Failed to update product in database';
            }
        }
    } else {
        $error = "Product not found.";
    }
} else {
    $error = "No product ID specified.";
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
    <div class="edit_parent">
        <?php if (!empty($item_name) && empty($error)) : ?>
            <div class="edit_item">
                <div class="edit_prod_img">
                    <div class="edit_img">
                        <img src="./products_img/<?php echo $item_img; ?>" alt="Product Image">
                    </div>
                    <div class="edit_img_form">
                        <form action="edit_product.php?id=<?php echo $item_id; ?>" method="POST" enctype="multipart/form-data">
                            <div class="select_image">
                                <input type="file" name="image" id="file_input" style="display: none;">
                                <label for="file_input" id="select_image_label">Select Image</label>
                            </div>
                            <p>File extension: .JPEG, .JPG, .PNG</p>
                            <p id="error"><?php echo htmlspecialchars($error); ?></p>
                            <p id="success"><?php echo htmlspecialchars($success); ?></p>
                    </div>
                </div>
                <div class="edit_prod">
                    <div class="prod_info_container">
                        <div class="item_name">
                            <p>Item name:</p>
                            <input type="text" name="item_name" id="item_name" autocomplete="off" value="<?php echo $item_name; ?>" required>
                        </div>
                        <div class="description">
                            <p>Description:</p>
                            <textarea name="description" rows="4" autocomplete="off" required><?php echo $item_info; ?></textarea>
                        </div>
                        <div class="category_price">
                            <div class="category">
                                <p>Category:</p>
                                <select id="category" name="category">
                                    <option value="Accessories" <?php echo $item_category == 'Accessories' ? 'selected' : ''; ?>>Accessories</option>
                                    <option value="Entertainment" <?php echo $item_category == 'Entertainment' ? 'selected' : ''; ?>>Entertainment</option>
                                    <option value="Health & Personal Care" <?php echo $item_category == 'Health & Personal Care' ? 'selected' : ''; ?>>Health & Personal Care</option>
                                    <option value="Home Appliance" <?php echo $item_category == 'Home Appliance' ? 'selected' : ''; ?>>Home Appliance</option>
                                    <option value="Makeup & Fragrances" <?php echo $item_category == 'Makeup & Fragrances' ? 'selected' : ''; ?>>Makeup & Fragrances</option>
                                    <option value="Mens Apparel" <?php echo $item_category == 'Mens Apparel' ? 'selected' : ''; ?>>Men's Apparel</option>
                                    <option value="Mens Shoes" <?php echo $item_category == 'Mens Shoes' ? 'selected' : ''; ?>>Men's Shoes</option>
                                    <option value="Mobile & Gadgets" <?php echo $item_category == 'Mobile & Gadgets' ? 'selected' : ''; ?>>Mobile & Gadgets</option>
                                    <option value="Womens Apparel" <?php echo $item_category == 'Womens Apparel' ? 'selected' : ''; ?>>Women's Apparel</option>
                                </select>
                            </div>
                            <div class="price">
                                <p>Price:</p>
                                <input type="number" name="price" id="price" autocomplete="off" value="<?php echo $item_price; ?>" required>
                            </div>
                        </div>
                        <div class="size_color">
                            <div class="size">
                                <p>Size:</p>
                                <input type="text" name="size" autocomplete="off" value="<?php echo $item_size; ?>" value="<?php echo $item_size; ?>" required>
                            </div>
                            <div class="color">
                                <p>Color:</p>
                                <input type="text" name="color" autocomplete="off" value="<?php echo $item_color; ?>" value="<?php echo $item_color; ?>" required>
                            </div>
                        </div>
                        <div class="save_changes">
                            <input type="submit" name="save_changes" value="Save Changes" id="save_changes">
                        </div>
                    </div>
                </form>
                </div>
            </div>
        <?php else : ?>
            <p><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>
    </div>
    <?php require('footer.php'); ?>
</body>
</html>
