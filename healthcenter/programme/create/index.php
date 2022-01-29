<?php
//Require security for HTTP authorization.
require_once($_SERVER['DOCUMENT_ROOT'].'/security.php');

//Check if request is POST else die.
if($_SERVER['REQUEST_METHOD'] == 'POST'){

	//get POST data into a new programme
	require_once($_SERVER['DOCUMENT_ROOT'].'/classes/programme.php');

	$programme = new Programme();
	$programme->type = filter_var($_POST['programme_type'], FILTER_SANITIZE_STRING);
	$programme->start_date = date('Y-m-d H:i:s', intval($_POST['start_date']));
	$programme->end_date = date('Y-m-d H:i:s', intval($_POST['end_date']));
	$programme->participant_limit = intval($_POST['participant_limit']);
	$programme->room_number = intval($_POST['room_number']);

	//Check if dates are ok.
	if($programme->start_date >= $programme->end_date){
		echo 'Error: Dates are invalid';
		die();
	}


	//Check if any values are missing.
	foreach($programme as $key=>$value){
		if(empty($value)){
			echo $key.' has no value!';
			die();
		}
	}

	echo '<pre>';
	print_r($programme);
	echo '</pre>';

	//Get the room for the new programme.
	require_once($_SERVER['DOCUMENT_ROOT'].'/classes/room.php');

	$room = new Room($programme->room_number);

	$room->get_allowed_types();

	echo '<pre>';
	print_r($room);
	echo '</pre>';

	//Check if programme type is available in the room.
	if(in_array($programme->type, $room->allowed_types)){

		//Check if date not already booked.
		if($programme->check_room_availability()){
			//Add new programme to programmes table.
			$programme->create();
		}
		else{
			echo "Error: This room is already booked for this timeslot.";
			die();
		}	
	}
	else{
	    echo "Error: This room doesn't allow this type of programme.";
	    die();
	}

}
else{
	echo "Error: Expecting POST request.";
	die();
}

//INSERT INTO programme_api.rooms (allowed_types) VALUES ("Pilates, Test Programme, Yoga")

?>