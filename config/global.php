<?php
$DATABASE_LOADED = false;
session_start();
define('SALT', '0m983vJt9Lb3tvV82yjHdjz8');
define('SERVER', 'localhost');
define('APP_NAME', 'survey');
define('APP_URL', '../');
define('MAIL_TO', 'rishermichael@gmail.com');

define('NO_QUOTES', false);
define('ALLOW_HTML', 1);

//database stuffs
if (SERVER == 'localhost') {
    define('DB_NAME', 'survey_local');
    define('DB_HOST', 'localhost');
}
else if (SERVER == 'live') {
    define('DB_NAME', 'survey_live');
    define('DB_HOST', 'localhost');
}

function loadDB($databaseName = null){
    $DATABASE_LOADED = true;
    $r = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD);

    if (!$r) {
        echo "Could not connect to server\n";
        trigger_error(mysql_error(), E_USER_ERROR);
    }
    if ( $databaseName ) {
        mysql_select_db($databaseName);
    }
}
function closeDB(){
    $DATABASE_LOADED = false;
    return mysql_close();
}

//old global
//	define('SERVER', 'localhost');
//	define('APP_NAME', 'survey');
//    define('APP_URL_RELATIVE', $_SERVER['HTTP_HOST'] . '/survey/');
//    define('APP_URL', '//' . APP_URL_RELATIVE);
//	//database stuffs
//	if (SERVER == 'localhost') {
//		define('DB_NAME', 'survey_local');
//	}
//
//
//