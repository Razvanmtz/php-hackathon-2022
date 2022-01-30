<?php

class Room {

	public $allowed_types;
	public $room_number;


	public function __construct($room_number) {
        $this->room_number = $room_number;
    }

	public function get_allowed_types(){

		$sql = 'SELECT allowed_types FROM programme_api.rooms WHERE id='.$this->room_number;

		$db_conn = mysqli_connect('localhost', 'root', '123456');

		$result = mysqli_query($db_conn, $sql);

		if(mysqli_num_rows($result) > 0){
			while($row = mysqli_fetch_assoc($result)){

				$this->allowed_types = explode(', ', $row['allowed_types']);
			}
			return true;
		}
		else{
			return false;
		}
	}
}


?>