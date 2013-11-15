<?php
/**
 * Created by IntelliJ IDEA.
 * User: Michael
 * Date: 10/8/13
 * Time: 9:01 AM
 * To change this template use File | Settings | File Templates.
 */ 
class Validation {

    static function validate($type, $str = ''   ){
        if( is_array($type) ){
            $errors = array();
            foreach($type as $r => $v){
                $errors[$r] = self::validate($r, $v);
            }
            return $errors;
        }
        else{
            $loadRegex = self::getRegex($type);
            if( preg_match( $loadRegex['regex'], $str ) ){
                return true;
            }
            else{
                return false;
            }
        }
    }

    static function getError($type){
        if( preg_match('/length-', $type) ){
            $len = explode('-', $type);
            return 'has to be ' . $len[1] . ' long';
        }
        else{
            $t = self::getRegex($type);
            return $t['error'];
        }
    }

    private function getRegex($type = null){
        $regex = array(
            'username' => array(
                'regex' => '/^[a-zA-Z]{2,50}$/',
                'error' => 'has to be 2-50 letters only'
            ),
            'password' => array(
                'regex' => '/^[0-9a-zA-Z]{6,50}$/',
                'error' => 'has to be 6-50 long alphanumerical'
            ),
            'email' => array(
                'regex' => '/[a-zA-Z0-9-]{1,}@([a-zA-Z\.])?[a-zA-Z]{1,}\.[a-zA-Z]{1,4}/i',
                'error' => 'has to be valid email'
            ),
            'complex-password' => array(
                'regex' => '/^(?!.*(.)\1{3})((?=.*[\d])(?=.*[a-z])(?=.*[A-Z])|(?=.*[a-z])(?=.*[A-Z])(?=.*[^\w\d\s])|(?=.*[\d])(?=.*[A-Z])(?=.*[^\w\d\s])|(?=.*[\d])(?=.*[a-z])(?=.*[^\w\d\s])).{7,30}$/',
                'error' => 'has to be 7-30 must contain capital letter, and number or symbol'
            ),
            'date' => array(
                'regex' => '/(\d{4})\-(\d{2})\-(\d{2})/',
                'error' => 'has to be a valid date'
            ),
            'startTime' => array(
                'regex' => '/(\d{2})\:(\d{2})/',
                'error' => 'has to be a valid time'
            ),
            'endTime' => array(
                'regex' => '/(\d{2})\:(\d{2})/',
                'error' => 'has to be a valid time'
            )
        );

        if($type == null){
            return $regex;
        }
        else if( preg_match('/length-/', $type) ){
            $len = explode('-', $type);
            $return = array(
                'regex' => '/(.){' . $len[1] .'}/',
                'error' => 'has to be ' . $len[1] . ' long'
            );
            return $return;
        }
        else{
            return $regex[$type];
        }
    }

}