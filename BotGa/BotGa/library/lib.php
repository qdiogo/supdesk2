<?php

function getConection() {
    try {
        $pdo = new PDO('mysql:host=localhost;dbname=botga;charset=utf8', 'root', 'root');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch(PDOException $e) {
        echo 'ERROR: ' . $e->getMessage();
    }
}

function apiParameters() {
    return [
        "url" => "https://api5.megaapi.com.br/rest/",
        "instance" => "megaapi-Md0ome2gXcl9Nnhf4kYPDQ8pfs",
        "token" => "Md0ome2gXcl9Nnhf4kYPDQ8pfs",
    ];
}

function listProduts() {
    $pdo = getConection();
    $query = "SELECT `id`, `description`, FORMAT(`value`, 2, 'de_DE') AS value FROM products";
    $sql = $pdo->prepare($query);
    $sql->execute();

    $result = $sql->fetchAll();
    $list = "";
    if(count($result)>0) {
        foreach($result as $row) {
            $list .= "*{$row['id']}* - {$row['description']} -> {$row['value']}\n";
        }
    }
    return $list;
}

function statusConversation($param) {
    $pdo = getConection();
    $query = "SELECT COUNT(*) AS count FROM conversations WHERE phone = :param";
    $sql = $pdo->prepare($query);
    $sql->bindValue(":param", $param);
    $sql->execute();

    $result = $sql->fetchAll();

    if($result[0]['count'] == 0) {
        return false;
    } else {
        return true;
    }
}

function lastCode($param) {
    $pdo = getConection();
    $query ="SELECT code FROM conversations WHERE phone = :param ORDER BY id DESC";
    $sql = $pdo->prepare($query);
    $sql->bindValue(":param", $param);
    $sql->execute();

    $result = $sql->fetchAll();

    if(count($result)>0) {
        return $result[0]['code'];
    } else {
        return false;
    }
}

function checkCustomer($param) {
    $pdo = getConection();
    $query ="SELECT COUNT(*) AS count FROM customers WHERE phone = :param";
    $sql = $pdo->prepare($query);
    $sql->bindValue(":param", $param);
    $sql->execute();

    $result = $sql->fetchAll();

    if($result[0]['count'] == 0) {
        return false;
    } else {
        return true;
    }
}

function checkProduct($param) {
    $pdo = getConection();
    $query = "SELECT COUNT(*) AS count FROM products WHERE id = :param";
    $sql = $pdo->prepare($query);
    $sql->bindValue(":param", $param);
    $sql->execute();

    $result = $sql->fetchAll();

    if($result[0]['count'] == 0) {
        return false;
    } else {
        return true;
    }
}

function addCustomer($params) {
    $pdo = getConection();
    $query ="INSERT INTO customers (`name`, `phone`) VALUES (?, ?)";
    $sql = $pdo->prepare($query);
    $sql->bindValue(1, $params['name']);
    $sql->bindValue(2, $params['phone']);

    if($sql->execute()) {
        return true;
    } else {
        return false;
    }
}

function addRequest($params) {
    $pdo = getConection();
    $query ="INSERT INTO requests (`customer`, `product`) VALUES (?, ?)";
    $sql = $pdo->prepare($query);
    $sql->bindValue(1, $params['customer']);
    $sql->bindValue(2, $params['product']);

    if($sql->execute()) {
        return $pdo->lastInsertId();
    } else {
        return false;
    }
}

function addConversation($params) {
    $pdo = getConection();
    $query ="INSERT INTO conversations (`code`, `phone`, `request`, `product`, `content`) VALUES (?, ?, ?, ?, ?)";
    $sql = $pdo->prepare($query);
    $sql->bindValue(1, $params['code']);
    $sql->bindValue(2, $params['phone']);
    $sql->bindValue(3, (!empty($params['request']))?:NULL);
    $sql->bindValue(4, (!empty($params['product']))?:NULL);
    $sql->bindValue(5, $params['content']);

    if($sql->execute()) {
        return true;
    } else {
        return false;
    }
}

function sendMessage($params) {
    $settings = apiParameters();
    $postfields = [
        "messageData" => [
            "to" => $params["to"],
            "text" => $params["text"]
        ]
    ];
    
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => "{$settings["url"]}sendMessage/{$settings["instance"]}/text",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => json_encode($postfields),
        CURLOPT_HTTPHEADER => array(
            "Content-Type: application/json",
            "Authorization: Bearer {$settings["token"]}"
        ),
    ));
    $response = curl_exec($curl);
    curl_close($curl);
	echo $response;
}