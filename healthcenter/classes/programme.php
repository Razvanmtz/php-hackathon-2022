<?php

class Programme {

	public $type;
	public $start_date;
	public $end_date;
	public $participant_limit;
	public $room_number;

	public function __construct($type = '', $start_date = '', $end_date = '', $participant_limit = 0, $room_number = 0){
		$this->type = $type;
		$this->start_date = $start_date;
		$this->end_date = $end_date;
		$this->participant_limit = $participant_limit;
        $this->room_number = $room_number;
    }

	public function check_room_availability(){

		$sql = 'SELECT id FROM programme_api.programmes
		WHERE ( "'.$this->start_date.'" <= start_date AND "'.$this->end_date.'" >= start_date )
		OR ( "'.$this->start_date.'" <= end_date AND "'.$this->end_date.'" >= start_date )
		AND room_number = '.$this->room_number;

		$db_conn = mysqli_connect('localhost', 'root', '123456');

		$result = mysqli_query($db_conn, $sql);

		if(mysqli_num_rows($result) <= 0){
			return true;
		}

		return false;
	}

	public function create(){
		$sql = 'INSERT INTO programme_api.programmes (type, start_date, end_date, participant_limit, room_number) VALUES ("'.$this->type.'", "'.$this->start_date.'", "'.$this->end_date.'", '.$this->participant_limit.', '.$this->room_number.')';

		$db_conn = mysqli_connect('localhost', 'root', '123456');

		mysqli_query($db_conn, $sql);
	}

	public function get($id){
		$sql = 'SELECT * FROM programme_api.programmes WHERE id='.$id;

		$db_conn = mysqli_connect('localhost', 'root', '123456');

		$result = mysqli_query($db_conn, $sql);

		if(mysqli_num_rows($result) > 0){
			return true;
		}

		return false;
	}

	public function delete($id){

		$sql = 'DELETE FROM programme_api.programmes WHERE id='.$id;

		$db_conn = mysqli_connect('localhost', 'root', '123456');

		mysqli_query($db_conn, $sql);

	}

}


?>