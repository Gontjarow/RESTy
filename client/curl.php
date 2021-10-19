<?php

$jwt = "header.body.signature";
$url = null;

if ($argc > 1 && $argv[1] != "auth")
{
    if ($argv[1] == "book")
    {
        $argv[2] = $argv[2] ?? "";
        $url = "http://localhost:8000/search.php/getBooks?ISBN={$argv[2]}";
    }
    else if ($argv[1] == "movie")
    {
        $argv[2] = $argv[2] ?? "";
        $argv[3] = $argv[3] ?? "";
        $argv[4] = $argv[4] ?? "";
        $url = "http://localhost:8000/search.php/getMovies?Title={$argv[2]}&Year={$argv[3]}&Plot={$argv[4]}";
    }
    else
    {
        echo "commands: auth, book (ISBN), movie (Title) [Year] [Plot]\n";
    }
}
else
{
    $url = "http://localhost:8000/search.php/auth";
}

if (!empty($url))
{
    $handle = curl_init($url);
    $headers = array(
        "Accept: application/json",
        "Authorization: Bearer {$jwt}",
     );

    curl_setopt($handle, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);

    $data = curl_exec($handle);
    curl_close($handle);
    echo $data."\n";
}

?>