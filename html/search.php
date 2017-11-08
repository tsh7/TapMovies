<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
require_once __DIR__ . '/vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
//change rabbitmq ip here
$rmq_ip   = '192.168.1.201';
$rmq_port = '5672';
$rmq_user = 'admin';
$rmq_pass = 'guest';
$rmq_que  = 'WWW_API';
//include 'userAccount.php';
?>
<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Search Result</title>

    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/modern-business.css" rel="stylesheet">

  </head>

  <body>

    <!-- Navigation -->

    <nav class="navbar fixed-top navbar-expand-lg navbar-dark bg-dark fixed-top">
      <div class="container">
        <a class="navbar-brand" href="index.html">Tap Movies</a>
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item">
              <a class="nav-link" href="index.html">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="gen.html">Genres</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="atoz.html">A-Z List</a>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownPortfolio" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                My Account
              </a>
              <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownPortfolio">
                <a class="dropdown-item" href="login.php">Login</a>
                <a class="dropdown-item" href="registration.php">Register</a>
              </div>
            </li>

          </ul>
        </div>
      </div>
    </nav>

    <h5>
      <?php
    /* working locally
        include 'tmdb-api.php';
        // if you have no $conf it uses the default config
        $tmdb = new TMDB();
        //Insert your API Key of TMDB
        //Necessary if you use default conf
        $tmdb->setAPIKey('ec36674eb700de4ef91cc91d0fd2c966');

        $searchForm = $_POST["searchForm"];
        //Title to search for
        $movies = $tmdb->searchMovie($searchForm);
        // returns an array of Movie Object
        foreach ($movies as $movie) {
          $movieTitle = $movie->getTitle();
          $_SESSION['movieID'] = $movie->getID();
          echo "<li><a href='moviedetail.php'> $movieTitle </a></li>";
        }
    */
    $searchForm = $_POST["searchForm"];
    $urlLink = "https://api.themoviedb.org/3/search/movie?api_key=ec36674eb700de4ef91cc91d0fd2c966&language=en-US&query={$searchForm}&page=1&include_adult=false";
    $someJSON = file_get_contents($urlLink);

    $jsonarray = json_decode($someJSON);
    //print_r($jsonarray);
    //$title = $jsonarray['results'][0];
    echo "<pre>";
    foreach ($jsonarray->results as $mydata) {
        echo $mydata->title . "<br>";
    }
    echo "</pre>";
    //RABBITMQ search send
    //encode information in json
    $data = json_encode($searchForm);

    $connection = new AMQPStreamConnection($rmq_ip, $rmq_port, $rmq_user, $rmq_pass);
    $channel = $connection->channel();

    $channel->queue_declare($rmq_que, false, false, false, false);

    $msg = new AMQPMessage($data, array('delivery_mode' => 2));
    $channel->basic_publish($msg, '', $rmq_que);
    $channel->close();
    $connection->close();
    include 'searchReceiver.php';
    ?>
    </h5>

    <!-- Page Content -->
	<div class="container" >

      <!-- Call to Action Section -->

      <div class="row mb-4">
        <div class="col-md-8">
          <p>  Having Any Issue?</p>
        </div>
        <div class="col-md-4">
          <a class="btn btn-lg btn-secondary btn-block" href="#">Contact Us</a>
        </div>
      </div>
	</div>
    </div>
    <!-- /.container -->

    <!-- Footer -->
    <footer class="py-5 bg-dark">
      <div class="container">
        <p class="m-0 text-center text-white">Copyright &copy; Tap Movies 2017</p>
      </div>
      <!-- /.container -->
    </footer>

    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/popper/popper.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>

  </body>

</html>
