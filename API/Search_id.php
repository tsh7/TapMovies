<?php
//This processes movie search by id and connect to the tmdb and gets result 

$movie_id = $data["M_id"];//extract movie name from data received from Webserver and store it to the $movie_name

// url for search_id api 
$url = 'http://api.themoviedb.org/3/search/movie?api_key=ec36674eb700de4ef91cc91d0fd2c966&language=en-US&query='.$movie_id.'&page=1&include_adult=false';

//gets the data and save it in json 
$json_data = file_get_contents($url);

//convert json to php 
$php_data = json_decode($json_data,true);

//send the result to WWW
include 'API_T_WWW.php';

?>
