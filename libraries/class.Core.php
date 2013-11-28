<?php
/**
 * Created by IntelliJ IDEA.
 * User: Michael
 * Date: 10/4/13
 * Time: 3:19 PM
 * To change this template use File | Settings | File Templates.
 */

class Core {

    static function drawDivCalendar($className, $widthOffset = 0, $month = null, $year = null, $width = 294){
        $month = (( isset($month) ) ? ( $month ):( date('m') ));
        $year = (( isset($year) ) ? ( $year ):( date('Y') ));

        $firstDay = mktime(0,0,0, $month, 1, $year);

        $monthName = date('F');

        $startingDay = date('D', $firstDay);

        $blank = 0;

        $widthDay = ($width-1) / 7;
        switch($startingDay){
            case 'Sun' : $blank = 0;break;
            case 'Mon' : $blank = 1;break;
            case 'Tue' : $blank = 2;break;
            case 'Wed' : $blank = 3;break;
            case 'Thu' : $blank = 4;break;
            case 'Fri' : $blank = 5;break;
            case 'Sat' : $blank = 6;break;
        }

        $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);

        $str = '<div style="width:' . ($width + $widthOffset) . 'px;" class="' . $className .'">';
        $str .= "<div style='text-align: center;' class='month'> $monthName $year </div>";
        $dayNames = array('S','M','T','W','T','F','S');
        foreach($dayNames as $d){
            $str .= '<div style="width:' . $widthDay . 'px;float: left;text-align: center;" class="day title">' . $d .'</div>';
        }
        $str .= '<div style="clear: both;"></div>';

        $dayCount = 1;
        $str .= "";
        while ( $blank > 0 ){
            $str .= '<div style="width:' . $widthDay . 'px;float: left;text-align: center;" class="day blank">&nbsp;</div>';
            $blank = $blank-1;
            $dayCount++;
        }

        $dayNum = 1;

        while ( $dayNum <= $daysInMonth ){
            $str .=  '<div style="width:' . $widthDay . 'px;float: left;text-align: center;" class="day">' . $dayNum . '</div>';
            $dayNum++;
            $dayCount++;

            if ($dayCount > 7){
                $str .= '<div style="clear: both;"></div>';
                $dayCount = 1;
            }
        }

        while ( $dayCount >1 && $dayCount <=7 ){
            $str .= '<div style="width:' . $widthDay . 'px;float: left;text-align: center;" class="day blank">&nbsp;</div>';
            $dayCount++;
        }
        $str .= '<div style="clear: both;"></div>';
        $str .= '</div>';

