<?php

//Search API 

//extract movie name from data received from Webserver and store it to the $movie_name
$movie_name = $data["M_name"];

//store the url of the search with the variable $movie_name
$url = 'http://api.themoviedb.org/3/search/movie?api_key=ec36674eb700de4ef91cc91d0fd2c966&language=en-US&query='.$movie_name.'&page=1&include_adult=false';

//receive the data and store it to $json_data
$json_data = file_get_contents($url);

//convert json data to php array
$php_data = json_decode($json_data,true);

//send the result to Webserver
include 'API_T_WWW.php';

print_r($php_data);

?>
