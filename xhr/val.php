<?php

require_once( dirname(__FILE__). '/../includes/autoload.php' );

$validate = new Validation();

/* get the data*/
$data = $_POST['data'];
/* decode the data: change a string to an object(associative array) */
$data = json_decode($data, true);
//print_r($data);

/* if there is a file, get the file and validate the data and the file if there is one */
if(isset($_FILES['file'])){

	$file = $_FILES['file'];
	$data = $validate->validate($data,$file);
	 
}
else{
	
	$data = $validate->validate($data);
	 
}


if($data == 'success'){
	echo "success";
}
else {
	$data = json_encode($data);
	echo $data;
}
