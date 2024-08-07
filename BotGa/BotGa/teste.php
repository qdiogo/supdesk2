<?php
error_reporting(0);
function check_nomor($nomor){
	$headers = array();
	$headers[] = 'user-agent: Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Mobile Safari/537.36';
	$ch2 = curl_init();
	curl_setopt($ch2, CURLOPT_URL,"https://api.whatsapp.com/send/?phone=71991669809&text&type=phone_number&app_absent=0");
	curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch2, CURLOPT_FOLLOWLOCATION,true); 
	curl_setopt($ch2, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($ch2, CURLOPT_TIMEOUT, 15);
	curl_setopt($ch2, CURLOPT_ENCODING, 'gzip, deflate');
	$result2z = curl_exec($ch2);
	$pisah1 = explode('<h3 class="_9vd5 _9scb _9scr">',$result2z);
	$pisah1 = explode('</h3>',$pisah1[1]);
	$nama = $pisah1[0];
	if($nama){
		return json_encode(array("result"=>"true","contact_name"=>"$nama"));
	}else{
		return json_encode(array("result"=>"false"));;
	}
}
mulaibot:
echo "First Range Number (ex : 6287790120800) : ";
$awal = trim(fgets(STDIN));
echo "Last Range Number  (ex : 6287790120900) : ";
$akhir = trim(fgets(STDIN));

goto mulaibot;
?>