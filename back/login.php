<?php
include_once '../config/global.php';
if ( checkLogin(false) ) {
    if ( Auth::checkPermissions(ADMIN_RIGHTS) ) {
        header('Location:' . APP_URL . 'back/');
    }
}
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
        <form class="loginForm mainForm adminLogin">
            <h1>Log In to Admin Section</h1>
            <p id="errors"></p>
            <p id="Temp"> </p>
            <p>
                <label>Username
                    <input type="text" name="username" id="login" placeholder="Username" data-type="username"/>
                </label>
            </p>
            <p>
                <label>Password
                    <input type="password" name="password" id="password" placeholder="Password" value="Risher10" data-type="complex-password"/>
                </label>
            </p>
            <p>
                <input type="submit" class="submit" name="submit" value="Log In">
            </p>
        </form>
    </div>
</div>
<?php
include '../assets/inc/footer.php';
?>
</body>
</html>