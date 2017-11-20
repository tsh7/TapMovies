<?php
// RecentMovie process will run when the Webserver request for it to access data from TMDB and get result.  
// RecentMovie address in TMDB 
$url = 'https://api.themoviedb.org/3/movie/latest?api_key=4d9ca8e7d8e3381c21ffeb6f1306ee32&language=en-US';
// stores the json data result
$json_data = file_get_contents($url);
//converts data from json to php array 
$php_data = json_decode($json_data,true);
//returns data to webserver 
include 'API_T_WWW.php';
print_r($php_data);//test purpose only 
//End of the code 
?>

