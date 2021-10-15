#!/usr/local/bin/php -q
<?php

$socket  = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
assert($socket, socket_strerror(socket_last_error()));

$address = "127.0.0.1";
$port    = 8000;

$connected = socket_connect($socket, $address, $port);
assert($connected, socket_strerror(socket_last_error()));

echo "Connected!\n";


$message = "Test";
$status = socket_sendto($socket, $message, strlen($message), 0, $address, $port);

if ($status === FALSE)
{
    exit("Failed to send.");
}

echo "Got this far!\n";

// Get response from endpoint?
// Warn: Waits forever if no response.
//echo socket_read($socket, 4096);

socket_close($socket);

?>
