<?php
include_once '../config/global.php';

function loadClasses(){
    $paths = glob( '../libraries/class.*.php' );
    foreach($paths as $path){
        require_once($path);
    }
}
loadClasses();

Core::loadCss();

echo '<link rel="shortcut icon" href="' . APP_URL . 'assets/img/favicon.ico" />';
echo '<meta name="author" content="Michael Risher" />';
echo '<meta name="url" content="' . APP_URL . '" />';





	
