<?php
//This processes movie search, connect to the TMDB and receive data, with the movie name received from the Webserver

//Start
$movie_name = $data["M_name"];//extract movie name from data received from Webserver and store it to the $movie_name
//store the url of the search with the variable $movie_name
$url = 'http://api.themoviedb.org/3/search/movie?api_key=4d9ca8e7d8e3381c21ffeb6f1306ee32&language=en-US&query='.$movie_name.'&page=1&include_adult=false';
$json_data = file_get_contents($url);//receive the data and store it to $json_data
$php_data = json_decode($json_data,true);//convert json data to php array
include 'API_T_WWW.php';//send the result to Webserver
//end

print_r($php_data);//print_r(); -> you want to see the result in commend prompt. print_r() is to print php array. echo does not work
//print_r($php_contents["results"][0]["id"]); ex) find a specific value in an array inside of another array
//print_r(count($php_contents["results"])); // find how many movies you received from TMDB
?>
