<?php
//Require security for HTTP authorization.
require_once($_SERVER['DOCUMENT_ROOT'].'/security.php');

//Check if request is POST else die.
if($_SERVER['REQUEST_METHOD'] == 'POST'){

	require_once($_SERVER['DOCUMENT_ROOT'].'/classes/programme.php');

	$programme = new Programme();
	$programme_id = intval($_POST['id']);

	//Check if programme exists.
	if($programme->get($programme_id)){
		$programme->delete($programme_id);
	}
	else{
		echo "Error: No programme with id = ".$programme_id." found";
	}

}
else{
	echo "Error: Expecting POST request.";
	die();
}

?>