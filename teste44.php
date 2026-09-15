<?php

$verify_token = "196287";

if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    $mode = isset($_GET['hub_mode']) ? $_GET['hub_mode'] : '';
    $token = isset($_GET['hub_verify_token']) ? $_GET['hub_verify_token'] : '';
    $challenge = isset($_GET['hub_challenge']) ? $_GET['hub_challenge'] : '';

    if ($mode == 'subscribe' && $token == $verify_token) {
        echo $challenge;
        exit;
    }

    http_response_code(403);
    exit;
}

// Receber mensagens
$body = file_get_contents("php://input");
file_put_contents("webhook.log", $body . PHP_EOL, FILE_APPEND);

http_response_code(200);
echo "EVENT_RECEIVED";