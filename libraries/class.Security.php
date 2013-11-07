<?php
/**
 * Created by IntelliJ IDEA.
 * User: Michael
 * Date: 10/4/13
 * Time: 3:34 PM
 * To change this template use File | Settings | File Templates.
 */ 
class Security {
    static function sanitize($input, $allowQuotes = true) {
        //remove tags from user input so not prone to evil doers
        if (is_array($input)) {
            foreach($input as $var=>$val) {
                $output[$var] = self::sanitize($val);
            }
        }
        else {
            $input = trim($input);
            $output  = strip_tags($input);
            if ( !$allowQuotes ) {
                $output = mysql_real_escape_string($output);
            }
        }

        if (isset($output)) {
            return $output;
        }
        else{
            return '';
        }
    }

    static function encrypt( $str ){
        return mcrypt_ecb(MCRYPT_3DES, SALT, $str, MCRYPT_ENCRYPT);
    }

    static function decrypt( $str ){
        return mcrypt_ecb(MCRYPT_3DES, SALT, $str, MCRYPT_DECRYPT);
    }

    static function md5($str){
        return md5($str);
    }

    static function sha1($str){
        return sha1($str);
    }
}
