<?php

//Search API 

//extract movie name from data received from Webserver and store it to the $movie_name
$movie_name = $data["M_name"];

//store the url of the search with the variable $movie_name
$url = 'http://api.themoviedb.org/3/search/movie?api_key=4d9ca8e7d8e3381c21ffeb6f1306ee32&language=en-US&query='.$movie_name.'&page=1&include_adult=false';

//receive the data and store it to $json_data
$json_data = file_get_contents($url);

//convert json data to php array
$php_data = json_decode($json_data,true);

//send the result to Webserver
include 'API_T_WWW.php';

print_r($php_data);

?>
