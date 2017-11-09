<?php
//This processes toprate by the request of Webserver. It accesses TMDB and get the result of toprated

//Start toprate task
//address of toprate in TMDB
$url = 'https://api.themoviedb.org/3/discover/movie?api_key=4d9ca8e7d8e3381c21ffeb6f1306ee32&language=en-US&sort_by=vote_average.desc&include_adult=false&include_video=false&page=1';

//store the result to $json_data.
$json_data = file_get_contents($url);

//convert json data to php array
$php_data = json_decode($json_data,true);

include 'API_T_WWW.php';//Return data to Webserever
//Ends 

print_r($php_data);//test purpose
//print_r($php_contents["results"][0]["id"]); ex) find a specific value in an array inside of another array
//print_r(count($php_contents["results"]));
?>
