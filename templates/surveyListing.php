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
            <p class="pageTitle font14pt margin15_bottom">
                Surveys Available to Take
            </p>
            <hr/>
            <table class="width100">
                <tr>
                    <td>Survey <?php echo Core::sortIcons(1)?></td>
                    <td>Taken <?php echo Core::sortIcons(2)?></td>
                    <td class="width25 aligncenter">Take</td>
                    <td class="width25 aligncenter">Results</td>
                </tr>
                <?php
                $collection = loadDB('surveys');

                $pageData = Core::getPageData('surveys');

                switch(  ( (empty($_GET['o'])) ? ('') : ($_GET['o']) ) ){
                    case 1:
                        $sort = 'title';
                        break;
                    case 2:
                        $sort = 'details.taken';
                        break;
                    default:
                        $sort = 'title';
                }

                $ob = intval( ( (empty($_GET['ob'])) ? (1) : ($_GET['ob']) ) );

                $datas = $collection->find()->limit( $pageData['ipp'] )->skip( $pageData['starting'] )->sort( array( $sort =>  $ob) );

                foreach ( $datas as $x ) {
                    $data[] = $x;
                }

                $userCollection = loadDB('users');
                $user = $userCollection->findOne( array( 'username' => $_SESSION['username'] ) );

                echo '<tr>';
                echo '</tr>';

                if ( !empty( $data ) ) {
                    foreach ( $data as $survey ) {
                        echo '
                        <tr>
                            <td>' . $survey[ 'title' ] . '</td>
                            <td>' . $survey[ 'details' ][ 'taken' ] . ' times</td>
                            <td>
                                <form action="' . APP_URL . 'templates/take.php" method="post">
                                    <input type="hidden" name="name" value="' . $survey[ 'hash' ] . '"/>';
                        $canTake = 1;
                        if ( is_array( $user[ 'surveys' ][ 'taken' ] ) ) {
                            foreach ( $user[ 'surveys' ][ 'taken' ] as $userSurvey ) {
                                if ( ( $userSurvey == $survey[ 'hash' ] && Auth::checkPermissions( SURVEY_TAKE_RIGHTS ) ) ) {
                                    $canTake = 0;
                                    if ( Auth::checkPermissions( SURVEY_RETAKE_RIGHTS ) ) {
                                        $canTake = -1;
                                    }
                                    break;
                                } else if ( !Auth::checkPermissions( SURVEY_TAKE_RIGHTS ) ) {
                                    $canTake = 2;
                                    break;
                                } else if ( Auth::checkPermissions( SURVEY_TAKE_RIGHTS ) ) {
                                    $canTake = 1;
                                }
                            }


                            if ( empty( $user[ 'surveys' ][ 'taken' ] ) ) {
                                if ( !Auth::checkPermissions( SURVEY_TAKE_RIGHTS ) ) {
                                    $canTake = 2;
                                }
                            }

                            if ( $canTake == 0 ) {
                                echo '<input type="button" class="redButton" value="Already taken" />';
                            } else if ( $canTake == 2 ) {
                                echo '<input type="button" class="redButton" value="Can\'t take" />';
                            } else if ( $canTake == 1 || $canTake == -1 ) {
                                echo '<input type="submit" value="' . ( ( $canTake == -1 ) ? ( 'Take again' ) : ( 'Take' ) ) . '" />';
                            }
                        }
                        echo '
                                </form>
                            </td>';

                        echo '<td class="padding5_left aligncenter">
                                <form action="' . APP_URL . 'templates/results.php" method="post">
                                    <input type="hidden" name="name" value="' . $survey[ 'hash' ] . '"/>
                        ';

                        if ( ( $canTake == 0 || $canTake == -1 ) || Auth::checkPermissions( ADMIN_RIGHTS ) ) {
                            echo '<input type="submit" value="View Results" />';
                        }
                        echo '
                                </form>
                            </td>
                        </tr>
                         ';


                    }
                }
                else{
                    echo '
                    <tr><td colspan="4" class="aligncenter font14pt">No surveys to take check back later</td></tr>
                    ';
                }

                ?>
            </table>
        </div>
    </div>
</div>
<?php
include '../assets/inc/footer.php';
?>
</body>
</html>