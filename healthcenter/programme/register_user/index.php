<?php
//Require security for HTTP authorization.
require_once($_SERVER['DOCUMENT_ROOT'].'/security.php');

function check_cnp($cnp){

	$cnp_year = (int)('20'.substr($cnp, 1, 2));

	if($cnp_year > date('Y'))
		$cnp_year = $cnp_year - 100;

	if(strlen($cnp) != 13){
		return false;
	}
	elseif(!in_array(substr($cnp, 0, 1), array('1', '2'))){
		return false;
	}
	elseif(checkdate(substr($cnp, 3, 2), substr($cnp, 5, 2), $cnp_year) === false){
		return false;
	}

	return true;
}

//Check if request is POST else die.
if($_SERVER['REQUEST_METHOD'] == 'POST'){

	//Get registration data from POST.
	$user_id = intval($_POST['user_id']);
	$programme_id = intval($_POST['programme_id']);

	//Check if programme exists.
	require_once($_SERVER['DOCUMENT_ROOT'].'/classes/programme.php');

	$programme = new Programme();

	if($programme->get($programme_id) === false){
		echo "Error: No programme with id = ".$programme_id." found";
		die();
	}
	else{
		//Check if user exists or if new user, then register user to programme.
		require_once($_SERVER['DOCUMENT_ROOT'].'/classes/user.php');

		$user = new User($user_id);

		if($user->user_exists()){

			//Check if user is not already registered to another curse in the same timeslot.

			if($user->is_user_already_registered_timeslot($programme)){
				echo "Error: User is already registered to a programme in the same timeslot.";
				die();
			}

			$user->register_user_to_programme($programme->id);
		}
		else{
			//Check if valid CNP
			if(check_cnp($user->id)){

				//Add user and register him to programme.
				$user->add();
				$user->register_user_to_programme($programme_id);

				echo json_encode(array('Success' => 'Succesfully registered user to programme', 'user_id'=>$user->id, 'programme_id'=>$programme_id));
				
			}
			else{
				echo "Error: Invalid user_id (CNP).";
				die();
			}
		}
	}
}
else{
	echo "Error: Expecting POST request.";
	die();
}

?>