<?php
include_once '../config/global.php';
logout();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php
    include '../assets/inc/meta.php';
    ?>
</head>
<body>
<div id="wrapper">
    <?php
    include APP_URL . 'assets/inc/header.php';
    ?>

    <div class="content">
        <div class="mainForm">
            <p class="pageTitle margin15_bottom">
                Logged out Successfully
            </p>
            <p class="aligncenter margin5_bottom"">
                Redirecting in <span class="countDown">5</span>
            </p>
            <p class="aligncenter">
                <a href="<?php echo APP_URL?>templates/" goto>Click here if you are not redirected</a>
            </p>
        </div>


    </div>
    <?php
    include APP_URL . 'assets/inc/footer.php';
    ?>
</div>
</body>
</html>
