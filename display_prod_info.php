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
        <div class="display_prod_info">
            <?php
            ?>
        </div>
    </div>
    <?php 
        require('footer.php');
    ?>
</body>
</html>