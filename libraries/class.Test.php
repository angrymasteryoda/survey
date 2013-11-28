<?php
/**
 * Created by IntelliJ IDEA.
 * User: michael
 * Date: 11/14/13
 * Time: 6:12 PM
 * To change this template use File | Settings | File Templates.
 */

class Test {

    static function validate( $validatables, $data){
//        $a = $validatables[1];
//        $field = $a['field'];
//
//        echo !isset( $data[$field] ) .' 1<br>';
//        echo ($data[$field] == '') .' 2<br>';

//        return '';
        $errors = array();
        $msg = array();
        $debug = false;
        foreach ( $validatables as $validates ) {
            $field = $validates['field'];

            $validations = explode( ',', $validates['type'] );

            if($debug)Debug::echoArray( $validations );
            //to allow for multiple checks of the same data-type
            $isEmpty = !isset( $data[$field] ) || $data[$field] === '';
            if ( !preg_match('/\bempty\b/', $validates['type']) || !$isEmpty ) {
                if ( empty($data[$field]) ) {
                    $errors[] = $field;
                    $msg[] = self::getErrorMsg($validates['type']);
                }
                else{
                    foreach ( $validations as $type ) {
                        $type = trim( $type );
                        $failed = false;


                        if ( $debug ) echo( $field );
                        switch ( $type ) {
                            case 'username' :
                                if ( !self::testRegex( $type, $data[ $field ] ) ) {
                                    $failed = true;
                                }
                                break;

                            case 'password' :
                                if ( !self::testRegex( $type, $data[ $field ] ) ) {
                                    $failed = true;
                                }
                                break;
                        }

                        if ( $failed ) {
                            $errors[] = $field;
                            $msg[] = self::getErrorMsg($type);
                        }
                    }
                }
            }
        }

        return array(
            'pass' => empty( $errors ),
            'errors' => $errors,
            'msg' => $msg
        );


    }

    private static function testRegex( $type, $data ){
        $loadRegex = self::getRegex($type);
        return preg_match( $loadRegex['regex'], $data );

    }

    public static function getErrorMsg( $types, $asString = true ){
        if ( preg_match('/\,/', $types) ) {
            $types = explode( ',', $types );
        }
//        Debug::echoArray($types);
        if ( is_array( $types ) ) {
            $msg = ( ($asString) ? ('') : (array()) );
            foreach ( $types as $type ) {
                $type = trim( $type );
                $loaded =  self::getRegex($type);
                if(!$asString){
                    $msg[] = $loaded['error'];
                }
                else{
                    $msg .= $loaded['error'] . '<br>';
                }
            }
            if ( $asString ) {
                $msg = self::str_lreplace('<br>', '', $msg);
            }

        }
        else{
            $types = trim( $types );
            $loaded =  self::getRegex($types);
            $msg = $loaded['error'];
        }

        return $msg;
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
                'regex' => '/[a-zA-Z0-9-\.]{1,}@([a-zA-Z\.])?[a-zA-Z]{1,}\.[a-zA-Z]{1,4}/i',
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
            //for the sake of time
            'time' => array(
                'regex' => '/(\d{2})\:(\d{2})/',
                'error' => 'has to be a valid time'
            ),
            'usphone' => array(
                'regex' => '/(\+?(\d?)[-\s.]?\(?(\d{3})\)?[-\s.]?(\d{3})[-\s.]?(\d{4})){1}/',
                'error' => 'has to be a valid North American phone number'
            ),
            'numbers' => array(
                'regex' => '/\d+/',
                'error' => 'has to be a number'
            ),
            'name' => array(
                'regex' => '/^[A-Za-z ]{2,50}$/',
                'error' => 'has to be 2-50 letters long'
            ),
            'pName' => array(
                'regex' => '/^[A-Za-z ]{2,50}$/',
                'error' => 'has to be 2-50 letters long'
            ),
            'pCell' => array(
                'regex' => '/(\+?(\d?)[-\s.]?\(?(\d{3})\)?[-\s.]?(\d{3})[-\s.]?(\d{4})){1}/',
                'error' => 'has to be a valid North American phone number'
            ),
            'belt' => array(
                'regex' => '/^[a-zA-Z]{2,15}$/',
                'error' => 'has to be 2-15 letters only'
            ),
            'boolean' => array(
                'regex' => '/^[01]$/',
                'error' => 'has to be a 0 or 1'
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

    private  static function str_lreplace($search, $replace, $subject){
        $pos = strrpos($subject, $search);

        if($pos !== false)
        {
            $subject = substr_replace($subject, $replace, $pos, strlen($search));
        }

        return $subject;
    }


}