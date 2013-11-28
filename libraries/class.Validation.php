<?php
/**
 * Created by IntelliJ IDEA.
 * User: Michael
 * Date: 10/8/13
 * Time: 9:01 AM
 * To change this template use File | Settings | File Templates.
 */ 
class Validation {
    function Validation(){

    }

    //i dont want to rewrite this 3 times no time make the question blob do elsewhere and squeeze it in
    static function validate( $validatables, $data, $hasDataBlob = false){
        if ( $hasDataBlob ) {
            return self::breakBlob( $validatables, $data );
        }
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
            $matchId = ( (isset($validates['matchId'])) ? ($validates['matchId']) : (null) );

            $validations = explode( ',', $validates['type'] );

            //if($debug)Debug::echoArray( $validates );
            //to allow for multiple checks of the same data-type
            $isEmpty = !isset( $data[$field] ) || $data[$field] === '';
            if ( !preg_match('/\bempty\b/', $validates['type']) || !$isEmpty ) {
                if ( empty($data[$field]) ) {
                    $errors[] = $field;
                    $msg[] = self::getErrorMsg($validates['type'], $field);
                }
                else{
                    foreach ( $validations as $type ) {
                        $type = trim( $type );
                        $failed = false;

                        if ( $debug ) echo( 'field-'. $field . ' 44');
                        if ( $debug ) echo( '<br>type- '. $type .' 45<br>');
                        switch ( $type ) {
                            case 'match' :
                                $compareTo = null;
                                foreach ( $validatables as $match ) {
                                    if ( isset($match['matchId']) && $match['matchId'] == $matchId && $match['field'] != $field) {
                                        $compareTo = $match;
                                        break;
                                    }
                                }
                                if ( isset($compareTo) ) {
                                    if ( $data[$field] != $data[$compareTo['field']] ) {
                                        $failed = true;
                                    }
                                }
                                break;
                            default:
                                if ( !self::testRegex( $type, $data[ $field ] ) ) {
                                    $failed = true;
                                }
                                break;
//                                echo 'not validating field='.$field .' type='. $type;
                        }

                        if ( $failed ) {
                            $errors[] = $field;
                            $msg[] = self::getErrorMsg($type, $field);
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

    private static function breakBlob( $validatables, $data ){
        if ( isset($data['questions']) ) {
            return self::blobQuestion( $validatables, $data );
        }
        else if ( isset($data['answers']) ) {
            return self::blobAnswer( $validatables, $data );
        }
    }

    private static function blobQuestion( $validatables, $data ){
        $toValidate = array();
        $questionData = $data['questions'];
        unset($data['questions']);
        foreach ( $validatables as $validates ) {
            if ( isset($validates['isQuestions']) ) {
                if ( $validates[ 'isQuestions' ] ) {
                    for ( $i = 1; $i <= count( $questionData ); $i++ ) {
                        $data['question['.$i.']'] = Security::sanitize( $questionData[$i]['question'] );
                        array_push( $toValidate, array( 'field' => 'question['.$i.']', 'type' => $validates['type']) );

                        if( isset( $questionData[$i]['multiAnswer'] ) ){
                            $data['multiAnswer['.$i.']'] = Security::sanitize( $questionData[$i]['multiAnswer'] );
                            array_push( $toValidate, array( 'field' => 'multiAnswer['.$i.']', 'type' => $validates['type']) );
                        }
                    }
                }
            }
            else{
                array_push( $toValidate, $validates );
            }
        }
        return self::validate($toValidate, $data);
    }

    private static function blobAnswer( $validatables, $data ){
//        Debug::echoArray($validatables);
//        Debug::echoArray($data);
        $toValidate = array();
        $answersData = $data['answers'];
        unset($data['answers']);
        foreach ( $validatables as $validates ) {
            if ( isset($validates['isAnswers']) ) {
                if ( $validates[ 'isAnswers' ] ) {
                    for ( $i = 1; $i <= count( $answersData ); $i++ ) {
                        $data['answer['.$i.']'] = Security::sanitize( $answersData[$i]['answer'] );
                        array_push( $toValidate, array( 'field' => 'answer['.$i.']', 'type' => $validates['type']) );
//
//                        if( isset( $questionData[$i]['multiAnswer'] ) ){
//                            $data['multiAnswer['.$i.']'] = Security::sanitize( $questionData[$i]['multiAnswer'] );
//                            array_push( $toValidate, array( 'field' => 'multiAnswer['.$i.']', 'type' => $validates['type']) );
//                        }
                    }
                }
            }
            else{
                array_push( $toValidate, $validates );
            }
        }
        return self::validate($toValidate, $data);
    }

    public static function testRegex( $type, $data ){
        $loadRegex = self::getRegex($type);
        return preg_match( $loadRegex['regex'], $data );
    }

    public static function getErrorMsg( $types, $field ){
        if ( preg_match('/\,/', $types) ) {
            $types = explode( ',', $types );
        }
//        Debug::echoArray($types);
        if ( is_array( $types ) ) {
            foreach ( $types as $type ) {
                $type = trim( $type );
                $loaded =  self::getRegex($type);
                $msg[$field] = $field .' '.$loaded['error'];
            }
        }
        else{
            $types = trim( $types );
            $loaded =  self::getRegex($types);
            $msg[$field] = $loaded['error'];
        }

        return $msg;
    }

    private function getRegex($type = null){
        $regex = array(
            'longWords' => array(
                'regex' => '/^(.{3,250})$/',
                'error' => 'has to be at least 3 and less than 250 characters long'
            ),
            'words' => array(
                'regex' => '/^(.{3,150})$/',
                'error' => 'has to be at least 3 and less than 150 characters long'
            ),
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
            ),
            'match' => array(
                'error' => 'has to match'
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
//    /**
//     * Newest validate fixs the duplicate index problem
//     * Old validate is now called oldValidate()
//     * @param $validatables
//     * @param $data
//     * @return array
//     */
//    static function validate( $validatables, $data){
//        $errors = array();
//        $msg = array();
//        $debug = false;
//        if(is_array($validatables)){
//            foreach ( $validatables as $validates ) {
//                $field = $validates['field'];
//
//                $validations = explode( ',', $validates['type'] );
//
//                if($debug)Debug::echoArray( $validations );
//                //to allow for multiple checks of the same data-type
//                $isEmpty = !isset( $data[$field] ) || $data[$field] === '';
//                if ( !preg_match('/\bempty\b/', $validates['type']) || !$isEmpty ) {
//                    if ( empty($data[$field]) ) {
//                        $errors[] = $field;
//                        $msg[] = self::getErrorMsg($validates['type']);
//                    }
//                    else{
//                        foreach ( $validations as $type ) {
//                            $type = trim( $type );
//                            $failed = false;
//
//
//                            if ( $debug ) echo( $field );
//                            switch ( $type ) {
//                                case 'username' :
//                                    if ( !self::testRegex( $type, $data[ $field ] ) ) {
//                                        $failed = true;
//                                    }
//                                    break;
//
//                                case 'password' :
//                                    if ( !self::testRegex( $type, $data[ $field ] ) ) {
//                                        $failed = true;
//                                    }
//                                    break;
//                            }
//
//                            if ( $failed ) {
//                                $errors[] = $field;
//                            }
//                        }
//                    }
//                }
//            }
//        }
//
//        return array(
//            'pass' => empty( $errors ),
//            'errors' => $errors,
//            'msg' => $msg
//        );
//    }
//
//    public static function getErrorMsg( $types, $asString = true ){
//        if ( preg_match('/\,/', $types) ) {
//            $types = explode( ',', $types );
//        }
////        Debug::echoArray($types);
//        if ( is_array( $types ) ) {
//            $msg = ( ($asString) ? ('') : (array()) );
//            foreach ( $types as $type ) {
//                $type = trim( $type );
//                $loaded =  self::getRegex($type);
//                if(!$asString){
//                    $msg[] = $loaded['error'];
//                }
//                else{
//                    $msg .= $loaded['error'] . '<br>';
//                }
//            }
//            if ( $asString ) {
//                $msg = self::str_lreplace('<br>', '', $msg);
//            }
//
//        }
//        else{
//            $types = trim( $types );
//            $loaded =  self::getRegex($types);
//            $msg = $loaded['error'];
//        }
//
//        return $msg;
//    }
//
//    private static function testRegex( $type, $data ){
//        $loadRegex = self::getRegex($type);
//        return preg_match( $loadRegex['regex'], $data );
//    }
//
//    /**
//     * Replace the last string of string
//     * @param $search
//     * @param $replace
//     * @param $subject
//     * @return mixed
//     */
//    private  static function str_lreplace($search, $replace, $subject){
//        $pos = strrpos($subject, $search);
//        if($pos !== false){
//            $subject = substr_replace($subject, $replace, $pos, strlen($search));
//        }
//        return $subject;
//    }
//
//    /**
//     * @param $type
//     * @param string $str
//     * @return array|bool
//     */
//    static function oldValidate($type, $str = ''   ){
//        if( is_array($type) ){
//            $errors = array();
//            foreach($type as $r => $v){
//                $errors[$r] = self::validate($r, $v);
//            }
//            return $errors;
//        }
//        else{
//            $loadRegex = self::getRegex($type);
//            if( preg_match( $loadRegex['regex'], $str ) ){
//                return true;
//            }
//            else{
//                return false;
//            }
//        }
//    }
//
//    /**
//     * @param $type
//     * @return string
//     * @deprecated
//     */
//    static function getError($type){
//        if( preg_match('/length-', $type) ){
//            $len = explode('-', $type);
//            return 'has to be ' . $len[1] . ' long';
//        }
//        else{
//            $t = self::getRegex($type);
//            return $t['error'];
//        }
//    }
//
//    private function getRegex($type = null){
//        $regex = array(
//            'username' => array(
//                'regex' => '/^[a-zA-Z]{2,50}$/',
//                'error' => 'has to be 2-50 letters only'
//            ),
//            'password' => array(
//                'regex' => '/^[0-9a-zA-Z]{6,50}$/',
//                'error' => 'has to be 6-50 long alphanumerical'
//            ),
//            'email' => array(
//                'regex' => '/[a-zA-Z0-9-\.]{1,}@([a-zA-Z\.])?[a-zA-Z]{1,}\.[a-zA-Z]{1,4}/i',
//                'error' => 'has to be valid email'
//            ),
//            'complex-password' => array(
//                'regex' => '/^(?!.*(.)\1{3})((?=.*[\d])(?=.*[a-z])(?=.*[A-Z])|(?=.*[a-z])(?=.*[A-Z])(?=.*[^\w\d\s])|(?=.*[\d])(?=.*[A-Z])(?=.*[^\w\d\s])|(?=.*[\d])(?=.*[a-z])(?=.*[^\w\d\s])).{7,30}$/',
//                'error' => 'has to be 7-30 must contain capital letter, and number or symbol'
//            ),
//            'date' => array(
//                'regex' => '/(\d{4})\-(\d{2})\-(\d{2})/',
//                'error' => 'has to be a valid date'
//            ),
//            //for the sake of time
//            'time' => array(
//                'regex' => '/(\d{2})\:(\d{2})/',
//                'error' => 'has to be a valid time'
//            ),
//            'usphone' => array(
//                'regex' => '/(\+?(\d?)[-\s.]?\(?(\d{3})\)?[-\s.]?(\d{3})[-\s.]?(\d{4})){1}/',
//                'error' => 'has to be a valid North American phone number'
//            ),
//            'numbers' => array(
//                'regex' => '/\d+/',
//                'error' => 'has to be a number'
//            ),
//            'name' => array(
//                'regex' => '/^[A-Za-z ]{2,50}$/',
//                'error' => 'has to be 2-50 letters long'
//            ),
//            'pName' => array(
//                'regex' => '/^[A-Za-z ]{2,50}$/',
//                'error' => 'has to be 2-50 letters long'
//            ),
//            'pCell' => array(
//                'regex' => '/(\+?(\d?)[-\s.]?\(?(\d{3})\)?[-\s.]?(\d{3})[-\s.]?(\d{4})){1}/',
//                'error' => 'has to be a valid North American phone number'
//            ),
//            'belt' => array(
//                'regex' => '/^[a-zA-Z]{2,15}$/',
//                'error' => 'has to be 2-15 letters only'
//            ),
//            'boolean' => array(
//                'regex' => '/^[01]$/',
//                'error' => 'has to be a 0 or 1'
//            )
//        );
//        if($type == null){
//            return $regex;
//        }
//        else if( preg_match('/length-/', $type) ){
//            $len = explode('-', $type);
//            $return = array(
//                'regex' => '/(.){' . $len[1] .'}/',
//                'error' => 'has to be ' . $len[1] . ' long'
//            );
//            return $return;
//        }
//        else{
//            return $regex[$type];
//        }
//    }

}