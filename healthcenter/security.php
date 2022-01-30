<?php

$allowed_users = array(
	'John' => 'w+R&5-eKa:[}MqfG',
	'Alex' => 'j2f^/C/cUkH_$?@U',
);

if(!in_array($_SERVER['HTTP_X_AUTHORIZATION'], $allowed_users)){
 	echo json_encode(array('Error' => 'Wrong authorization code'));
 	die();
}


?>