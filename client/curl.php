<?php

$jwt = "header.body.signature";
$url = null;

var_dump($argc);
var_dump($argv);

if ($argc > 1)
{
    if ($argv[1] == "auth")
        $url = "http://localhost:8000/client.php/auth";
    else if ($argv[1] == "book")
        $url = "http://localhost:8000/client.php/getBooks?ISBN={$argv[2]}";
    else if ($argv[1] == "movie")
        $url = "http://localhost:8000/client.php/getMovies?Title={$argv[2]}&Year={$argv[3]}&Plot={$argv[4]}";
}
else
{
    $url = "http://localhost:8000/client.php/auth";
}

var_dump($url);

$handle = curl_init($url);
$headers = array(
    "Accept: application/json",
    "Authorization: Bearer {$jwt}",
 );

curl_setopt($handle, CURLOPT_HTTPHEADER, $headers);
curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
curl_setopt($handle, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);

$data = curl_exec($handle);
curl_close($handle);
var_dump($data);

?>