<?php

if(!isset($_GET['email'])){
    echo "empty";
} else{

$ch = curl_init();
$ch2 = curl_init();
curl_setopt($ch2, CURLOPT_URL, 'https://ldd.landbank.com/ws/api/application/personal');
curl_setopt($ch2, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch2, CURLOPT_POST, 1);
curl_setopt($ch2, CURLOPT_POSTFIELDS, '{"appTypeCode": "P","appSubtypeCode": "10"}');
curl_setopt($ch2, CURLOPT_ENCODING, 'gzip, deflate');
 
$headers2 = array();
$headers2[] = 'Connection: keep-alive';
$headers2[] = 'Sec-Ch-Ua: ';
$headers2[] = 'Accept: application/json, text/plain, */*';
$headers2[] = 'Content-Type: application/json';
$headers2[] = 'Sec-Ch-Ua-Mobile: ?0';
$headers2[] = 'Sec-Ch-Ua-Platform: Windows\"\"';
$headers2[] = 'Origin: https://dobs.landbank.com';
$headers2[] = 'Sec-Fetch-Site: same-origin';
$headers2[] = 'Sec-Fetch-Mode: cors';
$headers2[] = 'Sec-Fetch-Dest: empty';
$headers2[] = 'Referer: https://dobs.landbank.com/DOBS/home/acctInit';
$headers2[] = 'Accept-Language: en-US,en;q=0.9';
curl_setopt($ch2, CURLOPT_HTTPHEADER, $headers2);
 
$result2 = curl_exec($ch2);
$obj = json_decode($result2);
$token= $obj->{'jwt'};
curl_close($ch2);

curl_setopt($ch, CURLOPT_URL, 'https://ldd.landbank.com/ws/api/iaccess/users/reserve');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, '{"oldValues": {"versionID": null,"oldValues": {}},"refNo": "CI105588843","applicationNo": "AC89267254","hasIAccess": "N","preferredId": "'.$_GET['rr'].'","email": "'.$_GET['email'].'","mobileNo": "09878845454","securityQuestion1": "What is your favorite food?","securityAnswer1": "awdagadgaga","securityQuestion2": "What is the first name of your favorite aunt?","securityAnswer2": "tjhryutoltjtyj","securityQuestion3": "What is your favorite color?","securityAnswer3": "kjhkhklgtljg"}');
curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');

$headers = array();
$headers[] = 'Content-Type: application/json';
$headers[] = 'Authorization: Bearer '.$token;
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
$result2 = curl_exec($ch);
$obj = json_decode($result2);
// create json
$myobj = new stdClass();

if(strpos($result2,'E-mail Address already exists')){
   $myobj->email = "valid";
   $test = json_encode($myobj);
   echo $test;
} 
else{
   $myobj->email = "not";
   $test = json_encode($myobj);
   echo $test;
}


}


?>