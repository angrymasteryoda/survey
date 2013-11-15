<?php
/**
 * Created by IntelliJ IDEA.
 * User: michael
 * Date: 11/14/13
 * Time: 7:17 PM
 * To change this template use File | Settings | File Templates.
 */

class Regex {

}

/*
 *
 * $regex = array(
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
 *
 */