<?php
//Api request to tmdb request for top rate movies 

//address of toprate in TMDB
$url = 'https://api.themoviedb.org/3/discover/movie?api_key=ec36674eb700de4ef91cc91d0fd2c966&language=en-US&sort_by=vote_average.desc&include_adult=false&include_video=false&page=1';

//store the result to $json_data.
$json_data = file_get_contents($url);

//convert json data to php array
$php_data = json_decode($json_data,true);

//Return data to Webserever
include 'API_T_WWW.php';//Return data to Webserever

//find a specific value in an array inside of another array
print_r($php_contents["results"][0]["100"]); 
print_r(count($php_contents["results"]));
?>
