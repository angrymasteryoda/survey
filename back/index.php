<?php
include_once '../config/global.php';
checkLogin()
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
        <div class="backIndex">
            Stuff you can do

            <div>
                <a href="<?php echo APP_URL?>back/users.php">Edit Users</a><br>
                <a href="<?php echo APP_URL?>back/createSurvey.php">create Survey</a><br>
            </div>
        </div>
    </div>
</div>
<?php
include '../assets/inc/footer.php';
?>
</body>
</html>