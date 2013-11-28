<?php
/**
 * Created by IntelliJ IDEA.
 * User: Michael
 * Date: 10/29/13
 * Time: 3:56 PM
 * To change this template use File | Settings | File Templates.
 */
class Debug {
    static function echoArray($arr){
        echo '<pre>';
        print_r($arr);
        echo '</pre>';
    }

    static function error($errorCode){
        switch($errorCode){
            case 404 :
                $randomString = array ('There is nothing to see here.', 'This is not the survey you were looking for.', 'Huston we have a problem.',
                    'Ahh its dark in here and im lost, quick escape with the link below.', 'Hi i\'m not here at the moment but you can leave me a message below');
                shuffle($randomString);
                $randomResult = $randomString[0] . '';
                echo '
                    <div class="pageTitle">
                        <div class="font23pt">404</div>
                        '.$randomResult.'<br>
                        <a onClick="history.go(-1);">Move along now.
                    </div>
                    <hr />';
                break;

            case 1000 :
                echo '
                    <div class="pageTitle">
                        <div class="font23pt">Taken Already</div>
                        Wow your on a roll!<br>
                        But you already got this one try another<br>
                        <a href="'.APP_URL.'templates/surveyListing.php">Move along now.
                    </div>
                    <hr />';
                break;
        }
    }
}