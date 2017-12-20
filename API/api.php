<?php

$request = new HttpRequest();
$request->setUrl('https://api.themoviedb.org/3/movie/550');
$request->setMethod(HTTP_METH_GET);

$request->setQueryData(array(
  'api_key' => 'ec36674eb700de4ef91cc91d0fd2c966'
));

$request->setHeaders(array(
  'postman-token' => '63dbfe6f-f143-2c40-b3be-0bb858a6d9cd',
  'cache-control' => 'no-cache'
));

try {
  $response = $request->send();

  echo $response->getBody();
} catch (HttpException $ex) {
  echo $ex;
}

?>
