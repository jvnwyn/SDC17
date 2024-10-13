<?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    require('reglog_config.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="icon" type="image/x-icon" href="asset/logo.png"> <!-- icon -->
    <title>SDC17</title>
</head>
<body>
    <div>
        <?php 
            require('header.php');
        ?>   
    </div> 
    <div>
        <?php
            require('categories.php');
        ?>
    </div>
    <div class="disc">
        <div class="title_name">
            <p>Daily Discover</p>
        </div>
        <div class="center-grid">
            <div class="grid-cont">
                <?php
                $select_query = "SELECT * from `product` order by rand() limit 0,8  ";
                $result_query = mysqli_query($conn,$select_query);
                while($display = mysqli_fetch_assoc($result_query)){
                    $item_id = $display['product_id'];
                    $item_name = $display['product_name'];
                    $item_info = $display['product_info'];
                    $item_img = $display['product_img'];
                    $item_price = $display['product_price']; 
                    $formatted_price = number_format($item_price);

                    // Determine the href based on session status
                    $href = isset($_SESSION['username']) ? "viewmore.php?id=$item_id" : "sign_in.php";
                    echo "          
                        <div class='item'>
                            <a href='$href' id='viewMore' name='viewMore'> 
                            <div class='image'>
                                <img src='./products_img/$item_img' id='image'>
                            </div>
                            <div class='itemname'>
                                <p>$item_name</p>
                            </div>
                            <div class=price>
                                <p id='price'>&#8369;$formatted_price</p>
                            </div>
                            </a>

                        </div>";
                }
                ?>
            </div>
        </div>
    </div>
    <div class="page" id="accessories">
        <div class="title_name" >
            <p>Accessories</p>
        </div>
        <div class="center-grid">
            <div class="move_button" onclick="scrolll()">
                <input type="button" value="<-">
            </div>
            <div class="move_by_button">
                <?php
                $select_query = "SELECT * from `product` WHERE product_category ='Accessories'";
                $result_query = mysqli_query($conn,$select_query);
                while($display = mysqli_fetch_assoc($result_query)){
                    $item_id = $display['product_id'];
                    $item_name = $display['product_name'];
                    $item_info = $display['product_info'];
                    $item_img = $display['product_img'];
                    $item_price = $display['product_price']; 
                    $formatted_price = number_format($item_price);

                    // Determine the href based on session status
                    $href = isset($_SESSION['username']) ? "viewmore.php?id=$item_id" : "sign_in.php";
                    echo "          
                        <div class='item'>
                            <a href='$href' id='viewMore' name='viewMore'> 
                            <div class='image'>
                                <img src='./products_img/$item_img' id='image'>
                            </div>
                            <div class='itemname'>
                                <p>$item_name</p>
                            </div>
                            <div class=price>
                                <p id='price'>&#8369;$formatted_price</p>
                            </div>
                            </a>

                        </div>";
                }
                ?>
            </div>
            <div class="move_button" onclick="scrollr()">
                <input type="button" value="->">
            </div>
        </div>
    </div>
    <div class="page" id="entertainment">
        <div class="title_name" >
            <p>Entertainment</p>
        </div>
        <div class="center-grid">
            <div class="move_button" onclick="scrolll()">
                <input type="button" value="<-">
            </div>
            <div class="move_by_button">
                <?php
                $select_query = "SELECT * from `product` WHERE product_category ='Entertainment'";
                $result_query = mysqli_query($conn,$select_query);
                while($display = mysqli_fetch_assoc($result_query)){
                    $item_id = $display['product_id'];
                    $item_name = $display['product_name'];
                    $item_info = $display['product_info'];
                    $item_img = $display['product_img'];
                    $item_price = $display['product_price']; 
                    $formatted_price = number_format($item_price);

                    // Determine the href based on session status
                    $href = isset($_SESSION['username']) ? "viewmore.php?id=$item_id" : "sign_in.php";
                    echo "          
                        <div class='item'>
                            <a href='$href' id='viewMore' name='viewMore'> 
                            <div class='image'>
                                <img src='./products_img/$item_img' id='image'>
                            </div>
                            <div class='itemname'>
                                <p>$item_name</p>
                            </div>
                            <div class=price>
                                <p id='price'>&#8369;$formatted_price</p>
                            </div>
                            </a>

                        </div>";
                }
                ?>
            </div>
            <div class="move_button" onclick="scrollr()">
                <input type="button" value="->">
            </div>
        </div>
    </div>
    <div class="page" id="health">
        <div class="title_name" >
            <p>Health & Personal Care</p>
        </div>
        <div class="center-grid">
            <div class="move_button" onclick="scrolll()">
                <input type="button" value="<-">
            </div>
            <div class="move_by_button">
                <?php
                $select_query = "SELECT * from `product` WHERE product_category ='Health & Personal Care'";
                $result_query = mysqli_query($conn,$select_query);
                while($display = mysqli_fetch_assoc($result_query)){
                    $item_id = $display['product_id'];
                    $item_name = $display['product_name'];
                    $item_info = $display['product_info'];
                    $item_img = $display['product_img'];
                    $item_price = $display['product_price']; 
                    $formatted_price = number_format($item_price);

                    // Determine the href based on session status
                    $href = isset($_SESSION['username']) ? "viewmore.php?id=$item_id" : "sign_in.php";
                    echo "          
                        <div class='item'>
                            <a href='$href' id='viewMore' name='viewMore'> 
                            <div class='image'>
                                <img src='./products_img/$item_img' id='image'>
                            </div>
                            <div class='itemname'>
                                <p>$item_name</p>
                            </div>
                            <div class=price>
                                <p id='price'>&#8369;$formatted_price</p>
                            </div>
                            </a>

                        </div>";
                }
                ?>
            </div>
            <div class="move_button" onclick="scrollr()">
                <input type="button" value="->">
            </div>
        </div>
    </div>
    <div class="page" id="appliances">
        <div class="title_name">
            <p>Home Appliances</p>
        </div>
        <div class="center-grid">
            <div class="move_button" onclick="scrolll()">
                <input type="button" value="<-">
            </div>
            <div class="move_by_button">
                <?php
                $select_query = "SELECT * from `product` WHERE product_category ='Home Appliance'";
                $result_query = mysqli_query($conn,$select_query);
                while($display = mysqli_fetch_assoc($result_query)){
                    $item_id = $display['product_id'];
                    $item_name = $display['product_name'];
                    $item_info = $display['product_info'];
                    $item_img = $display['product_img'];
                    $item_price = $display['product_price']; 
                    $formatted_price = number_format($item_price);

                    // Determine the href based on session status
                    $href = isset($_SESSION['username']) ? "viewmore.php?id=$item_id" : "sign_in.php";
                    echo "          
                        <div class='item'>
                            <a href='$href' id='viewMore' name='viewMore'> 
                            <div class='image'>
                                <img src='./products_img/$item_img' id='image'>
                            </div>
                            <div class='itemname'>
                                <p>$item_name</p>
                            </div>
                            <div class=price>
                                <p id='price'>&#8369;$formatted_price</p>
                            </div>
                            </a>

                        </div>";
                }
                ?>
            </div>
            <div class="move_button" onclick="scrollr()">
                <input type="button" value="->">
            </div>
        </div>
    </div>
    <div class="page" id="makeup">
        <div class="title_name" >
            <p>Makeup & Fragrances</p>
        </div>
        <div class="center-grid">
            <div class="move_button" onclick="scrolll()">
                <input type="button" value="<-">
            </div>
            <div class="move_by_button">
                <?php
                $select_query = "SELECT * from `product` WHERE product_category ='Makeup & Fragrances'";
                $result_query = mysqli_query($conn,$select_query);
                while($display = mysqli_fetch_assoc($result_query)){
                    $item_id = $display['product_id'];
                    $item_name = $display['product_name'];
                    $item_info = $display['product_info'];
                    $item_img = $display['product_img'];
                    $item_price = $display['product_price']; 
                    $formatted_price = number_format($item_price);

                    // Determine the href based on session status
                    $href = isset($_SESSION['username']) ? "viewmore.php?id=$item_id" : "sign_in.php";
                    echo "          
                        <div class='item'>
                            <a href='$href' id='viewMore' name='viewMore'> 
                            <div class='image'>
                                <img src='./products_img/$item_img' id='image'>
                            </div>
                            <div class='itemname'>
                                <p>$item_name</p>
                            </div>
                            <div class=price>
                                <p id='price'>&#8369;$formatted_price</p>
                            </div>
                            </a>

                        </div>";
                }
                ?>
            </div>
            <div class="move_button" onclick="scrollr()">
                <input type="button" value="->">
            </div>
        </div>
    </div>
    <div class="page" id="mensapp">
        <div class="title_name" >
            <p>Men's Apparel</p>
        </div>
        <div class="center-grid">
            <div class="move_button" onclick="scrolll()">
                <input type="button" value="<-">
            </div>
            <div class="move_by_button">
                <?php
                $select_query = "SELECT * from `product` WHERE product_category ='Mens Apparel'";
                $result_query = mysqli_query($conn,$select_query);
                while($display = mysqli_fetch_assoc($result_query)){
                    $item_id = $display['product_id'];
                    $item_name = $display['product_name'];
                    $item_info = $display['product_info'];
                    $item_img = $display['product_img'];
                    $item_price = $display['product_price']; 
                    $formatted_price = number_format($item_price);

                    // Determine the href based on session status
                    $href = isset($_SESSION['username']) ? "viewmore.php?id=$item_id" : "sign_in.php";
                    echo "          
                        <div class='item'>
                            <a href='$href' id='viewMore' name='viewMore'> 
                            <div class='image'>
                                <img src='./products_img/$item_img' id='image'>
                            </div>
                            <div class='itemname'>
                                <p>$item_name</p>
                            </div>
                            <div class=price>
                                <p id='price'>&#8369;$formatted_price</p>
                            </div>
                            </a>

                        </div>";
                }
                ?>
            </div>
            <div class="move_button" onclick="scrollr()">
                <input type="button" value="->">
            </div>
        </div>
    </div>
    <div class="page" id="shoes">
        <div class="title_name" >
            <p>Men's Shoes</p>
        </div>
        <div class="center-grid">
            <div class="move_button" onclick="scrolll()">
                <input type="button" value="<-">
            </div>
            <div class="move_by_button">
                <?php
                $select_query = "SELECT * from `product` WHERE product_category ='Mens Shoes'";
                $result_query = mysqli_query($conn,$select_query);
                while($display = mysqli_fetch_assoc($result_query)){
                    $item_id = $display['product_id'];
                    $item_name = $display['product_name'];
                    $item_info = $display['product_info'];
                    $item_img = $display['product_img'];
                    $item_price = $display['product_price']; 
                    $formatted_price = number_format($item_price);

                    // Determine the href based on session status
                    $href = isset($_SESSION['username']) ? "viewmore.php?id=$item_id" : "sign_in.php";
                    echo "          
                        <div class='item'>
                            <a href='$href' id='viewMore' name='viewMore'> 
                            <div class='image'>
                                <img src='./products_img/$item_img' id='image'>
                            </div>
                            <div class='itemname'>
                                <p>$item_name</p>
                            </div>
                            <div class=price>
                                <p id='price'>&#8369;$formatted_price</p>
                            </div>
                            </a>

                        </div>";
                }
                ?>
            </div>
            <div class="move_button" onclick="scrollr()">
                <input type="button" value="->">
            </div>
        </div>
    </div>
    <div class="page" id="mobile">
        <div class="title_name" >
            <p>Mobiles & Gadgets</p>
        </div>
        <div class="center-grid">
            <div class="move_button" onclick="scrolll()">
                <input type="button" value="<-">
            </div>
            <div class="move_by_button">
                <?php
                $select_query = "SELECT * from `product` WHERE product_category ='Mobile & Gadgets'";
                $result_query = mysqli_query($conn,$select_query);
                while($display = mysqli_fetch_assoc($result_query)){
                    $item_id = $display['product_id'];
                    $item_name = $display['product_name'];
                    $item_info = $display['product_info'];
                    $item_img = $display['product_img'];
                    $item_price = $display['product_price']; 
                    $formatted_price = number_format($item_price);

                    // Determine the href based on session status
                    $href = isset($_SESSION['username']) ? "viewmore.php?id=$item_id" : "sign_in.php";
                    echo "          
                        <div class='item'>
                            <a href='$href' id='viewMore' name='viewMore'> 
                            <div class='image'>
                                <img src='./products_img/$item_img' id='image'>
                            </div>
                            <div class='itemname'>
                                <p>$item_name</p>
                            </div>
                            <div class=price>
                                <p id='price'>&#8369;$formatted_price</p>
                            </div>
                            </a>

                        </div>";
                }
                ?>
            </div>
            <div class="move_button" onclick="scrollr()">
                <input type="button" value="->">
            </div>
        </div>
    </div>
    <div class="page" id="womensapp">
        <div class="title_name" >
            <p>Women's Apparel</p>
        </div>
        <div class="center-grid">
            <div class="move_button" onclick="scrolll()">
                <input type="button" value="<-">
            </div>
            <div class="move_by_button">
                <?php
                $select_query = "SELECT * from `product` WHERE product_category ='Womens Apparel'";
                $result_query = mysqli_query($conn,$select_query);
                while($display = mysqli_fetch_assoc($result_query)){
                    $item_id = $display['product_id'];
                    $item_name = $display['product_name'];
                    $item_info = $display['product_info'];
                    $item_img = $display['product_img'];
                    $item_price = $display['product_price']; 
                    $formatted_price = number_format($item_price);

                    // Determine the href based on session status
                    $href = isset($_SESSION['username']) ? "viewmore.php?id=$item_id" : "sign_in.php";
                    echo "          
                        <div class='item'>
                            <a href='$href' id='viewMore' name='viewMore'> 
                            <div class='image'>
                                <img src='./products_img/$item_img' id='image'>
                            </div>
                            <div class='itemname'>
                                <p>$item_name</p>
                            </div>
                            <div class=price>
                                <p id='price'>&#8369;$formatted_price</p>
                            </div>
                            </a>

                        </div>";
                }
                ?>
            </div>
            <div class="move_button" onclick="scrollr()">
                <input type="button" value="->">
            </div>
        </div>
    </div>
    <div class="itembuttons">
        <a href="#"><img src="asset/logo.png" alt="logo" height="60" width="60"></a>
    </div>
    <div>
        <?php
            require('footer.php');
        ?>
    </div>
    <script src="search.js"></script>
    <script src="movebutton.js"></script>
</body>
</html>