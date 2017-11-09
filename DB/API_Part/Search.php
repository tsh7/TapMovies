<?php
$movie_name = $data["M_name"];
$url = 'http://api.themoviedb.org/3/search/movie?api_key=4d9ca8e7d8e3381c21ffeb6f1306ee32&language=en-US&query='.$movie_name.'&page=1&include_adult=false';
$json_data = file_get_contents($url);
$php_data = json_decode($json_data,true);
print_r($php_data);//print_r(); -> you want to see the result in commend prompt
//print_r($php_contents["results"][0]["id"]); ex) find a specific value in an array inside of another array
//print_r(count($php_contents["results"]));
include 'API_T_WWW.php';
?>
