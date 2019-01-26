<?php

$curl = curl_init();

$id = 01;
$description = "Detalle";
$title = "Titulo de Tarea"; 
$project_id = 11;
$column_id = 42;

$cadenaRapida = "{ \"jsonrpc\": \"2.0\", \"method\": \"createTask\", \"id\": " . $id . ", \"params\": { \"owner_id\": 1, \"creator_id\": 0, \"date_due\": \"\", \"description\": \"" . $description . "\", \"category_id\": 0, \"score\": 0, \"title\": \"" . $title .  "\", \"project_id\": " . $project_id . ", \"color_id\": \"green\", \"column_id\": " . $column_id . ", \"recurrence_status\": 0, \"recurrence_trigger\": 0, \"recurrence_factor\": 0, \"recurrence_timeframe\": 0, \"recurrence_basedate\": 0 } }";

echo $cadenaRapida;

curl_setopt_array($curl, array(
  CURLOPT_URL => "http://10.129.20.177/kanboard/jsonrpc.php",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => $cadenaRapida,
  CURLOPT_HTTPHEADER => array(
    "authorization: Basic anNvbnJwYzphZWUzYzQ0YmZhZTJiZTg2MDRjYjU2MGQ5MDdiM2E3M2ViZjE4OTY4OWM0YTQ1ZDY0YTdmNmExYWY1Yzc=",
    "cache-control: no-cache",
    "content-type: application/json",
    "postman-token: 6f7211a7-99df-f951-788c-3274e311bb7b"
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
