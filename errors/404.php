<?php
include_once '../config/global.php';
checkLogin();
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
    include APP_URL .'assets/inc/header.php';
    ?>

    <div class="content">
        <div class="mainForm width65">
            <?php
            Debug::error(404);
            ?>
        </div>
    </div>
</div>
<?php
include '../assets/inc/footer.php';
?>
</body>
</html>