<?php
$url = 'https://api.themoviedb.org/3/discover/movie?api_key=4d9ca8e7d8e3381c21ffeb6f1306ee32&language=en-US&sort_by=vote_average.desc&include_adult=false&include_video=false&page=1';
$json_data = file_get_contents($url);
$php_data = json_decode($json_data,true);
print_r($php_data);
//print_r($php_contents["results"][0]["id"]); ex) find a specific value in an array inside of another array
//print_r(count($php_contents["results"]));
include 'API_T_WWW.php';
?>
