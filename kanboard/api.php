<?php

require __DIR__ . '/vendor/autoload.php';

$client = new JsonRPC\Client('http://10.129.20.177/kanboard/jsonrpc.php');
$client->authentication('jsonrpc', 'aee3c44bfae2be8604cb560d907b3a73ebf189689c4a45d64a7f6a1af5c7');

print_r($client->getAllProjects());
