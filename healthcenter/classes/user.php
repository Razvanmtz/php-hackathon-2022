<?php

class User {

	public $id;


	public function __construct($user_id) {
        $this->id = $user_id;
    }

	public function user_exists(){

		$sql = 'SELECT id FROM programme_api.users WHERE id='.$this->id;

		$db_conn = mysqli_connect('localhost', 'root', '123456');

		$result = mysqli_query($db_conn, $sql);

		if(mysqli_num_rows($result) > 0){
			return true;
		}

		return false;
	}

	public function add(){
		
		$sql = 'INSERT INTO programme_api.users (id) VALUES ('.$this->id.')';

		$db_conn = mysqli_connect('localhost', 'root', '123456');

		mysqli_query($db_conn, $sql);
	}

	public function register_user_to_programme($programme_id){
		$sql = 'INSERT INTO programme_api.registrations (user_id, programme_id) VALUES ('.$this->id.', '.$programme_id.')';

		$db_conn = mysqli_connect('localhost', 'root', '123456');

		mysqli_query($db_conn, $sql);
	}

	public function is_user_already_registered_timeslot($programme){

		$sql = 'SELECT * FROM programme_api.registrations r LEFT JOIN programme_api.programmes p on p.id=r.programme_id
		WHERE user_id='.$this->id.'
		AND ( "'.$programme->start_date.'" <= p.start_date AND "'.$programme->end_date.'" >= p.start_date )
		OR ( "'.$programme->start_date.'" <= p.end_date AND "'.$programme->end_date.'" >= p.start_date )';

		$db_conn = mysqli_connect('localhost', 'root', '123456');

		$result = mysqli_query($db_conn, $sql);

		if(mysqli_num_rows($result) > 0){
			return true;
		}

		return false;
	}
}


?>