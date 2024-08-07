<?php
$url = 'http://localhost:8000/Zapx-message';

$fields = array("number"=>"5571991669809","message"=>"teste");
$fields = json_encode($fields);

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);

curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json; charset=utf-8' 
  ));
$result = curl_exec($ch);
print_r( "Resultado ".$result[0]['status']);

curl_close($ch);
?>