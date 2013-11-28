<?php
/**
 * Created by IntelliJ IDEA.
 * User: michael
 * Date: 11/14/13
 * Time: 6:20 PM
 * To change this template use File | Settings | File Templates.
 */

include '../config/global.php';

loadClasses();

////post data
//$b = array(
//    'username' => 'sad',
//    'last name' => '',
//    'password' => 'goldfish'
//);
//
//
//$a = array(
//    array(
//        'field' =>'username',
//        'type' => 'username',
//    ),
//    array(
//        'field' =>'last name',
//        'type' => 'username, password',
//    ),
//    array(
//        'field' =>'password',
//        'type' => 'password',
//    )
//);
//
//
//
//Debug::echoArray( Test::validate( $a, $b ) );
//
////Debug::echoArray( Test::newvalidate( $a, $b ) );
//
//
//function str_lreplace($search, $replace, $subject)
//{
//    $pos = strrpos($subject, $search);
//
//    if($pos !== false)
//    {
//        $subject = substr_replace($subject, $replace, $pos, strlen($search));
//    }
//
//    return $subject;
//}
//
$s = 'akshd,kajhsd,\'lask\'"dj"';
echo Security::sanitize($s, NO_QUOTES);

?>

<body bgcolor="#000000" text="#ffffff">


</body>