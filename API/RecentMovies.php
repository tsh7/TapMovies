<?php
// RecentMovie process will run when the WWW request for it to access data then send it back to WWW.   
// RecentMovie api link in TMDB 
$url = 'https://api.themoviedb.org/3/movie/latest?api_key=ec36674eb700de4ef91cc91d0fd2c966&language=en-US';
// stores the json data result
$json_data = file_get_contents($url);
//converts data from json to php array 
$php_data = json_decode($json_data,true);
//returns data to webserver 
include 'API_T_WWW.php';
print_r($php_data);//test purpose only 
//End of the code 
?>

