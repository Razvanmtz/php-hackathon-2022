<?php

class Programme {

	public $type;
	public $start_date;
	public $end_date;
	public $participant_limit;
	public $room_number;
	public $id;

	public function __construct($type = '', $start_date = '', $end_date = '', $participant_limit = 0, $room_number = 0){
		$this->type = $type;
		$this->start_date = $start_date;
		$this->end_date = $end_date;
		$this->participant_limit = $participant_limit;
        $this->room_number = $room_number;
    }

	public function is_room_available(){

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

		return mysqli_insert_id($db_conn);
	}

	public function get($id){
		$sql = 'SELECT * FROM programme_api.programmes WHERE id='.$id;

		$db_conn = mysqli_connect('localhost', 'root', '123456');

		$result = mysqli_query($db_conn, $sql);

		if(mysqli_num_rows($result) > 0){
			while($row = mysqli_fetch_assoc($result)){
				foreach($row as $key=>$value){
					$this->$key = $value;
				}
			}
			return true;
		}

		return false;
	}

	public function delete($id){

		$sql = 'DELETE FROM programme_api.registrations WHERE programme_id='.$id;

		$db_conn = mysqli_connect('localhost', 'root', '123456');

		mysqli_query($db_conn, $sql);

		$sql = 'DELETE FROM programme_api.programmes WHERE id='.$id;

		mysqli_query($db_conn, $sql);

	}

	public function is_programme_full(){

		$sql = 'SELECT p.participant_limit, count(r.id) as "registrations" FROM programme_api.programmes p INNER JOIN programme_api.registrations r on r.programme_id=p.id WHERE p.id='.$this->id;

		$db_conn = mysqli_connect('localhost', 'root', '123456');

		$result = mysqli_query($db_conn, $sql);

		if(mysqli_num_rows($result) > 0){
			while($row = mysqli_fetch_assoc($result)){
				foreach($row as $key=>$value){
					if($row['participant_limit'] <= $row['registrations']){
						return true;
					}
				}
			}
		}

		return false;
	}
}


?>