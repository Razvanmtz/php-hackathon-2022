<?php

	echo 'Test call for api: Register new programme<br><br>';


	//URL
    $url = 'http://localhost/programme/create';

    $start_date = '11-02-2022 10:00';
    $end_date = '11-02-2022 11:00';


    $headers = array(
   		"X-Authorization: w+R&5-eKa:[}MqfG",
	);

    $post_data = array(
    	'programme_type' => 'Yoga',
    	'start_date' => strtotime($start_date),
    	'end_date' => strtotime($end_date),
    	'participant_limit' => 2,
    	'room_number' => 2,
    );

    $curl = curl_init();
    curl_setopt($curl,CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_POSTREDIR, 3);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $post_data);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
	curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);


    $result = curl_exec($curl);

    curl_close($curl);

    print_r(json_decode($result));


	exit;
?>