<?php

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://api.themoviedb.org/3/movie/latest?api_key=ec36674eb700de4ef91cc91d0fd2c966&language=en-US",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "GET",
  CURLOPT_HTTPHEADER => array(
    "cache-control: no-cache",
    "postman-token: 02415d7a-d6a9-6a54-0567-eae65c3da0a2"
  ),
));

$R_Data = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

//if ($err) {
//  echo "cURL Error #:" . $err;
//} else {
//  echo $R_Data;

include ('sender.php');


