<?php
include_once '../config/global.php';
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
        <form class="loginForm mainForm">
            <h1>Log In to Take Survey</h1>
            <div class="margin15_bottom aligncenter">Don't have an account register one <a href="<?php echo APP_URL?>templates/signUp.php">here</a></div>
            <p id="errors"></p>
            <p id="Temp"> </p>
            <p>
                <label>Username
                    <input type="text" name="username" id="login" placeholder="Username" data-type="username"/>
                </label>
            </p>
            <p>
                <label>Password
                    <input type="password" name="password" id="password" placeholder="Password" data-type="password"/>
                </label>
            </p>
            <p>
                <input type="button" class="submit" name="submit" value="Log In">
            </p>
        </form>
    </div>
</div>
<?php
include '../assets/inc/footer.php';
?>
</body>
</html>