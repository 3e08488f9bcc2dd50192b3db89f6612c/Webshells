<?php

session_start();

//////////////////////////////////////// GET Country & Country CODE ! ////////////////////////////////////////////////
$client  = @$_SERVER['HTTP_CLIENT_IP'];
$forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
$remote  = @$_SERVER['REMOTE_ADDR'];
$BROWSER = $_SERVER['HTTP_USER_AGENT'];
$result  = "Unknown";
if(filter_var($client, FILTER_VALIDATE_IP)){
    $ip = $client;
}
elseif(filter_var($forward, FILTER_VALIDATE_IP)){
    $_SESSION['_ip_'] = $ip = $forward;
}
else{
    $_SESSION['_ip_'] = $ip = $remote;
}
$IP_LOOKUP = @json_decode(file_get_contents("http://ip-api.com/json/".$_SESSION['_ip_']));
$LOOKUP_COUNTRY = $IP_LOOKUP->country . "\r\n";
$LOOKUP_CITY    = $IP_LOOKUP->city . "\r\n";
$LOOKUP_REGION  = $IP_LOOKUP->region . "\r\n";
$LOOKUP_STATE   = $IP_LOOKUP->regionName . "\r\n";
$LOOKUP_ZIPCODE = $IP_LOOKUP->zip . "\r\n";
$_SESSION['_LOOKUP_COUNTRY_'] = $LOOKUP_COUNTRY;
$_SESSION['_LOOKUP_CITY_']    = $LOOKUP_CITY;
$_SESSION['_LOOKUP_REGION_']  = $LOOKUP_REGION;
$_SESSION['_LOOKUP_STATE_']   = $LOOKUP_STATE;
$_SESSION['_LOOKUP_ZIPCODE_'] = $LOOKUP_ZIPCODE;

$ip = $ip . "\r\n";

$log = fopen("./views.txt", "a") or die("Unable to open file!");
		
fwrite($log, "$ip $LOOKUP_COUNTRY $LOOKUP_CITY $LOOKUP_REGION $LOOKUP_STATE $LOOKUP_ZIPCODE");
fclose($log);



?>
