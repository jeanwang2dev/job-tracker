<?php

/* 
	I set the includes folder as the include_path in the .htaccess file
    so I only need to use include('autoload.php'); once in every page 
*/
/* autoload classes for whenever needs */

spl_autoload_register( 'my_autoload_register' );

function my_autoload_register($className){	
    
    if (is_file($_SERVER["DOCUMENT_ROOT"]. '/job-tracker/classes/' . $className . '.php')) {  	
        require_once $_SERVER["DOCUMENT_ROOT"] . '/job-tracker/classes/'. $className . '.php';
    }
 
}