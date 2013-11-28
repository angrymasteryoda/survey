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
        <?php
        $collection = loadDB('users');

        $pageData = Core::getPageData('users');

        switch(  ( (empty($_GET['o'])) ? ('') : ($_GET['o']) ) ){
            case 1:
                $sort = 'username';
                break;
            case 2:
                $sort = 'email';
                break;
            case 3:
                $sort = 'details.lastIp';
                break;
            case 4:
                $sort = 'details.created';
                break;
            default:
                $sort = 'username';
        }

        $ob = intval( ( (empty($_GET['ob'])) ? (1) : ($_GET['ob']) ) );
//        echo $sort .' => '.$ob;
        $datas = $collection->find( array( 'active' => true ) )->limit( $pageData['ipp'] )->skip( $pageData['starting'] )->sort( array( $sort =>  $ob) );
        foreach ( $datas as $x ) {
            $data[] = $x;
        }

        echo '<table class="users">
            <tr>
                <td class="padding5_left">Username '.Core::sortIcons(1).'</td>
                <td>Email'.Core::sortIcons(2).'</td>
                <td>Last ip'.Core::sortIcons(3).'</td>
                <td>Created'.Core::sortIcons(4).'</td>
            </tr>';

        foreach ( $data as $user ) {
            echo '
            <tr class="data" user="'.$user['username'].'">
                <td class="padding5_left">'.$user['username'].'</td>
                <td>'.$user['email'].'</td>
                <td>'.$user['details']['lastIp'].'</td>
                <td>'. Core::simpleDate( $user['details']['created'] ).'</td>
            </tr>
            <tr>
                <td colspan="4">
                    <div user="'.$user['username'].'" class="user none padding10_left padding10_bottom border_bottom">
                        Edit users rights:
                        <form class="editRightsForm">
                            ' . Core::printRightsForm($user['roles']) .'
                            <input type="hidden" value="'.$user['username'].'"/>
                            <input type="submit" value="Finshed" class="margin10_left width10"/>
                        </form>
                        <div class="deleteUserForm">
                            Delete user:
                            <form class="">
                                <input type="hidden" value="'.$user['username'].'"/>
                                <input type="submit" value="Delete" class="redButton width10"/>
                            </form>
                        </div>
                    </div>
                </td>

            </tr>
            ';
        }
        echo '</table>';

        Core::printPageLinks($pageData, true);

//        Debug::echoArray($data);
        ?>
    </div>
</div>
<?php
include '../assets/inc/footer.php';
?>
</body>
</html>