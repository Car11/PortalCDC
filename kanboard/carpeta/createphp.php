<?php

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "http://10.129.20.177/kanboard/jsonrpc.php",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => "{\r\n    \"jsonrpc\": \"2.0\",\r\n    \"method\": \"createTask\",\r\n    \"id\": 1176509098,\r\n    \"params\": {\r\n        \"owner_id\": 1,\r\n        \"creator_id\": 0,\r\n        \"date_due\": \"\",\r\n        \"description\": \"JSON ROJAS\",\r\n        \"category_id\": 0,\r\n        \"score\": 0,\r\n        \"title\": \"Test\",\r\n        \"project_id\": 11,\r\n        \"color_id\": \"green\",\r\n        \"column_id\": 42,\r\n        \"recurrence_status\": 0,\r\n        \"recurrence_trigger\": 0,\r\n        \"recurrence_factor\": 0,\r\n        \"recurrence_timeframe\": 0,\r\n        \"recurrence_basedate\": 0\r\n    }\r\n}",
  CURLOPT_HTTPHEADER => array(
    "authorization: Basic anNvbnJwYzphZWUzYzQ0YmZhZTJiZTg2MDRjYjU2MGQ5MDdiM2E3M2ViZjE4OTY4OWM0YTQ1ZDY0YTdmNmExYWY1Yzc=",
    "cache-control: no-cache",
    "content-type: application/json",
    "postman-token: c8729d74-e29e-b0bc-c4d3-8ee9687a1bc2"
  ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
} else {
  echo $response;
}
