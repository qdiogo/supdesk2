<?php
 $url = "https://semysms.net/api/3/sms_more.php"; //Url address for sending SMS
 $device = '247592';  // Phone number
 $token = '4aa518362a5d3d2a184ac53aad0dca2c';  // Your token (secret)

 $params = array('token'  => $token);

 for ($index = 1; $index <= $max_count; $index++) { //  Fill the array in a loop with phone numbers, messages and codes devices
   $params['data'][] = array(
            'my_id' => 'SMS code from your accounting system (it will come back with semysms system code)',
            'device' => $device, 'phone' => $phone, 'msg' => $msg);
 }

 $params = json_encode($params);

 $curl = curl_init($url);
 curl_setopt($curl, CURLOPT_URL, $url); 
 curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
 curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
 curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
 curl_setopt($curl, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json',
    'Content-Length: ' . strlen($params))
  );
 curl_setopt($curl, CURLOPT_POST, true);
 curl_setopt($curl, CURLOPT_POSTFIELDS,  $params);
 $result = curl_exec($curl);
 curl_close($curl);	   
 echo  $result;
?>