        return $str;
    }

    static function drawCalendar($className, $month = null, $year = null, $width = 294, $border = false){
        $border = (( $border )?( 'border="1"' ):( '' ));

        $month = (( isset($month) ) ? ( $month ):( date('m') ));
        $year = (( isset($year) ) ? ( $year ):( date('Y') ));

        $firstDay = mktime(0,0,0, $month, 1, $year);

        $monthName = date('F');

        $startingDay = date('D', $firstDay);

        $blank = 0;
        switch($startingDay){
            case 'Sun' : $blank = 0;break;
            case 'Mon' : $blank = 1;break;
            case 'Tue' : $blank = 2;break;
            case 'Wed' : $blank = 3;break;
            case 'Thu' : $blank = 4;break;
            case 'Fri' : $blank = 5;break;
            case 'Sat' : $blank = 6;break;
        }

        $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);

        $str = '<table width="' . $width . '" ' . $border . ' class="'. $className .'">';
        $str .= "<tr><th colspan=7> $monthName $year </th></tr>";
        $str .= '<tr>
            <td width=' . ($width/7) . '>S</td>
            <td width=' . ($width/7) . '>M</td>
            <td width=' . ($width/7) . '>T</td>
            <td width=' . ($width/7) . '>W</td>
            <td width=' . ($width/7) . '>T</td>
            <td width=' . ($width/7) . '>F</td>
            <td width=' . ($width/7) . '>S</td>
            </tr>';

        $dayCount = 1;
        $str .= "<tr>";
        while ( $blank > 0 ){
            $str .= '<td></td>';
            $blank = $blank-1;
            $dayCount++;
        }

        $dayNum = 1;

        while ( $dayNum <= $daysInMonth ){
            $str .=  "<td class='day'> $dayNum </td>";
            $dayNum++;
            $dayCount++;

            if ($dayCount > 7){
                $str .= '</tr><tr>';
                $dayCount = 1;
            }
        }

        while ( $dayCount >1 && $dayCount <=7 ){
            $str .= '<td> </td>';
            $dayCount++;
        }
        $str .= '</tr></table>';

        return $str;
    }

    static function getClientIP() {
        if (getenv("HTTP_CLIENT_IP") && strcasecmp(getenv("HTTP_CLIENT_IP"), "unknown")) {
            $ip = getenv("HTTP_CLIENT_IP");
        } else if (getenv("HTTP_X_FORWARDED_FOR") && strcasecmp(getenv("HTTP_X_FORWARDED_FOR"), "unknown")) {
            $ip = getenv("HTTP_X_FORWARDED_FOR");
        } else if (getenv("REMOTE_ADDR") && strcasecmp(getenv("REMOTE_ADDR"), "unknown")) {
            $ip = getenv("REMOTE_ADDR");
        } else if (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], "unknown")) {
            $ip = $_SERVER['REMOTE_ADDR'];
        } else {
            $ip = "unknown";
        }
        return($ip);
    }

    static function parseUserAgent( $u_agent = null ) {
        if(is_null($u_agent) && isset($_SERVER['HTTP_USER_AGENT'])) $u_agent = $_SERVER['HTTP_USER_AGENT'];

        $empty = array(
            'platform' => null,
            'browser'  => null,
            'version'  => null,
        );

        $data = $empty;

        if(!$u_agent) return $data;

        if( preg_match('/\((.*?)\)/im', $u_agent, $parent_matches) ) {

            preg_match_all('/(?P<platform>Android|CrOS|iPhone|iPad|Linux|Macintosh|Windows(\ Phone\ OS)?|Silk|linux-gnu|BlackBerry|PlayBook|Nintendo\ (WiiU?|3DS)|Xbox)
            (?:\ [^;]*)?
            (?:;|$)/imx', $parent_matches[1], $result, PREG_PATTERN_ORDER);

            $priority = array('Android', 'Xbox');
            $result['platform'] = array_unique($result['platform']);
            if( count($result['platform']) > 1 ) {
                if( $keys = array_intersect($priority, $result['platform']) ) {
                    $data['platform'] = reset($keys);
                }else{
                    $data['platform'] = $result['platform'][0];
                }
            }elseif(isset($result['platform'][0])){
                $data['platform'] = $result['platform'][0];
            }
        }

        if( $data['platform'] == 'linux-gnu' ) { $data['platform'] = 'Linux'; }
        if( $data['platform'] == 'CrOS' ) { $data['platform'] = 'Chrome OS'; }

        preg_match_all('%(?P<browser>Camino|Kindle(\ Fire\ Build)?|Firefox|Safari|MSIE|AppleWebKit|Chrome|IEMobile|Opera|OPR|Silk|Lynx|Version|Wget|curl|NintendoBrowser|PLAYSTATION\ (\d|Vita)+)
            (?:;?)
            (?:(?:[/ ])(?P<version>[0-9A-Z.]+)|/(?:[A-Z]*))%ix',
            $u_agent, $result, PREG_PATTERN_ORDER);

        $key = 0;

        // If nothing matched, return null (to avoid undefined index errors)
        if (!isset($result['browser'][0]) || !isset($result['version'][0])) {
            return $empty;
        }

        $data['browser'] = $result['browser'][0];
        $data['version'] = $result['version'][0];

        if( $key = array_search( 'Playstation Vita', $result['browser'] ) !== false ) {
            $data['platform'] = 'PlayStation Vita';
            $data['browser'] = 'Browser';
        }elseif( ($key = array_search( 'Kindle Fire Build', $result['browser'] )) !== false || ($key = array_search( 'Silk', $result['browser'] )) !== false ) {
            $data['browser']  = $result['browser'][$key] == 'Silk' ? 'Silk' : 'Kindle';
            $data['platform'] = 'Kindle Fire';
            if( !($data['version'] = $result['version'][$key]) || !is_numeric($data['version'][0]) ) {
                $data['version'] = $result['version'][array_search( 'Version', $result['browser'] )];
            }
        }elseif( ($key = array_search( 'NintendoBrowser', $result['browser'] )) !== false || $data['platform'] == 'Nintendo 3DS' ) {
            $data['browser']  = 'NintendoBrowser';
            $data['version']  = $result['version'][$key];
        }elseif( ($key = array_search( 'Kindle', $result['browser'] )) !== false ) {
            $data['browser']  = $result['browser'][$key];
            $data['platform'] = 'Kindle';
            $data['version']  = $result['version'][$key];
        }elseif( ($key = array_search( 'OPR', $result['browser'] )) !== false || ($key = array_search( 'Opera', $result['browser'] )) !== false ) {
            $data['browser'] = 'Opera';
            $data['version'] = $result['version'][$key];
            if( ($key = array_search( 'Version', $result['browser'] )) !== false ) { $data['version'] = $result['version'][$key]; }
        }elseif( $result['browser'][0] == 'AppleWebKit' ) {
            if( ( $data['platform'] == 'Android' && !($key = 0) ) || $key = array_search( 'Chrome', $result['browser'] ) ) {
                $data['browser'] = 'Chrome';
                if( ($vkey = array_search( 'Version', $result['browser'] )) !== false ) { $key = $vkey; }
            }elseif( $data['platform'] == 'BlackBerry' || $data['platform'] == 'PlayBook' ) {
                $data['browser'] = 'BlackBerry Browser';
                if( ($vkey = array_search( 'Version', $result['browser'] )) !== false ) { $key = $vkey; }
            }elseif( $key = array_search( 'Safari', $result['browser'] ) ) {
                $data['browser'] = 'Safari';
                if( ($vkey = array_search( 'Version', $result['browser'] )) !== false ) { $key = $vkey; }
            }
            $data['version'] = $result['version'][$key];
        }elseif( $result['browser'][0] == 'MSIE' ){
            if( $key = array_search( 'IEMobile', $result['browser'] ) ) {
                $data['browser'] = 'IEMobile';
            }else{
                $data['browser'] = 'MSIE';
                $key = 0;
            }
            $data['version'] = $result['version'][$key];
        }elseif( $key = array_search( 'PLAYSTATION 3', $result['browser'] ) !== false ) {
            $data['platform'] = 'PlayStation 3';
            $data['browser']  = 'NetFront';
        }
        return $data;
    }

    static function getHumanTime($time){
        $timeSplit = explode(':', $time);
        if($timeSplit[0] > 12){
            return ($timeSplit[0]%12) . ':' . $timeSplit[1] . 'Pm';
        }
        else{
            return $timeSplit[0] . ':' . $timeSplit[1] . 'Am';
        }
    }

    static function loadJavascript(){
        $paths = glob( APP_URL . 'assets/js/*.js' );
        foreach($paths as $path){
            echo '<script type="text/javascript" src="' . $path .'"></script>';
        }
    }

    static function loadCss(){
        $paths = glob( APP_URL . 'assets/css/*.css' );
        foreach($paths as $path){
            if ( !preg_match('/mixins.css/', $path) ) {
                echo '<link type="text/css" rel="stylesheet" href="' . $path .'" />';
            }

        }
    }

    static function simpleDate($timestamp){
        date_default_timezone_set('America/Los_Angeles');
        //Debug::echoArray( getdate( $timestamp ) );
        $now = getdate( time() );
        $then = getdate( $timestamp );

        if ($then['minutes'] < 10) {
            $then['minutes'] = '0' . $then['minutes'];
        }

        if( $now['month'] == $then['month'] &&  $now['year'] == $then['year'] && $now['mday'] == $then['mday']){
            return self::getHumanTime( $then['hours'] . ':' . $then['minutes'] );
        }
        else if( $now['year'] == $then['year'] ){
            return substr( $then['month'], 0, 3) . ' ' . $then['mday'];
        }
        else{
            return substr( $then['month'], 0, 3) . ' ' . $then['mday'] . ' ' . $then['year'];
        }
    }

    static function sortIcons($order){
        //what if the page has a query already?
        $queries = $_GET;

        $queries['o'] = $order;
        $queries['ob'] = 1;
        $str =  '
        <div class="floatright clearfix margin15_right">
            <a class="sortable" href="?'. http_build_query($queries) .'"><img class="block" src="' .APP_URL . 'assets/img/icon_up_carrot.png" /></a>';
        $queries['ob'] = -1;
        $str .='
            <a class="sortable" href="?'. http_build_query($queries) .'"><img class="block margin5_top" src="' .APP_URL . 'assets/img/icon_down_carrot.png" /></a>
        </div>
        ';
        return $str;
    }

    static function getPageData($table = null, $items = 25){
        if( is_null($table) )return'';

        $dbName = DB_NAME;
        $connection = new Mongo(DB_HOST);
        $db = $connection->$dbName;
        $collection = $db->$table;

        $totalRecords = $collection->count();

        $ipp = ( ( empty($_GET['ipp']) ) ? ( $items ) : ( $_GET['ipp'] ) );//item per page
        $page = ( ( empty($_GET['p']) ) ? ( 1 ) : ( $_GET['p'] ) );
        $startingPoint = ( ( empty($_GET['sp']) ) ? ( 0 ) : ( $_GET['sp'] ) );//where we left off


        if ( !is_numeric($ipp) ) {
            $ipp = $items;
        }

        if ( !is_numeric($page) ) {
            $page = 1;
        }

        if ( !is_numeric($startingPoint) ) {
            $startingPoint = 0;
        }

        if ( $totalRecords > $ipp ) {
            $pages = ceil( $totalRecords / $ipp );
        }
        else{
            $pages = 1;
        }
        return array(
            'pages' => $pages,
            'starting' => $startingPoint,
            'ipp' => $ipp,
            'page' => $page
        );
    }

    static function printPageLinks($pageData = null, $canEcho = true){
        if( is_null($pageData) ){return'';}
        $queries = $_GET;

        $str ='<div class="pagesLinks">';
        for ( $i = 0; $i < $pageData['pages']; $i++ ) {
            if( ($i+1) != $pageData['page']){
                $queries['p'] = ($i+1);
                $queries['sp'] = ($pageData['ipp'] * $i);
                $str .= '<a class="pageNum" href="?'. http_build_query($queries) .'">' . ($i+1) . '</a>';
            }
            else{
                $str .= '<a class="active">' . ($i+1) . '</a>';
            }
        }
        $str .= '</div>';

        if ( $canEcho ) {
            echo $str;
        }
        else{
            return $str;
        }

    }

    static function printQuestion($question, $num){
        $type = $question['answerType'];
        switch($type){
            case 'single':
                echo '
                <fieldset>
                    <div>Question '. $num .':<br>
                        <div class="margin10_left">
                            <label>'.$question['question'].'<br>
                                <input placeholder="Question '. $num .'" name="answer['. $num .']" type="text" data-type="longWords"/>
                            </label>
                        </div>
                    </div>
                </fieldset>
                ';
                break;

            case 'write' :
                echo '
                <fieldset>
                    <div>Question '. $num .':<br>
                        <div class="margin10_left">
                            <label>'.$question['question'].'<br>
                                <textarea placeholder="Question '. $num .'" name="answer['. $num .']" data-type="longWords"></textarea>
                            </label>
                        </div>
                    </div>
                </fieldset>
                ';
                break;
            case 'multi':
                $options = explode(',', $question['multiAnswer']);
                echo '
                <fieldset>
                    <div>Question '. $num .':<br>
                        <div class="margin10_left">
                            <label class="multiAns">'.$question['question'].'<br>';
                                foreach ( $options as $option ) {
                                    $option = trim( $option );
                                    echo '<input type="radio" name="answer['. $num .']" value="'. $option .'"/>'. $option .'<br>';
                                }
                echo '
                            </label>
                            <div class="margin10_bottom">&nbsp;</div>
                        </div>
                    </div>
                </fieldset>
                ';
                break;
            case 't/f':
                echo '
                <fieldset>
                    <div>Question '. $num .':<br>
                        <div class="margin10_left">
                            <label class="multiAns">'.$question['question'].'<br>
                                <input type="radio" name="answer['. $num .']" value="true"/>True<br>
                                <input type="radio" name="answer['. $num .']" value="false"/>False<br>
                            </label>
                            <div class="margin10_bottom">&nbsp;</div>
                        </div>
                    </div>
                </fieldset>
                ';
                break;
        }
    }
    
    public static function printRightsForm($rights, $canEcho = false){
        $allRights = array(
            SURVEY_TAKE_RIGHTS => false,
            SURVEY_RESULTS_RIGHTS => false,
            SURVEY_RETAKE_RIGHTS => false,
            SURVEY_DELETE_RIGHTS => false,
            ADMIN_RIGHTS => false
        );
        foreach ( $rights as $right ) {
            $allRights[$right] = true;

        }

        $str = '
            <input type="checkbox" name="rightBox" value="take"   '. ( ($allRights[SURVEY_TAKE_RIGHTS]) ? ('checked') : ('') ) .'/>Take
            <input type="checkbox" name="rightBox" value="results"'. ( ($allRights[SURVEY_RESULTS_RIGHTS]) ? ('checked') : ('') ) .'/>Results
            <input type="checkbox" name="rightBox" value="retake" '. ( ($allRights[SURVEY_RETAKE_RIGHTS]) ? ('checked') : ('') ) .'/>Retake
            <input type="checkbox" name="rightBox" value="delete" '. ( ($allRights[SURVEY_DELETE_RIGHTS]) ? ('checked') : ('') ) .'/>Delete
            <input type="checkbox" name="rightBox" value="*"      '. ( ($allRights[ADMIN_RIGHTS]) ? ('checked') : ('') ) .'/>Admin

        ';

        return $str;

    }
}
