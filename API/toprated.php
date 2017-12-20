<?php
$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://api.themoviedb.org/3/movie/top_rated?api_key=ec36674eb700de4ef91cc91d0fd2c966&language=en-US&page=1",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "GET",
  CURLOPT_HTTPHEADER => array(
    "cache-control: no-cache",
    "postman-token: 5a7d595b-7052-09fe-ae9e-6c3ba8d74129"
  ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

include ('sender.php');


//if ($err) {
//  echo "cURL Error #:" . $err;
//} else {
//  echo $response;


