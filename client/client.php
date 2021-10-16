<?php

require_once("../server/config.php");

$category = $_POST["Category"];
$input = $_POST["Search"];

if (empty($category) && empty($input))
    exit();
if (empty($category) || empty($input))
    exit("Invalid search!");

$endpoint = new Endpoint();

// This could be generalized by building the function call
// from the query string directly. eg.
// $function_name = "get"."Books"."ISBN".(input);
// $function_name = "get"."Movies"."IMDB".(input);
// $function_name = "get"."Movies"."Title".(input);
// $endpoint->{$function_name}($input);

if ($category == "Books")
{
    $endpoint->getBookByISBN($input);
}
else if ($category == "Movies")
{
    if (strncmp($input, "tt", 2) == 0)
        $endpoint->getMovieByIMDBId($input);
    else
        $endpoint->getMovieByTitle($input);
}

?>
