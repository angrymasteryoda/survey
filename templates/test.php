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

$b = array(
    'username' => 'michael',
    'password' => 'goldfish'
);


$a = array(
    array(
        'field' =>'username',
        'use' => 'name',
    ),
    array(
        'field' =>'password',
        'use' => 'pass',
    )
);
echo 'test';


Test::newvalidate( $a, $b );

//Debug::echoArray( Test::newvalidate( $a, $b ) );

?>

<body bgcolor="#000000" text="#ffffff">


</body>