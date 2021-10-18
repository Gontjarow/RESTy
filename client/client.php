<?php

require_once("../server/config.php");
require_once("../server/endpoint.php");

$uri = explode("/", $_SERVER["PATH_INFO"]);
parse_str($_SERVER["QUERY_STRING"], $query);

// I can't tell if this kinda defeats the purpose of being a client.
$endpoint = new Endpoint();

// todo: Request JWT and include it.
// Endpoint will require/verify it.

$endpoint->{$uri[1]}($query);

?>
