
<?php

require __DIR__ . '/vendor/autoload.php';

$client = new JsonRPC\Client('http://10.129.20.177/kanboard/jsonrpc.php');
$client->authentication('jsonrpc', 'aee3c44bfae2be8604cb560d907b3a73ebf189689c4a45d64a7f6a1af5c7');
$result = $client->execute({ "jsonrpc" => "2.0", "method" =>  "createTask", "id" =>  1176509098, "params" =>  { "owner_id" =>  1, "creator_id" =>  0, "date_due" =>  "", "description" =>  "", "category_id" =>  0, "score" =>  0, "title" =>  "Test", "project_id" =>  11, "color_id" =>  "green", "column_id" =>  42, "recurrence_status" =>  0, "recurrence_trigger" =>  0, "recurrence_factor" =>  0, "recurrence_timeframe" =>  0, "recurrence_basedate" =>  0 } });
