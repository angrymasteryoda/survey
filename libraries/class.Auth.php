<?php
/**
 * Created by IntelliJ IDEA.
 * User: Michael
 * Date: 10/4/13
 * Time: 3:19 PM
 * To change this template use File | Settings | File Templates.
 */ 
class Auth {
    static function checkPermissions($required){
//        Debug::echoArray($_SESSION['roles']);
        if ( isset( $_SESSION['roles'] ) ) {
            foreach ( $_SESSION['roles'] as $perm ) {
                if ( $perm == $required || $perm == '*') {
                    return true;
                }
                else {
                    return false;
                }
            }
        }
        else{
            return false;
        }
    }
}
