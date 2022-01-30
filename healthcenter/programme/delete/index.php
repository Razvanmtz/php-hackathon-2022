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
		echo json_encode(array('Success' => 'Succesfully deleted the programme and all linked registrations', 'programme_id'=>$new_programme_id));
	}
	else{
		echo json_encode(array('Error' => 'No programme with id = '.$programme_id.' found'));
		die();
	}

}
else{
	echo json_encode(array('Error' => "Expecting POST request."));
	die();
}

?>