<?php 
    require_once 'reglog_config.php';
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="categories">
            <ul id="cate">
                <li><a href="#accessories">Accesories</a></li>
                <li><a href="#entertainment">Entertainment</a></li>
                <li><a href="#health">Health & Personal Care</a></li>
                <li><a href="#appliances">Home Appliances</a></li>
                <li><a href="#makeup">Makeup & Fragrances</a></li>
                <li><a href="#mensapp">Men's Apparel</a></li>  
                <li><a href="#shoes">Men's Shoes</a></li>
                <li><a href="#mobile">Mobiles & Gadgets</a></li>
                <li><a href="#womensapp">Women's Apparel</a></li>
            </ul>
    </div>
</body>
</html>