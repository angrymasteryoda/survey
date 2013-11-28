<header>
    <h1>Survey Chimp</h1>
</header>
<nav>
    <a class="links" href="<?php echo APP_URL?>templates/">Home</a>

    <?php
    $loggedIn = @checkLogin(false);
    $isAdmin = Auth::checkPermissions( ADMIN_RIGHTS );

    if ( $loggedIn ) {
        echo '<a class="links" href="'.APP_URL.'templates/surveyListing.php">Surveys</a>';
    }
    else {
        echo '<a class="links" href="'.APP_URL.'templates/login.php">Login</a>';
        echo '<a class="links" href="'.APP_URL.'back/login.php">Admin Login</a>';
    }
    ?>


    <span class="floatright clearfix">
    <?php
    if ( $loggedIn ) {
        echo 'Hello ' . $_SESSION['username'];
        if ( $isAdmin ) {
            echo '<a href="' . APP_URL . 'back/" class="margin5_right">Admin</a>';
        }
        echo '<a href="' . APP_URL . 'templates/logout.php" class="margin5_right">Logout</a>';
    }
    else {
    }
//    if ( isset($_SESSION['time']) ) {
//        if ($_SESSION['time'] + 10 * 60 > time()) {
//            if( !empty( $_SESSION['username'] )){
//                echo 'Hello ' . $_SESSION['username'];
//                echo '<a href="' . APP_URL . 'templates/logout.php" class="margin5_right">Logout</a>';
//            }
//        }
//        else{
//            unset( $_SESSION['time'] );
//            unset( $_SESSION['username'] );
//        }
//    }
    ?>
    </span>
</nav>