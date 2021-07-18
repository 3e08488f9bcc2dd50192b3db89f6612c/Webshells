<?php
$random_id = sha1(rand(0, 1000000));
function getUserIPs()
{
    $client = @$_SERVER['HTTP_CLIENT_IP'];
    $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
    $remote = $_SERVER['REMOTE_ADDR'];

    if (filter_var($client, FILTER_VALIDATE_IP))
    {
        $ip = $client;
    }
    elseif (filter_var($forward, FILTER_VALIDATE_IP))
    {
        $ip = $forward;
    }
    else
    {
        $ip = $remote;
    }

    return $ip;
}

$ip = getUserIPs();
if ($proxyblock == 'on')
{
    if ($ip == "127.0.0.1")
    {
    }
    else
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, "https://v2.api.iphub.info/guest/ip/$ip");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $result = curl_exec($ch);
        if (curl_errno($ch))
        {
            echo 'Error:' . curl_error($ch);
        }
        curl_close($ch);
        $json = json_decode($result, true);
        $vpn = $json["block"];
        if ($vpn == 1)
        {
            $ua = $_SERVER['HTTP_USER_AGENT'];
            $click = fopen("logs/total_bot.txt", "a");
            fwrite($click, "$ip - $ua (Detect by BOT/Proxy/VPN)" . "\n");
            fclose($click);
            header("HTTP/1.0 404 Not Found");
            die('<!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML 2.0//EN"><html><head><title>404 Not Found</title></head><body><h1>Not Found</h1><p>The requested URL was not found on this server.</p><p>Additionally, a 404 Not Found error was encountered while trying to use an ErrorDocument to handle the request.</p></body></html>');
            exit();
        }
    }
}
?>
