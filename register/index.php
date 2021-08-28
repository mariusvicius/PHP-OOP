<?php
declare(strict_types = 1);

define( 'ABSPATH', dirname( __FILE__ ) . '/' );

include ABSPATH.'includes/autoload.php';

$registerView = new Register\RegisterView();

?>
<!DOCTYPE html>
<html>
    <head>
        <title>Autoparko registratūra</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="shortcut icon" href="<?php echo baseurl(); ?>assets/images/icon.png">
        <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;700;800&display=swap" rel="stylesheet"> 
        <link rel="stylesheet" href="<?php echo baseurl(); ?>assets/css/styles.css">
    </head>
    <body>
        <header>
            <a class="logo" href="">
                <img src="<?php echo baseurl(); ?>assets/images/logo.png" alt="" />
            </a>
        </header>
        <main>
            <?php
                if(file_exists('includes/classes/Database/config.php')){
                    include_once ABSPATH.'pages/home.php'; 
                }else{
                    include_once ABSPATH.'pages/install.php'; 
                }
            ?>
        </main>
        <footer>
            <p>2021 agam</p>
        </footer>
        <div id="dialog" class="dialog">
            <div class="dialog-container">
                <div id="dialog-close">x</div>
                <div id="dialog-content" class="dialog-content"></div>
            </div>
            <div id="dialog-bg" class="dialog-bg"></div>
        </div>
        <?php if(file_exists('includes/classes/Database/config.php')){ ?>
            <script src='<?php echo baseurl(); ?>assets/js/script.js'></script> 
        <?php } ?>
    </body>
</html>