<?php

	echo 'Test call for api: Delete programme<br><br>';


	//URL
    $url = 'http://localhost/programme/create';


    $headers = array(
   		"X-Authorization: w+R&5-eKa:[}MqfG",
	);

    $post_data = array(
        'programme_id' => 1,
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

    echo $result;


	exit;
?>