<?php
/**
 * Created by IntelliJ IDEA.
 * User: Michael
 * Date: 10/4/13
 * Time: 4:39 PM
 * To change this template use File | Settings | File Templates.
 */
include '../config/global.php';
$paths = glob( '../libraries/class.*.php' );
foreach($paths as $path){
    require_once($path);
}
switch( Security::sanitize( $_POST['header'] ) ){
    case 'signup':
        $username = Security::sanitize($_POST['username']);
        $canProceed = true;

        $errors = Validation::validate( array(
            'username' => $username,
            'password' => Security::sanitize( $_POST['password'] ),
            'email' => Security::sanitize( $_POST['email'] )
        ));
        foreach( $errors as $err){
            if ( !$err ) {
                $canProceed = false;
            }
        }
        //do validation here
        /*'username'
        'pass'
        'email'*/
        if ( $canProceed ) {
            $dbName = DB_NAME;
            $connection = new Mongo(DB_HOST);
            $db = $connection->$dbName;

            $collection = $db->users;

            $input = array(
                'username' => $username,
                'password' => Security::md5( Security::sanitize( $_POST['password'] ) ),
                'email' => Security::sanitize( $_POST['email'] ),
                'roles' => array(
                    'take',
                    'edit'
                ),
                'details' => array(
                    'created' => time('NOW'),
                    'browser' => Core::parseUserAgent(),
                    'ip' => $_SERVER['REMOTE_ADDR'],
                    'lastIp' => $_SERVER['REMOTE_ADDR']
                ),
                'surveys' => array(
                    'created' => array(),
                    'taken' => array()
                )
            );

            $usernameTaken = $collection->count( array('username' => $username) );
            $emailTaken = $collection->count( array('email' =>  Security::sanitize( $_POST['email'] )) );
            $canSubmit = true;

            if( $usernameTaken == 1 ){
                $canSubmit = false;
                $errors['username'] = 'taken';
            }
            if( $emailTaken ){
                $canSubmit = false;
                $errors['email'] = 'taken';
            }

            if( $canSubmit ){
                $collection->insert($input);
            }
            $connection->close();
        }

        echo json_encode( $errors );

        break;

    case 'login' :
        $errors = Validation::validate( array(
            'username' => Security::sanitize( $_POST['username'] ),
            'password' => Security::sanitize( $_POST['password'] )
        ));

        $canProceed = true;

        foreach( $errors as $err){
            if ( !$err ) {
                $canProceed = false;
            }
        }

        if($canProceed){
            $dbName = DB_NAME;
            $connection = new Mongo(DB_HOST);
            $db = $connection->$dbName;
            $collection = $db->users;

            $connection->close();

            $found = $collection->findOne( array(
                'username' => Security::sanitize( $_POST['username'] ),
                'password' =>  md5( Security::sanitize( $_POST['password'] ) )
            ) );

            if ( !empty( $found ) ) {
                $errors['login'] = true;
                $_SESSION['timeout'] = time();
                $_SESSION['user'] = $found['username'];
                $_SESSION['sessionId'] = md5( $found['username'] );
            }
        }
        echo json_encode($errors);
        break;

    default:
        echo 'I derped sorry';
}
