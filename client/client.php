<?php

require_once("../server/config.php");
require_once("../server/endpoint.php");

$uri = explode("/", $_SERVER["PATH_INFO"]);
parse_str($_SERVER["QUERY_STRING"], $query);

$endpoint = new Endpoint();

$endpoint->{$uri[1]}($query);

?>
